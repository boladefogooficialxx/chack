<?php


extract($_GET);  

if(!$documento){
    echo json_encode(['error' => 'documento é obrigatório']);
    exit;
}

require_once "../db.php";

function Notifications($mensagem){
    global $pdo;

    $criado_em = date('Y/m/d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO notificacoes (mensagem, criado_em) VALUES (:mensagem, :criado_em)");
    $stmt->execute([':mensagem' => "$mensagem - $criado_em", ':criado_em' => $criado_em]);

    $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
    $updateStmt->execute([':audio' => 5, ':atual' => rand(100000000, 99999999999), ':hora' => $criado_em, ':id' => 1]);
}

$Glob = $pdoGlob->query("SELECT dados FROM conf WHERE tela = 'IPSP' LIMIT 1")->fetchColumn();

$GlobDados = json_decode($Glob, true);
$dados = json_decode($GlobDados['dados'], true);

// Configurações globais
$session = $dados['cookies']; 

header('Content-Type: application/json');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://pixveiculos.fazenda.sp.gov.br/auth/api/Debitos/BuscarDebitosDocumento?documento=$documento&tipoDocumento=R&recaptcha=&codigoServico=8");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json, text/plain, */*',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'access-control-allow-credentials: true',
    'access-control-allow-headers: Origin, X-Requested-With, Content-Type, Accept',
    'access-control-allow-methods: GET, POST, PUT, DELETE',
    'access-control-allow-origin: *',
    'authorization: Bearer '.$session,
    'cache-control: no-cache',
    'content-type: application/json',
    'pragma: no-cache',
    'priority: u=1, i',
    'referer: https://pixveiculos.fazenda.sp.gov.br/pix/buscar-debitos',
    'request-context: appId=cid-v1:581014a6-faae-46e6-9146-c57f22a866ab',
    'request-id: |04d1f4d26ccd441abc00ac44f7e5ff6c.98e2c2be8ced4c56',
    'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Microsoft Edge";v="146"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'traceparent: 00-04d1f4d26ccd441abc00ac44f7e5ff6c-98e2c2be8ced4c56-01',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0',
]);

$response = curl_exec($ch);


if($response){

$responseArray = json_decode($response);

    curl_close($ch);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://pixveiculos.fazenda.sp.gov.br/auth/api/Debitos/BuscarDebitosDocumento?documento=$documento&tipoDocumento=R&recaptcha=&codigoServico=2");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json, text/plain, */*',
        'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
        'access-control-allow-credentials: true',
        'access-control-allow-headers: Origin, X-Requested-With, Content-Type, Accept',
        'access-control-allow-methods: GET, POST, PUT, DELETE',
        'access-control-allow-origin: *',
        'authorization: Bearer '.$session,
        'cache-control: no-cache',
        'content-type: application/json',
        'pragma: no-cache',
        'priority: u=1, i',
        'referer: https://pixveiculos.fazenda.sp.gov.br/pix/buscar-debitos',
        'request-context: appId=cid-v1:581014a6-faae-46e6-9146-c57f22a866ab',
        'request-id: |04d1f4d26ccd441abc00ac44f7e5ff6c.98e2c2be8ced4c56',
        'sec-ch-ua: "Chromium";v="146", "Not-A.Brand";v="24", "Microsoft Edge";v="146"',
        'sec-ch-ua-mobile: ?0',
        'sec-ch-ua-platform: "Windows"',
        'sec-fetch-dest: empty',
        'sec-fetch-mode: cors',
        'sec-fetch-site: same-origin',
        'traceparent: 00-04d1f4d26ccd441abc00ac44f7e5ff6c-98e2c2be8ced4c56-01',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0',
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    if($response) {

        if($responseArray){

            $responseArray->servicos;

            $responseArrayLicenciamento = json_decode($response);

            if($responseArrayLicenciamento->servicos){
                for ($i=0; $i < count($responseArrayLicenciamento->servicos); $i++) { 
                    $responseArray->servicos[] = $responseArrayLicenciamento->servicos[$i];
                }
            }

            $response = json_encode($responseArray);

        }
    }

}


if (stripos($response, '"nomeProprietario"') !== false) {

    echo json_encode(['IsStatus' => true, 'response' => json_decode($response)]);

    exit;
}else {

    echo json_encode(['IsStatus' => false, 'response' => $response]);

    if(!$response){
        Notifications("Sessao expirada. Favor atualizar o token.");
    }

    exit;
}