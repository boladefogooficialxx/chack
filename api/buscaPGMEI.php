<?php
// api/buscaPGMEI.php - Versão Super Stealth com Diagnóstico

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

require_once __DIR__ . "/../db.php";

$cnpj = $_GET['cnpj'] ?? '';
$ano = $_GET['ano'] ?? date('Y');

if (empty($cnpj)) {
    echo json_encode(["IsStatus" => false, "error" => "CNPJ obrigatório"]);
    exit;
}

$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

try {
    $stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'PGMEI' LIMIT 1");
    $stmt->execute();
    $conf = $stmt->fetch();

    if (!$conf) {
        echo json_encode(["IsStatus" => false, "error" => "Configuração não encontrada."]);
        exit;
    }

    $dadosConf = json_decode($conf['dados'], true);
    $cookies = $dadosConf['cookies'] ?? '';
    $token = $dadosConf['token'] ?? ''; 

    $ch = curl_init('https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "__RequestVerificationToken=$token&ano=$ano");
    curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br"); 
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    
    // Cabeçalhos Máximos para evitar Captcha
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "User-Agent: $user_agent",
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cache-Control: max-age=0',
        'Content-Type: application/x-www-form-urlencoded',
        'Origin: https://www8.receita.fazenda.gov.br',
        'Referer: https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Identificacao',
        'Sec-Ch-Ua: "Not_A Brand";v="8", "Chromium";v="120", "Google Chrome";v="120"',
        'Sec-Ch-Ua-Mobile: ?0',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Sec-Fetch-Dest: document',
        'Sec-Fetch-Mode: navigate',
        'Sec-Fetch-Site: same-origin',
        'Sec-Fetch-User: ?1',
        'Upgrade-Insecure-Requests: 1',
        'Connection: keep-alive'
    ]);

    $html = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    // Sempre salva o log de erro na raiz para você analisar
    if (empty($html) || strpos($html, 'paSelecionado') === false) {
        file_put_contents(__DIR__ . "/../debug_pgmei.html", $html);
        
        if (strpos($html, 'hcaptcha') !== false || strpos($html, 'g-recaptcha') !== false || $info['http_code'] == 403) {
            $errorMsg = "Bloqueio de Segurança (Captcha/IP) detectado na Receita Federal. O servidor online está sendo barrado.";
        } else {
            $errorMsg = "Sessão expirada ou resposta inválida. Verifique os cookies.";
        }

        echo json_encode([
            "IsStatus" => false, 
            "error" => $errorMsg,
            "http_code" => $info['http_code'],
            "debug_link" => "/debug_pgmei.html"
        ]);
        exit;
    }

    // Se passou, faz o parse (mesmo código que funciona local)
    $dom = new DOMDocument();
    @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    $xpath = new DOMXPath($dom);
    $resultado = [];
    $linhas = $xpath->query("//tr[contains(@class, 'pa')]");
    foreach ($linhas as $linha) {
        $cols = $xpath->query(".//td", $linha);
        $check = $xpath->query(".//input[@class='paSelecionado']", $linha)->item(0);
        if (!$check) continue;
        $valNode = function($node) {
            if (!$node) return "0,00";
            $t = trim($node->textContent);
            return ($t === "-" || empty($t)) ? "0,00" : preg_replace('/^R\$\s*/i', '', $t);
        };
        $total = $valNode($cols->item(8));
        $status = trim($cols->item(4)->textContent);
        $resultado[] = [
            "pa" => $check->getAttribute('value'), 
            "mes_referencia" => trim($cols->item(1)->textContent), 
            "status" => $status,
            "total" => $total, 
            "total_raw" => ($status === "Liquidado") ? 0 : floatval(str_replace(',','.',str_replace('.','',str_replace('R$','',$total)))),
            "vencimento" => $cols->item(9) ? trim($cols->item(9)->textContent) : "-",
            "principal" => $valNode($cols->item(5)),
            "multa" => $valNode($cols->item(6)),
            "juros" => $valNode($cols->item(7)),
            "apurado" => trim($cols->item(2)->textContent),
            "acolhimento" => $cols->item(10) ? trim($cols->item(10)->textContent) : "-"
        ];
    }
    $nome = "NOME EMPRESARIAL LTDA";
    $nodesNome = $xpath->query("//li[strong[contains(text(), 'Nome:')]]");
    if ($nodesNome->length > 0) $nome = trim(str_replace('Nome:', '', $nodesNome->item(0)->textContent));
    echo json_encode(["IsStatus" => true, "cnpj" => $cnpj, "nome" => $nome, "dados" => $resultado], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode(["IsStatus" => false, "error" => "Erro: " . $e->getMessage()]);
}
