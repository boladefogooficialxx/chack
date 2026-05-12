<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../../db.php";

$idDom = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : null;
$status = isset($_GET['status']) ? trim($_GET['status']) : null;

$allowed_status = ['ativo', 'inativo'];

if (!$idDom || !$status || !in_array($status, $allowed_status)) {
    echo json_encode(['status' => false, 'message' => 'Parâmetros inválidos']);
    exit;
}

try {
    $update = $pdo->prepare("UPDATE dominios SET `status` = :status WHERE id_dominio = :id");
    $update->bindParam(':status', $status, PDO::PARAM_STR);
    $update->bindParam(':id', $idDom, PDO::PARAM_INT);

    if ($update->execute()) {
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Erro ao atualizar']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => false, 'message' => $e->getMessage()]);
}
?>
