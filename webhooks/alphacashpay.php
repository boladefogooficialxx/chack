<?php

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

error_reporting(0);

// Conexão com banco
$pdo = new PDO("mysql:host=db;dbname=chak;charset=utf8", "bit", "Flipmoney123#", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Função de log
function log_mp($data) {
    file_put_contents(__DIR__ . '/webhook.log', date('c') . ' ' . $data . PHP_EOL, FILE_APPEND);
}

// Receber webhook
$body = file_get_contents('php://input');
$headers = getallheaders();
log_mp("Headers: " . json_encode($headers));
log_mp("Body: " . $body);

// Decodificar JSON
$data = json_decode($body, true);
if (!$data) {
    http_response_code(400);
    echo 'Invalid JSON';
    exit;
}

// Extrair payment_id
$paymentId = $data['data']['id'] ?? null;
if (!$paymentId) {
    http_response_code(200);
    echo 'No payment id';
    exit;
}

// Extrair dados do pagamento
$paymentData    = $data['data'];
$status         = $paymentData['status'] ?? null;
$amount         = $paymentData['amount'] ?? null;
$currency       = $paymentData['currency'] ?? null;
$paymentMethod  = $paymentData['paymentMethod'] ?? null;

$externalRef    = $paymentData['externalRef'] ?? null;

$externalRef = $_GET['id'] ?? null;

// Dados do cliente
$customer       = $paymentData['customer'] ?? [];
$customerName   = $customer['name'] ?? null;
$email          = $customer['email'] ?? null;
$phone          = $customer['phone'] ?? null;

// Informações do PIX
$pixData        = $paymentData['pix'] ?? [];
$pixQrcode      = $pixData['qrcode'] ?? null;
$pixExpiration  = $pixData['expirationDate'] ?? null;
if ($pixExpiration) {
    $pixExpiration = substr($pixExpiration, 0, 10); // só data (YYYY-MM-DD)
}

// Produto (item) - assumindo 1 item
$item           = $paymentData['items'][0] ?? [];
$itemTitle      = $item['title'] ?? null;
$itemExternalRef= $item['externalRef'] ?? null;
$itemUnitPrice  = $item['unitPrice'] ?? null;
$ref = $item['id'] ?? null;

if($status=='paid'){

    $updateStmt = $pdo->prepare("UPDATE table_data SET status = :status WHERE ref = :ref");
    $updateStmt->execute([
        ':status' => 'pago',
        ':ref' => $ref,
    ]);
    
    $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual WHERE id = :id");
    $updateStmt->execute([
        ':audio' => 4,
        ':atual' => rand(100000000, 99999999999),
        ':id' => 1
    ]);
}

http_response_code(200);
echo 'OK';
