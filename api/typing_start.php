<?php
require '../db.php';
date_default_timezone_set('America/Sao_Paulo');

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? null;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit;
}

try {
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
