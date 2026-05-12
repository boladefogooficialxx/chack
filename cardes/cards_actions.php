<?php
require_once "db.php";

$action = $_GET['action'] ?? '';

if($action === 'list') {
    $stmt = $pdo->query("SELECT * FROM cards ORDER BY id DESC");
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cards);
    exit;
}

if($action === 'add') {
    $titulo = $_POST['titulo'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $data = $_POST['data'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO cards (titulo, categoria, valor, data) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titulo, $categoria, $valor, $data]);
    echo json_encode(['success' => true]);
    exit;
}

if($action === 'delete') {
    $id = $_POST['id'] ?? 0;
    $stmt = $pdo->prepare("DELETE FROM cards WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['success' => true]);
    exit;
}

if($action === 'update') {
    $id = $_POST['id'] ?? 0;
    $titulo = $_POST['titulo'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $valor = $_POST['valor'] ?? 0;
    $data = $_POST['data'] ?? '';

    $stmt = $pdo->prepare("UPDATE cards SET titulo=?, categoria=?, valor=?, data=? WHERE id=?");
    $stmt->execute([$titulo, $categoria, $valor, $data, $id]);
    echo json_encode(['success' => true]);
    exit;
}

?>
