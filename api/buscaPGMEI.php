<?php
// api/buscaPGMEI.php - Versão Limpa Produção

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

try {
    // 1. Busca tokens/cookies no banco
    $stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'PGMEI' LIMIT 1");
    $stmt->execute();
    $conf = $stmt->fetch();

    if (!$conf) {
        echo json_encode(["IsStatus" => false, "error" => "Configuração PGMEI não encontrada no banco."]);
        exit;
    }

    $dadosConf = json_decode($conf['dados'], true);
    $cookies = $dadosConf['cookies'] ?? '';
    $token = $dadosConf['token'] ?? ''; 

    // 2. Requisição CURL
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
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
        'Referer: https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao'
    ]);

    $html = curl_exec($ch);
    curl_close($ch);

    // 3. Verificação de Sessão
    if (empty($html) || strpos($html, 'paSelecionado') === false) {
        // Atualiza contador de expirado de forma simples
        $stmtUp = $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'PGMEI'");
        $stmtUp->execute();
        
        echo json_encode(["IsStatus" => false, "error" => "Sessão expirada. Por favor, realize uma nova autenticação no painel."]);
        exit;
    }

    // 4. Parse do HTML
    $dom = new DOMDocument();
    @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    $xpath = new DOMXPath($dom);

    $resultado = [];
    $linhas = $xpath->query("//tr[contains(@class, 'pa')]");

    foreach ($linhas as $linha) {
        $cols = $xpath->query(".//td", $linha);
        $check = $xpath->query(".//input[@class='paSelecionado']", $linha)->item(0);
        if (!$check) continue;

        $pa_val = $check->getAttribute('value');
        $mes_ref = trim($cols->item(1)->textContent);
        $status = trim($cols->item(4)->textContent);
        
        // Função de limpeza de valores
        $valNode = function($node) {
            if (!$node) return "0,00";
            $t = trim($node->textContent);
            if ($t === "-" || empty($t) || $t === "R$ -") return "0,00";
            return preg_replace('/^R\$\s*/i', '', $t);
        };

        $total = $valNode($cols->item(8));
        $total_clean = str_replace(['R$', '.', ' '], '', $total);
        $total_clean = str_replace(',', '.', $total_clean);
        $total_raw = is_numeric($total_clean) ? floatval($total_clean) : 0;
        if ($status === "Liquidado") $total_raw = 0;

        $resultado[] = [
            "pa" => $pa_val, 
            "mes_referencia" => $mes_ref, 
            "apurado" => trim($cols->item(2)->textContent), 
            "principal" => $valNode($cols->item(5)), 
            "multa" => $valNode($cols->item(6)), 
            "juros" => $valNode($cols->item(7)), 
            "total" => $total, 
            "total_raw" => $total_raw, 
            "vencimento" => $cols->item(9) ? trim($cols->item(9)->textContent) : "-", 
            "acolhimento" => $cols->item(10) ? trim($cols->item(10)->textContent) : "-", 
            "status" => $status
        ];
    }

    $nome = "NOME EMPRESARIAL LTDA";
    $nodesNome = $xpath->query("//li[strong[contains(text(), 'Nome:')]]");
    if ($nodesNome->length > 0) {
        $nome = trim(str_replace('Nome:', '', $nodesNome->item(0)->textContent));
    }

    echo json_encode(["IsStatus" => true, "cnpj" => $cnpj, "nome" => $nome, "dados" => $resultado], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode(["IsStatus" => false, "error" => "Erro na consulta: " . $e->getMessage()]);
}
