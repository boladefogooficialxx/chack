<?php
// atualizar_es_por_curl.php
require_once "db.php";

$status = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['curl'])) {
    $curl = $_POST['curl'];
    
    // Pré-limpeza: Remove escapes comuns do Windows
    $curl = str_replace(['\^"', '^"', '\^'], ['', '"', ''], $curl);

    // 1. Extrair Cookies - Suporta aspas simples/duplas e variações de case
    preg_match("/Cookie:\s+([^\"'\s\^]+)/i", $curl, $matchesCookie);
    $cookies = $matchesCookie[1] ?? "";

        // 2. Extrair Cookies - Suporta Cookie: , -b ou --cookie
        $cookies = "";
        if (preg_match("/Cookie:\s*([^\"']+)/i", $curl, $matches)) {
            $cookies = trim($matches[1]);
        } elseif (preg_match("/(?:-b|--cookie)\s+[\"']?([^\"'\s][^\"']*)[\"']?/i", $curl, $matches)) {
            $cookies = trim($matches[1]);
        }

        // 3. Extrair Referer
        $referer = "";
        if (preg_match("/Referer:\s*([^\"'\s]+)/i", $curl, $matches)) {
            $referer = trim($matches[1]);
        }

        // Limpeza final de aspas residuais
        $cookies = trim($cookies, "\"' ");
        $referer = trim($referer, "\"' ");

        if ($cookies) {
        $dadosArr = [
            'session' => $cookies,
            'referer' => $referer,
            'atualizado_em' => date('Y-m-d H:i:s')
        ];
        $dadosJson = json_encode($dadosArr);

        try {
            // Garante que a linha ES exista
            $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('ES', '{}', 0)");
            $stmt->execute();

            // Atualiza os dados e reseta o contador de expiração
            $update = $pdoGlob->prepare("UPDATE conf SET dados = ?, expirado_count = 0 WHERE tela = 'ES'");
            $update->execute([$dadosJson]);

            $status = "✅ Sucesso! Dados do Detran-ES atualizados e sessão ATIVA.";
        } catch (Exception $e) {
            $status = "❌ Erro ao atualizar banco: " . $e->getMessage();
        }
    } else {
        $status = "❌ Não foi possível encontrar os Cookies no CURL fornecido.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Configurar Sessão Detran-ES</title>
    <link rel="stylesheet" href="painel/css/styles.css">
    <style>
        body { background: #0f172a; color: #fff; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: #1e293b; padding: 30px; border-radius: 12px; width: 100%; max-width: 600px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        h2 { color: #287b99; margin-top: 0; }
        textarea { width: 100%; height: 150px; background: #020617; border: 1px solid #334155; color: #8bc34a; padding: 12px; border-radius: 8px; font-family: monospace; font-size: 12px; margin: 15px 0; resize: none; }
        button { background: #287b99; color: #fff; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.2s; }
        button:hover { opacity: 0.9; transform: scale(1.01); }
        .status { padding: 12px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
        .success { background: rgba(139, 195, 74, 0.1); color: #8bc34a; border: 1px solid #8bc34a; }
        .error { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #94a3b8; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: #fff; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔄 Configurar Detran-ES</h2>
        <p style="color: #94a3b8; font-size: 14px;">Cole o CURL capturado do portal Detran-ES para atualizar os cookies de sessão.</p>
        
        <?php if ($status): ?>
            <div class="status <?php echo strpos($status, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $status; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <textarea name="curl" placeholder="curl 'https://servicos.detrannet.es.gov.br/...' -H 'cookie: ...'" required></textarea>
            <button type="submit">ATUALIZAR DADOS ES</button>
        </form>

        <a href="painel/" class="back-link">Voltar ao Painel Administrador</a>
    </div>
</body>
</html>



<!---->
<?php
//// atualizar_es_por_curl.php
//require_once "db.php";
//
//$status = "";
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['curl'])) {
//    $curl = $_POST['curl'];
//
//    // 1. Extrair Cookies
//    preg_match("/-H 'cookie: (.*?)'/i", $curl, $matchesCookie);
//    $cookies = $matchesCookie[1] ?? "";
//
//    // 2. Extrair Referer
//    preg_match("/-H 'referer: (.*?)'/i", $curl, $matchesReferer);
//    $referer = $matchesReferer[1] ?? "";
//
//    if ($cookies) {
//        $dadosArr = [
//                'session' => $cookies,
//                'referer' => $referer,
//                'atualizado_em' => date('Y-m-d H:i:s')
//        ];
//        $dadosJson = json_encode($dadosArr);
//
//        try {
//            // Garante que a linha ES exista
//            $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('ES', '{}', 0)");
//            $stmt->execute();
//
//            // Atualiza os dados e reseta o contador de expiração
//            $update = $pdoGlob->prepare("UPDATE conf SET dados = ?, expirado_count = 0 WHERE tela = 'ES'");
//            $update->execute([$dadosJson]);
//
//            $status = "✅ Sucesso! Dados do Detran-ES atualizados e sessão ATIVA.";
//        } catch (Exception $e) {
//            $status = "❌ Erro ao atualizar banco: " . $e->getMessage();
//        }
//    } else {
//        $status = "❌ Não foi possível encontrar os Cookies no CURL fornecido.";
//    }
//}
//?>
<!--<!DOCTYPE html>-->
<!--<html lang="pt-br">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>Configurar Sessão Detran-ES</title>-->
<!--    <link rel="stylesheet" href="painel/css/styles.css">-->
<!--    <style>-->
<!--        body { background: #0f172a; color: #fff; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }-->
<!--        .card { background: #1e293b; padding: 30px; border-radius: 12px; width: 100%; max-width: 600px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }-->
<!--        h2 { color: #287b99; margin-top: 0; }-->
<!--        textarea { width: 100%; height: 150px; background: #020617; border: 1px solid #334155; color: #8bc34a; padding: 12px; border-radius: 8px; font-family: monospace; font-size: 12px; margin: 15px 0; resize: none; }-->
<!--        button { background: #287b99; color: #fff; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.2s; }-->
<!--        button:hover { opacity: 0.9; transform: scale(1.01); }-->
<!--        .status { padding: 12px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }-->
<!--        .success { background: rgba(139, 195, 74, 0.1); color: #8bc34a; border: 1px solid #8bc34a; }-->
<!--        .error { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; }-->
<!--        .back-link { display: block; text-align: center; margin-top: 20px; color: #94a3b8; text-decoration: none; font-size: 14px; }-->
<!--        .back-link:hover { color: #fff; }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<!--<div class="card">-->
<!--    <h2>🔄 Configurar Detran-ES</h2>-->
<!--    <p style="color: #94a3b8; font-size: 14px;">Cole o CURL capturado do portal Detran-ES para atualizar os cookies de sessão.</p>-->
<!---->
<!--    --><?php //if ($status): ?>
<!--        <div class="status --><?php //echo strpos($status, '✅') !== false ? 'success' : 'error'; ?><!--">-->
<!--            --><?php //echo $status; ?>
<!--        </div>-->
<!--    --><?php //endif; ?>
<!---->
<!--    <form method="POST">-->
<!--        <textarea name="curl" placeholder="curl 'https://servicos.detrannet.es.gov.br/...' -H 'cookie: ...'" required></textarea>-->
<!--        <button type="submit">ATUALIZAR DADOS ES</button>-->
<!--    </form>-->
<!---->
<!--    <a href="painel/" class="back-link">Voltar ao Painel Administrador</a>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
