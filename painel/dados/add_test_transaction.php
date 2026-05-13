<?php

session_start();

error_reporting(0);

require_once '../../db.php';
require_once '../../base/utility.php';
require_once '../classes/TestTransactionCreator.php';

header('Content-Type: application/json');

$token = $_SESSION['token'] ?? null;

if (!$token) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE token = :token LIMIT 1");
$stmt->execute([':token' => $token]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
    exit();
}

$ip = getClientIp();
$ipInfo = getFromIp($ip);
$pais = $ipInfo->country ?? 'Desconhecido';

$creator = new TestTransactionCreator($pdo);
echo json_encode($creator->create($user, $ip, $pais), JSON_UNESCAPED_UNICODE);
exit();
