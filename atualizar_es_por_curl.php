<?php
// atualizar_es_por_curl.php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['curl'])) {
    $curl = $_POST['curl'];

    // 1. Extrair Cookies
    // Tenta pegar de -b ou --cookie
    if (preg_match("/(?:-b|--cookie)\s+(['\"])(.*?)\\1/", $curl, $matches)) {
        $cookies = $matches[2];
    } 
    // Ou de -H 'cookie: ...' ou -H "cookie: ..."
    elseif (preg_match("/-H\s+(['\"])[Cc]ookie:\s*(.*?)\\1/", $curl, $matches)) {
        $cookies = $matches[2];
    } else {
        $cookies = '';
    }

    // 2. Extrair Referer
    if (preg_match("/-H\s+(['\"])[Rr]eferer:\s*(.*?)\\1/", $curl, $matches)) {
        $referer = $matches[2];
    } else {
        $referer = 'https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaIpva';
    }

    // 3. Extrair Bearer (se houver)
    if (preg_match("/-H\s+(['\"])[Aa]uthorization:\s*[Bb]earer\s+(.*?)\\1/i", $curl, $matches)) {
        $bearer = $matches[2];
    } else {
        $bearer = '';
    }

    if (!empty($cookies)) {
        $dadosJson = json_encode([
            'session' => $cookies,
            'bearer' => $bearer,
            'referer' => $referer
        ]);

        try {
            // Garante que a linha ES exista
            $stmt = $pdo->prepare("INSERT IGNORE INTO conf (tela, dados) VALUES ('ES', '{}')");
            $stmt->execute();

            // Atualiza os dados e reseta o contador de expiração
            $update = $pdo->prepare("UPDATE conf SET dados = ?, expirado_count = 0 WHERE tela = 'ES'");
            $update->execute([$dadosJson]);

            $status = "✅ Sucesso! Dados do Detran-ES atualizados.";
        } catch (Exception $e) {
            $status = "❌ Erro ao atualizar banco: " . $e->getMessage();
        }
    } else {
        $status = "❌ Erro: Não foi possível encontrar os cookies no CURL enviado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Token ES via CURL</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background: #f4f4f9; }
        textarea { width: 100%; height: 200px; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 20px; background: #28a745; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #155724; background-color: #d4edda; border-color: #c3e6cb; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
    </style>
</head>
<body>
    <h1>Atualizar Sessão Detran-ES</h1>
    <p>Cole o comando CURL completo copiado do navegador (Network -> Copy as cURL):</p>

    <?php if (isset($status)): ?>
        <div class="alert <?php echo strpos($status, '✅') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $status; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <textarea name="curl" placeholder="Cole o curl aqui..." required></textarea>
        <button type="submit">Atualizar Banco de Dados</button>
    </form>

    <hr>
    <p><a href="index.php">Voltar ao Início</a></p>
</body>
</html>
