<?php
require_once "../../db.php";

header('Content-Type: application/json');

$ref = $_GET['ref'] ?? null;

if ($ref === null || $ref === '') {
    echo json_encode(['status' => 'error', 'message' => 'Referência não informada']);
    exit;
}

try {
    if (is_numeric($ref) && strlen($ref) < 10) {
        $stmt = $pdo->prepare("SELECT status FROM table_data WHERE id = ? OR ref = ? OR cod = ? LIMIT 1");
        $stmt->execute([$ref, $ref, $ref]);
    } else {
        $stmt = $pdo->prepare("SELECT status FROM table_data WHERE ref = ? OR cod = ? LIMIT 1");
        $stmt->execute([$ref, $ref]);
    }
    $result = $stmt->fetch();

    if ($result) {
        echo json_encode(['status' => 'success', 'payment_status' => $result['status']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transação não encontrada']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
