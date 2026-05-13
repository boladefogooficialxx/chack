<?php

session_start();

error_reporting(0);

require_once '../../db.php';
require_once '../../base/utility.php';
require_once '../classes/TestTransactionCreator.php';

$token = $_SESSION['token'] ?? null;

if (!$token) {
    header('Location: ../index.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE token = :token LIMIT 1");
$stmt->execute([':token' => $token]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: ../index.php');
    exit();
}

$ip = getClientIp();
$ipInfo = getFromIp($ip);
$pais = $ipInfo->country ?? 'Desconhecido';

$creator = new TestTransactionCreator($pdo);
$result = $creator->create($user, $ip, $pais);

if (
    isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
) {
    header('Content-Type: application/json');
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit();
}

header('Location: ../index.php?test_transaction=' . ($result['success'] ? 'success' : 'error'));
exit();
