<?php

// index.php - Front Controller

require_once 'db.php';
require_once "base/utility.php";
require_once "base/detect_device.php";

$dominioAtual = trim($_SERVER['HTTP_HOST']) ?? '';

$stmt = $pdo->prepare("SELECT diretorio_raiz, id_usuario, page FROM dominios WHERE nome_dominio = :dominio AND status = 'ativo' LIMIT 1");
$stmt->execute(['dominio' => $dominioAtual]);
$dominio = $stmt->fetch();

if ($dominio && !empty($dominio['diretorio_raiz'])) {

    $diretorio = $dominio['diretorio_raiz'];
    $id_usuario = $_GET['id_usuario'] ?? $dominio['id_usuario'];
    $page = $dominio['page'];
    $tp = $dominio['tp'];
    $sucesso = $_GET['sucesso'] ?? null;

    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id_usuario LIMIT 1");
            $stmt->execute(['id_usuario' => $id_usuario]);
            $dadosUser = $stmt->fetch();

    if ($dadosUser && !empty($dadosUser['username'])) {
        $username = $dadosUser['username'];
        setcookie('Identity', $username, time() + (86400 * 30), "/");
        setcookie('campanha', $id_usuario, time() + (86400 * 30), "/");
    }

    require_once "base/tracker.php";

    $baseDir = realpath(__DIR__ . '/pages'); 
    $targetDir = realpath($diretorio);

    if ($targetDir && str_starts_with($targetDir, $baseDir)) {

        $indexFile = $targetDir . '/index.php';
        $htmlFile = $targetDir . '/index.html';

        if (file_exists($indexFile)) {
            include $indexFile;
        } elseif (file_exists($htmlFile)) {
            readfile($htmlFile);
        } else {
            http_response_code(404);
            echo "Página não encontrada.";
        }
    } else {
        http_response_code(403);
        echo "Acesso proibido.";
    }

    require_once "base/script.php";

} else {
    require_once "./websitee/index.php";
}
