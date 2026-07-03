<?php

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

require_once "../db.php";

// 1. Busca dados no banco (Configurações do MS eFazenda)
$stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'MS' LIMIT 1");
$stmt->execute();
$confMS = $stmt->fetch();
$dadosMS = json_decode($confMS['dados'] ?? '{}', true);

$session_initial = $dadosMS['session'] ?? '';
$referer_base = $dadosMS['referer'] ?? 'https://servicos.efazenda.ms.gov.br/ipvapublico/Home/Index';

if (empty($_GET['renavam']) || empty($_GET['placa'])) {
    echo json_encode(["IsStatus" => false, "error" => "Placa e Renavam obrigatorios"]);
    exit;
}

$placa = strtoupper(trim($_GET['placa']));
$renavam = trim($_GET['renavam']);

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
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$key&method=userrecaptcha&googlekey=$sitekey&pageurl=$pageurl");
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

// 2. Resolver Captcha (reCAPTCHA v2)
$sitekey = '6LeRXNwrAAAAAHykZ8dUvsrircjCJ2F-mx7Byu0X';
// Tenta usar a chave da conta 2captcha se estiver configurada, senao usa uma default para teste (ou falha)
$captchaKey = '4f16550cac01fcf36238f2e4007822e8'; // Mesma chave usada no buscarES.php
$token = solveCaptcha($captchaKey, $sitekey, $referer_base);

if (!$token) {
    echo json_encode(["IsStatus" => false, "error" => "Falha ao resolver o captcha. Verifique o 2Captcha."]);
    exit;
}

// 3. POST para consultar débitos
$ch = curl_init('https://servicos.efazenda.ms.gov.br/ipvapublico/Home');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
apply_proxy_to_curl($ch);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
    'Content-Type: application/x-www-form-urlencoded',
    'Origin: https://servicos.efazenda.ms.gov.br',
    'Referer: ' . $referer_base,
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36'
]);
curl_setopt($ch, CURLOPT_COOKIE, $session_initial);

$payload = http_build_query([
    "Placa" => $placa,
    "Renavam" => $renavam,
    "g-recaptcha-response" => $token
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$html = curl_exec($ch);
$info = curl_getinfo($ch);

if (strpos($html, 'Identificamos débitos') === false && strpos($html, 'Não foram encontrados débitos') === false) {
    // Verificar se houve erro de validação no HTML
    if (strpos($html, 'field-validation-error') !== false) {
        echo json_encode(["IsStatus" => false, "error" => "Placa ou Renavam inválidos ou erro na consulta."]);
    } else {
        echo json_encode(["IsStatus" => false, "error" => "Tente novamente daqui a 10 minutos, o sistema está congestionado."]);
        // Incrementar contador de expirado
        $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'MS'")->execute();
    }
    exit;
}

// 4. Scraping dos dados (DOM Parser)
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
$xpath = new DOMXPath($dom);
$resultado = [];

// Extrair Marca/Modelo
$modelo = "VEÍCULO MS";
$nodesHeader = $xpath->query("//div[contains(@class, 'card-veiculo-header-item')]");
if ($nodesHeader->length >= 2) {
    $txtModelo = $nodesHeader->item(1)->textContent;
    $modelo = trim(str_replace('Marca/Modelo', '', $txtModelo));
}

// Extrair Débitos
$linhas = $xpath->query("//div[contains(@class, 'card-imposto-parcelas-valores')]");

foreach ($linhas as $linha) {
    $checkbox = $xpath->query(".//input[@type='checkbox']", $linha)->item(0);
    if (!$checkbox) continue;
    
    $guid = $checkbox->getAttribute('id');
    $valorRaw = $checkbox->getAttribute('value');
    
    $cols = $xpath->query(".//span[contains(@class, 'font-main')]", $linha);
    
    // Tentativa de pegar a descrição (ex: 2026 - 1º Parcela)
    // Procurar o título do bloco anterior
    $boxImposto = $linha->parentNode->parentNode;
    $tituloAno = "Débito";
    $nodeTitulo = $xpath->query(".//span[contains(@class, 'text-color-fundo-claro-mediumlarge')]", $boxImposto);
    if ($nodeTitulo->length > 0) {
        $tituloAno = trim($nodeTitulo->item(0)->textContent);
    }

    $parcela = "";
    if ($cols->length > 0) {
        $parcela = trim($cols->item(0)->textContent);
    }
    
    $vencimento = "";
    if ($cols->length > 1) {
        $vencimento = trim($cols->item(1)->textContent);
    }

    $resultado[] = [
        "guid"            => $guid,
        "descricao"       => "$tituloAno - $parcela Parcela",
        "data_vencimento" => $vencimento,
        "situacao"        => "ABERTO",
        "nominal"         => limparValor($valorRaw),
        "atual"           => limparValor($valorRaw)
    ];
}

echo json_encode([
    "IsStatus" => true, 
    "proprietario" => $modelo, // Usando modelo como fallback se nao achar proprietario
    "dados" => $resultado
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
