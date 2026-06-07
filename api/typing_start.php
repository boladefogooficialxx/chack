<?php
require '../db.php';
date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? null;
$action = $_GET['action'] ?? 'typing';
$ref = $_GET['ref'] ?? null;

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

    echo json_encode([
        'success' => true,
        'hora' => date('Y-m-d H:i:s')
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
