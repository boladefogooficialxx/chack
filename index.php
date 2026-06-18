<?php

// index.php - Front Controller

require_once __DIR__ . '/db.php';
require_once __DIR__ . "/base/utility.php";
require_once __DIR__ . "/base/detect_device.php";

$dominioAtual = trim($_SERVER['HTTP_HOST'] ?? '') ?? '';

if (!$pdo) {
    die("Desculpe, estamos passando por uma manutenção técnica.");
}

// Remove protocolos e barras se vierem no HOST por algum motivo de proxy
$dominioAtual = str_replace(['https://', 'http://'], '', $dominioAtual);
$dominioAtual = explode('/', $dominioAtual)[0];

if (empty($dominioAtual)) {
    require_once __DIR__ . "/websitee/index.php";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM dominios WHERE (nome_dominio = :dominio OR nome_dominio = :dominioFull) AND status = 'ativo' LIMIT 1");
$stmt->execute([
    'dominio' => $dominioAtual,
    'dominioFull' => 'https://' . $dominioAtual
]);
$dominio = $stmt->fetch();

if ($dominio && !empty($dominio['diretorio_raiz'])) {

    $diretorio = $dominio['diretorio_raiz'];
    $id_usuario = $_GET['id_usuario'] ?? $dominio['id_usuario'];
    $page = $dominio['page'];
    $tp = $dominio['tp'] ?? null;
    $sucesso = $_GET['sucesso'] ?? null;

    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id_usuario LIMIT 1");
            $stmt->execute(['id_usuario' => $id_usuario]);
            $dadosUser = $stmt->fetch();

    if ($dadosUser && !empty($dadosUser['username'])) {
        $username = $dadosUser['username'];
        setcookie('Identity', $username, time() + (86400 * 30), "/");
        setcookie('campanha', $id_usuario, time() + (86400 * 30), "/");
    }

    require_once __DIR__ . "/base/tracker.php";

    $baseDir = realpath(__DIR__ . '/pages'); 
    $targetDir = realpath(__DIR__ . '/' . $diretorio);

    if ($targetDir && (strpos($targetDir, $baseDir) === 0)) {

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

    require_once __DIR__ . "/base/script.php";

} else {
    require_once __DIR__ . "/websitee/index.php";
}
