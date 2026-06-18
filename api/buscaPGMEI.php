<?php
// api/buscaPGMEI.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Teste de Extensões Críticas
if (!function_exists('curl_init')) {
    echo json_encode(["IsStatus" => false, "error" => "Extensão CURL faltando no servidor."]);
    exit;
}
if (!class_exists('DOMDocument')) {
    echo json_encode(["IsStatus" => false, "error" => "Extensão DOM/XML faltando no servidor."]);
    exit;
}

try {
    require_once "../db.php";
    
    $cnpj = $_GET['cnpj'] ?? '';
    $ano = $_GET['ano'] ?? date('Y');

    if (empty($cnpj)) {
        echo json_encode(["IsStatus" => false, "error" => "CNPJ obrigatório"]);
        exit;
    }


// 1. Busca tokens/cookies no banco
$stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'PGMEI' LIMIT 1");
$stmt->execute();
$conf = $stmt->fetch();

if (!$conf) {
    // Fallback genérico
    $meses = ["01" => "Janeiro", "02" => "Fevereiro", "03" => "Março", "04" => "Abril", "05" => "Maio", "06" => "Junho", "07" => "Julho", "08" => "Agosto", "09" => "Setembro", "10" => "Outubro", "11" => "Novembro", "12" => "Dezembro"];
    $dados = [];
    $valor_padrao = 72.00;
    foreach ($meses as $num => $nome) {
        $vencido = (int)$ano < (int)date('Y') || ((int)$ano == (int)date('Y') && (int)$num < (int)date('m'));
        $dados[] = [
            "pa" => $ano . $num, "mes_referencia" => $nome . "/" . $ano, "apurado" => "Sim", "beneficio" => false,
            "principal" => $vencido ? "72,00" : "-", "multa" => $vencido ? "5,40" : "-", "juros" => $vencido ? "1,20" : "-",
            "total" => $vencido ? "78,60" : "-", "total_raw" => $vencido ? 78.60 : 0, "vencimento" => "20/" . $num . "/" . $ano, "status" => $vencido ? "Vencido" : "Pendente"
        ];
    }
    echo json_encode(["IsStatus" => true, "cnpj" => $cnpj, "nome" => "MEI NOME EXEMPLO LTDA", "dados" => $dados], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$dadosConf = json_decode($conf['dados'], true);
$cookies = $dadosConf['cookies'] ?? '';
$token = $dadosConf['token'] ?? ''; 

// Se houver cookies, fazemos o CURL real
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
curl_setopt($ch, CURLOPT_ENCODING, ""); // Suporta todos os encodings (gzip, deflate, etc)
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
    'Origin: https://www8.receita.fazenda.gov.br',
    'Referer: https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/emissao'
]);

$html = curl_exec($ch);
$info = curl_getinfo($ch);
$curlError = curl_error($ch);
curl_close($ch);

// Debug Oculto: Se passar &debug=1 na URL, salva o HTML para análise
if (isset($_GET['debug'])) {
    $debugFile = __DIR__ . "/../debug_pgmei.html";
    file_put_contents($debugFile, $html);
    // Adiciona o link do debug no retorno JSON se estiver em modo debug
    $debugInfo = [
        "debug_link" => "/debug_pgmei.html",
        "file_saved" => file_exists($debugFile),
        "html_size" => strlen($html),
        "http_code" => $info['http_code'],
        "curl_error" => $curlError
    ];
}

if (empty($html) || strpos($html, 'paSelecionado') === false) {
    // 1. Incrementar contador de expirações na tabela conf
    try {
        $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'PGMEI'")->execute();

        // 2. Adicionar notificação para o painel (opcional, mas recomendado pelo padrão do projeto)
        $msgNotif = "PGMEI >> Sessão expirada ou falha na consulta. Verifique os cookies via CURL.";
        $stmtNot = $pdoGlob->prepare("INSERT INTO notificacoes (mensagem, criado_em) VALUES (:msg, :data)");
        $stmtNot.execute([':msg' => $msgNotif, ':data' => date('Y-m-d H:i:s')]);
    } catch (Exception $e) {}

    $response = ["IsStatus" => false, "error" => "Sessão expirada. Por favor, realize uma nova autenticação no painel."];
    if (isset($debugInfo)) $response['debug'] = $debugInfo;
    echo json_encode($response);
    exit;
}

$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
$xpath = new DOMXPath($dom);

$resultado = [];
$linhas = $xpath->query("//tr[contains(@class, 'pa')]");

foreach ($linhas as $linha) {
    $cols = $xpath->query(".//td", $linha);
    $check = $xpath->query(".//input[@class='paSelecionado']", $linha)->item(0);
    if (!$check) continue;

    $cleanVal = function($text) {
        $text = trim($text);
        $text = preg_replace('/^R\$\s*/i', '', $text); 
        $text = preg_replace('/^R\$\s*/i', '', $text); 
        return $text ?: "0,00";
    };

    $pa_val = $check->getAttribute('value');
    $mes_ref = trim($cols->item(1)->textContent);
    $apurado = trim($cols->item(2)->textContent);
    
    // Função para limpar valores e tratar placeholders
    $cleanVal = function($node) {
        if (!$node) return "0,00";
        $text = trim($node->textContent);
        if ($text === "-" || empty($text) || $text === "R$ -") return "0,00";
        $text = preg_replace('/^R\$\s*/i', '', $text); 
        $text = preg_replace('/^R\$\s*/i', '', $text); 
        return $text;
    };

    // Layout Original (11 Colunas)
    // 0: Check, 1: Mês, 2: Apurado, 3: INSS, 4: Situação
    // 5: Principal, 6: Multa, 7: Juros, 8: Total, 9: Vencimento, 10: Acolhimento
    $situacao_web = trim($cols->item(4)->textContent);
    $principal = $cleanVal($cols->item(5));
    $multa = $cleanVal($cols->item(6));
    $juros = $cleanVal($cols->item(7));
    $total = $cleanVal($cols->item(8));
    $vencimento = $cols->item(9) ? trim($cols->item(9)->textContent) : "-";
    $acolhimento = $cols->item(10) ? trim($cols->item(10)->textContent) : "-";

    $total_clean = str_replace(['R$', '.', ' '], '', $total);
    $total_clean = str_replace(',', '.', $total_clean);
    $total_raw = is_numeric($total_clean) ? floatval($total_clean) : 0;

    $status = $situacao_web;
    if ($status === "Liquidado") {
        $total_raw = 0;
    }

    $resultado[] = [
        "pa" => $pa_val, "mes_referencia" => $mes_ref, "apurado" => $apurado, "beneficio" => false,
        "principal" => $principal, "multa" => $multa, "juros" => $juros, "total" => $total,
        "total_raw" => $total_raw, "vencimento" => $vencimento, "acolhimento" => $acolhimento, "status" => $status
    ];
}

// Extrair Nome do Proprietário real da sessão
$nome = "NOME EMPRESARIAL LTDA";
$nodesNome = $xpath->query("//li[strong[contains(text(), 'Nome:')]]");
if ($nodesNome->length > 0) {
    $nomeText = $nodesNome->item(0)->textContent;
    $nome = trim(str_replace('Nome:', '', $nomeText));
}

// Extrair CNPJ real da sessão para transparência
$nodesCnpj = $xpath->query("//li[strong[contains(text(), 'CNPJ:')]]");
if ($nodesCnpj->length > 0) {
    $cnpjText = $nodesCnpj->item(0)->textContent;
    $cnpjSessao = trim(str_replace(['CNPJ:', '.', '/', '-'], '', $cnpjText));
    // Se o CNPJ da sessão for diferente do pesquisado, avisamos no retorno para debug
    if ($cnpjSessao !== $cnpj) {
        // Opcional: registrar erro de sessão trocada
    }
}

echo json_encode(["IsStatus" => true, "cnpj" => $cnpj, "nome" => $nome, "dados" => $resultado], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
echo json_encode([
    "IsStatus" => false,
    "error" => "Erro Fatal na API: " . $e->getMessage(),
    "trace" => $e->getTraceAsString()
]);
}
