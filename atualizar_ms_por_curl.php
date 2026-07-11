<?php
// atualizar_ms_por_curl.php
session_start();
require_once "db.php";

if (!isset($_SESSION['token']) || ($_SESSION['role'] ?? '') !== 'master') {
    header('Location: login/');
    exit();
}

$status = "";

function ms_extract_first_match(string $pattern, string $curl): string {
    if (preg_match($pattern, $curl, $matches)) {
        return trim($matches[1]);
    }
    return "";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['curl'])) {
    $curl = (string) $_POST['curl'];
    // Remove escapes, quebras de linha e o prefixo de aspas de shell ($')
    $curl = str_replace(["$'", '\^"', '^"', '\^', '^', "\\", "\r", "\n"], ["'", '', '"', '', '', '', ' ', ' '], $curl);

    $token = ms_extract_first_match('/Authorization:\s*Bearer\s+([^"\s\']+)/i', $curl);
    $origin = ms_extract_first_match('/Origin:\s*([^"\']+)/i', $curl);
    $referer = ms_extract_first_match('/Referer:\s*([^"\']+)/i', $curl);
    
    // Extracao de cookies aprimorada
    $cookie = "";
    if (preg_match('/Cookie:\s*([^"\n]+)/i', $curl, $matches)) {
        $cookie = trim($matches[1]);
    } elseif (preg_match('/(?:-b|--cookie)\s+[\'"]?([^"\s][^"\']*)[\'"]?/i', $curl, $matches)) {
        $cookie = trim($matches[1]);
    }

    // Identificar se eh o novo fluxo eFazenda (cookies especificos)
    $isEfz = str_contains($cookie, 'ASP.NET_SessionId') || str_contains($curl, 'efazenda.ms.gov.br');

    if ($token !== '' || $isEfz) {
        $target = 'MS';
        if ($isEfz) {
            // Fluxo Novo: eFazenda
            $dadosArr = [
                'session' => $cookie,
                'referer' => $referer ?: 'https://servicos.efazenda.ms.gov.br/ipvapublico/Home/Index',
                'atualizado_em' => date('Y-m-d H:i:s')
            ];
        } else {
            // Fluxo Antigo: Meu Detran API
            $refreshToken = "";
            if (preg_match('/refreshToken=([^;]+)/i', $cookie, $matches)) {
                $refreshToken = trim($matches[1]);
            }
            $dadosArr = [
                'token' => trim($token, "\"' "),
                'cookies' => trim($token, "\"' "),
                'bearer' => trim($token, "\"' "),
                'refresh_token' => trim($refreshToken, "\"' "),
                'cookie' => trim($cookie, "\"' "),
                'origin' => trim($origin, "\"' "),
                'referer' => trim($referer, "\"' "),
                'url' => 'https://portal-meu-detran-api.prod.k8s.detran.ms.gov.br/debt-consultation/check-debts',
                'method' => 'POST',
                'headers' => [
                    'accept: application/json, text/plain, */*',
                    'content-type: application/json',
                    'origin: https://www.meudetran.ms.gov.br',
                    'referer: https://www.meudetran.ms.gov.br/',
                    'x-app-origin: app-web'
                ],
                'body' => '',
                'curl_raw' => $curl,
                'atualizado_em' => date('Y-m-d H:i:s')
            ];
        }

        $dadosJson = json_encode($dadosArr, JSON_UNESCAPED_UNICODE);

        try {
            $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES (?, '{}', 0)");
            $stmt->execute([$target]);

            $update = $pdoGlob->prepare("UPDATE conf SET dados = ?, expirado_count = 0 WHERE tela = ?");
            $update->execute([$dadosJson, $target]);

            $status = "✅ Sucesso! Dados do MS atualizados e sessão ATIVA.";
        } catch (Exception $e) {
            $status = "❌ Erro ao atualizar banco: " . $e->getMessage();
        }
    } else {
        $status = "❌ Não foi possível encontrar o Bearer Token ou Cookies do eFazenda no CURL fornecido.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Configurar Sessão MS</title>
    <link rel="stylesheet" href="painel/css/styles.css">
    <style>
        body { background: #0f172a; color: #fff; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: #1e293b; padding: 30px; border-radius: 12px; width: 100%; max-width: 700px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        h2 { color: #004f9f; margin-top: 0; }
        textarea { width: 100%; height: 180px; background: #020617; border: 1px solid #334155; color: #8bc34a; padding: 12px; border-radius: 8px; font-family: monospace; font-size: 12px; margin: 15px 0; resize: none; }
        button { background: #004f9f; color: #fff; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.2s; }
        button:hover { opacity: 0.9; transform: scale(1.01); }
        .status { padding: 12px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
        .success { background: rgba(139, 195, 74, 0.1); color: #8bc34a; border: 1px solid #8bc34a; }
        .error { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #94a3b8; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: #fff; }
        .hint { color: #94a3b8; font-size: 14px; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔄 Configurar MS</h2>
        <p class="hint">Cole o cURL da requisição <code>/debt-consultation/check-debts</code>, com o header <code>Authorization: Bearer ...</code> e, se houver, o cookie <code>refreshToken=...</code>.</p>

        <?php if ($status): ?>
            <div class="status <?php echo strpos($status, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $status; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <textarea name="curl" placeholder="curl 'https://portal-meu-detran-api.prod.k8s.detran.ms.gov.br/debt-consultation/check-debts' -H 'authorization: Bearer ...' -H 'cookie: refreshToken=...'" required></textarea>
            <button type="submit">ATUALIZAR DADOS MS</button>
        </form>

        <a href="painel/" class="back-link">Voltar ao Painel Administrador</a>
    </div>
</body>
</html>
