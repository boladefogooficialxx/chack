<?php
// index.php - Front Controller

try {
    require_once __DIR__ . '/db.php';
    require_once __DIR__ . "/base/utility.php";
    require_once __DIR__ . "/base/detect_device.php";

    $dominioAtual = trim($_SERVER['HTTP_HOST'] ?? '') ?? '';
    
    // Remove protocolos e barras
    $dominioAtual = str_replace(['https://', 'http://'], '', $dominioAtual);
    $dominioAtual = explode('/', $dominioAtual)[0];

    if (!$pdo) {
        die("Erro: Falha na conexão com o banco de dados.");
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
        $sucesso = $_GET['sucesso'] ?? null;
        
        try {
            $stmtU = $pdo->prepare("SELECT username FROM users WHERE id = :id_usuario LIMIT 1");
            $stmtU->execute(['id_usuario' => $id_usuario]);
            $dadosUser = $stmtU->fetch();
            if ($dadosUser) {
                $username = $dadosUser['username'];
                setcookie('Identity', $username, time() + (86400 * 30), "/");
                setcookie('campanha', $id_usuario, time() + (86400 * 30), "/");
            }
        } catch (Exception $e) {}

        // Tracker com caminho absoluto
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
        if (file_exists(__DIR__ . "/websitee/index.php")) {
            require_once __DIR__ . "/websitee/index.php";
        } else {
            echo "Portal em Manutenção.";
        }
    }

} catch (Throwable $e) {
    error_log("Erro Fatal Index: " . $e->getMessage());
    echo "Algo deu errado. Por favor, tente novamente mais tarde.";
}
