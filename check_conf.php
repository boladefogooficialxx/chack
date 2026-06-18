<?php
require_once "db.php";
header('Content-Type: application/json');

$stmt = $pdo->prepare("SELECT * FROM conf WHERE tela = 'PGMEI'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $dados = json_decode($row['dados'], true);
    echo json_encode([
        'found' => true,
        'atualizado_em' => $row['atualizado_em'] ?? '?',
        'cookies_set' => !empty($dados['cookies']),
        'token_set' => !empty($dados['token']),
        'cookies_preview' => substr($dados['cookies'] ?? '', 0, 50) . '...',
        'token_preview' => substr($dados['token'] ?? '', 0, 20) . '...'
    ]);
} else {
    echo json_encode(['found' => false]);
}
