<?php
// deletar_notificacao.php
header('Content-Type: application/json');
require '../../db.php';

$input = json_decode(file_get_contents('php://input'), true);
$id = (int)($input['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM notificacoes WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount()) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Notificação não encontrada']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao deletar: ' . $e->getMessage()]);
}
?>
