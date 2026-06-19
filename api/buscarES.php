<?php

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

require_once "../db.php";

// 1. Busca dados no banco
$stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'ES' LIMIT 1");
$stmt->execute();
$confES = $stmt->fetch();
$dadosES = json_decode($confES['dados'], true);

$session_initial = $dadosES['session'] ?? '';
$referer_base = $dadosES['referer'] ?? 'https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaIpva';

if (empty($_GET['renavam']) || empty($_GET['placa'])) {
    echo json_encode(["IsStatus" => false, "error" => "Placa e Renavam obrigatorios"]);
    exit;
}

$placa = $_GET['placa'];
$renavam = $_GET['renavam'];

// Criar um arquivo temporário para os cookies desta sessão
$cookieFile = tempnam(sys_get_temp_dir(), 'cook_es_');

// Funções utilitárias
function getStr($str, $start, $end) {
    $parts = explode($start, $str);
    if (count($parts) < 2) return false;
    $parts2 = explode($end, $parts[1]);
    return $parts2[0];
}

function limparValor($valor) {
    $valor = trim($valor);
    $valor = str_replace(["R$", ".", " "], "", $valor);
    $valor = str_replace(",", ".", $valor);
    return is_numeric($valor) ? floatval($valor) : 0;
}

function solveCaptcha($key, $sitekey, $pageurl) {
    $ch = curl_init("https://2captcha.com/in.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$key&method=turnstile&sitekey=$sitekey&pageurl=$pageurl");
    $res = curl_exec($ch);
    if (strpos($res, 'OK') !== false) {
        $id = explode('|', $res)[1];
        for ($i = 0; $i < 40; $i++) {
            $ch2 = curl_init("https://2captcha.com/res.php?key=$key&action=get&id=$id");
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $res2 = curl_exec($ch2);
            if (strpos($res2, 'OK') !== false) return explode('|', $res2)[1];
            sleep(3);
        }
    }
    return false;
}

// 1. Resolver Captcha Primeiro (Turnstile fresco)
$token = solveCaptcha('4f16550cac01fcf36238f2e4007822e8', '0x4AAAAAAAy6XXSbwPTDYHHM', $referer_base);

if (!$token) {
    unlink($cookieFile);
    echo json_encode(["IsStatus" => false, "error" => "Falha ao resolver o captcha. Verifique o 2Captcha."]);
    exit;
}

// 2. Tentar POST direto
$ch = curl_init('https://servicos.detrannet.es.gov.br/CentralVeiculo/ConsultarVeiculo');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json, text/plain, */*',
    'Content-Type: application/json',
    'Origin: https://servicos.detrannet.es.gov.br',
    'Referer: ' . $referer_base,
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36',
    'X-Requested-With: XMLHttpRequest',
    'sec-ch-ua: "Chromium";v="148", "Google Chrome";v="148", "Not/A)Brand";v="99"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "macOS"'
]);
curl_setopt($ch, CURLOPT_COOKIE, $session_initial); 
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);

$payload = json_encode([
    "Servico" => "EmitirDuaIpva",
    "Placa" => $placa,
    "Renavam" => $renavam,
    "TurnstileToken" => $token,
    "VeiculoOutraUf" => false
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$resPost = curl_exec($ch);
$dadosPost = json_decode($resPost, true);

// Fallback se precisar de CpfAcessoCidadao
if (!isset($dadosPost['redirectUrl'])) {
    $chInit = curl_init($referer_base);
    curl_setopt($chInit, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chInit, CURLOPT_COOKIE, $session_initial);
    curl_setopt($chInit, CURLOPT_COOKIEJAR, $cookieFile);
    $resInit = curl_exec($chInit);
    $CpfAcessoCidadao = getStr($resInit, 'hdCpfAcessoCidadao" value="', '"');
    
    if ($CpfAcessoCidadao) {
        $payloadObj = json_encode([
            "Servico" => ["TipoServico" => "EmitirDuaIpva", "CpfAcessoCidadao" => $CpfAcessoCidadao],
            "Placa" => $placa, "Renavam" => $renavam, "TurnstileToken" => $token, "VeiculoOutraUf" => false
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadObj);
        $resPost = curl_exec($ch);
        $dadosPost = json_decode($resPost, true);
    }
}

if (!isset($dadosPost['redirectUrl'])) {
    unlink($cookieFile);
    $msg = $dadosPost['errorMessage'] ?? $dadosPost['mensagem'] ?? "Sua sessão expirou ou o veículo não foi encontrado.";
    
    // Se a mensagem contiver "sessão expirou", incrementa o contador e notifica o painel
    if (stripos($msg, 'sessão expirou') !== false) {
        try {
            // Incrementa o contador na tabela conf
            $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'ES'")->execute();
            
            // Adiciona um alerta na tabela notificacoes
            $stmtNot = $pdoGlob->prepare("INSERT INTO notificacoes (mensagem) VALUES (:msg)");
            $stmtNot->execute([':msg' => "ES >> Erro: Sua sessão expirou. Por favor, autentique-se novamente."]);

            // Dispara alerta sonoro e força refresh no painel administrativo
            $updateStmt = $pdoGlob->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
            $updateStmt->execute([
                ':audio' => 5,
                ':atual' => rand(100000000, 99999999999),
                ':hora' => date('Y-m-d H:i:s'),
                ':id' => 1
            ]);
        } catch (Exception $e) {
            // Silenciosamente falha se houver erro no banco (coluna faltando, etc)
        }
    }

    echo json_encode(["IsStatus" => false, "error" => $msg]);
    exit;
}

// 4. GET Debitos
$finalUrl = 'https://servicos.detrannet.es.gov.br' . $dadosPost['redirectUrl'];
$ch = curl_init($finalUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIE, $session_initial); 
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36',
    'Referer: ' . $referer_base,
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
    'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7'
]);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
$curlError = curl_error($ch);
unlink($cookieFile);

// 5. Scraping dos dados
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
$xpath = new DOMXPath($dom);
$resultado = [];

// Nome Proprietário
$nomeProprietario = "";
$nodesNome = $xpath->query("//div[contains(@class, 'es-nav-end')]//div[contains(@class, 'mx-2')] | //div[contains(@class, 'nome-proprietario')]");
if ($nodesNome->length > 0) $nomeProprietario = trim($nodesNome->item(0)->textContent);

$linhas = $xpath->query("//div[contains(@class, 'linha-detalhe')] | //div[contains(@class, 'linha')] | //tr");

foreach ($linhas as $linha) {
    $input = $xpath->query(".//input[@data-guid]", $linha)->item(0);
    if (!$input) continue;
    $cols = $xpath->query(".//div[contains(@class, 'col')] | .//td", $linha);
    
    $resultado[] = [
        "guid"            => $input->getAttribute("data-guid"),
        "descricao"       => preg_replace('/\s+/', ' ', trim($input->getAttribute("data-descricao-debito") ?: ($cols->item(0) ? $cols->item(0)->textContent : ""))),
        "data_vencimento" => $input->getAttribute("data-data-vencimento") ?: ($cols->item(1) ? trim($cols->item(1)->textContent) : ""),
        "situacao"        => $input->getAttribute("data-situacao-exibicao"),
        "nominal"         => $cols->item(2) ? limparValor($cols->item(2)->textContent) : 0,
        "corrigido"       => $cols->item(3) ? limparValor($cols->item(3)->textContent) : 0,
        "desconto"        => $cols->item(4) ? limparValor($cols->item(4)->textContent) : 0,
        "juros"           => $cols->item(5) ? limparValor($cols->item(5)->textContent) : 0,
        "multa"           => $cols->item(6) ? limparValor($cols->item(6)->textContent) : 0,
        "atual"           => $cols->item(7) ? limparValor($cols->item(7)->textContent) : limparValor($input->getAttribute("data-valor-atualizado"))
    ];
}

echo json_encode([
    "IsStatus" => true, 
    "proprietario" => $nomeProprietario,
    "dados" => $resultado,
    "debug" => [
        "http_code" => $httpCode,
        "curl_error" => $curlError,
        "final_url" => $effectiveUrl,
        "html_size" => strlen($html),
        "rows_found" => $linhas->length,
        "html_snippet" => substr(strip_tags($html), 0, 500)
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
