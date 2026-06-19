<?php
// cadastrar_curl_sc.php
session_start();
require_once "db.php";

// ACL: Apenas master pode acessar
if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'master') {
    header('Location: login/');
    exit();
}

$status = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['curl'])) {
    $curl = $_POST['curl'];
    
    // 1. Detectar se colou CURL do ES na página de SC
    if (stripos($curl, 'es.gov.br') !== false) {
        $status = "⚠️ Erro: Este CURL parece ser do Detran-ES. Use a página específica para o ES.";
    } else {
        // 2. Limpeza ultra-agressiva para Windows (CMD/PowerShell)
        // Remove ^, \^", ^", quebras de linha e escapes redundantes
        $curl = str_replace(['\^"', '^"', '\^', '^', '\\', "\r", "\n"], ['', '"', '', '', '', ' ', ' '], $curl);

        $url = null;
        if (preg_match('~https?://[^\s\'"]*requisitar-consulta[^\s\'"]*~i', $curl, $matches)) {
            $url = trim($matches[0]);
        } elseif (preg_match('~https?://[^\s\'"]*resposta-consulta[^\s\'"]*~i', $curl, $matches)) {
            $url = trim($matches[0]);
        } elseif (preg_match('~https?://[^\s\'"]+~i', $curl, $matches)) {
            $url = trim($matches[0]);
        }

        $method = 'GET';
        if (preg_match('/(?:-X|--request)\s+([A-Z]+)/i', $curl, $matches)) {
            $method = strtoupper(trim($matches[1]));
        } elseif (preg_match('/--data(?:-raw|-binary|-urlencode)?\s+/i', $curl)) {
            $method = 'POST';
        }

        $headers = [];
        if (preg_match_all('/-H\s+(["\'])(.*?)\1/si', $curl, $matches)) {
            foreach ($matches[2] as $headerLine) {
                $headerLine = trim($headerLine);
                if ($headerLine !== '') {
                    $headers[] = $headerLine;
                }
            }
        }

        $body = null;
        if (preg_match('/--data(?:-raw|-binary|-urlencode)?\s+(["\'])(.*?)\1/si', $curl, $matches)) {
            $body = trim($matches[2]);
        }

        // 2. Extrair Authorization (Bearer Token)
        $token = null;
        if (preg_match("/Authorization:\s*Bearer\s+([^\"'\s]+)/i", $curl, $matches)) {
            $token = trim($matches[1]);
        }

        // 3. Extrair X-App-Version
        $version = null;
        if (preg_match("/X-App-Version:\s*([^\"'\s]+)/i", $curl, $matches)) {
            $version = trim($matches[1]);
        }

        // 4. Extrair parâmetro 't' da URL
        $t_param = null;
        if (preg_match("/[?&]t=([^\"'&\s]+)/i", $curl, $matches)) {
            $t_param = trim($matches[1]);
        }

        // 5. Extrair parâmetros do início da consulta
        $queryParams = [];
        foreach (['p', 'r', 'c', 'v'] as $paramName) {
            if (preg_match('/[?&]' . preg_quote($paramName, '/') . '=([^\"\'&\s]+)/i', $curl, $matches)) {
                $queryParams[$paramName] = trim($matches[1]);
            }
        }

        $cookie = null;
        if (preg_match("/Cookie:\s*([^\"'\n]+)/i", $curl, $matches)) {
            $cookie = trim($matches[1]);
        }

        // Limpeza final de aspas residuais
        if ($token) $token = trim($token, "\"' ");
        if ($version) $version = trim($version, "\"' ");
        if ($t_param) $t_param = trim($t_param, "\"' ");
        if ($cookie) $cookie = trim($cookie, "\"' ");

        if ($token || $url) {
            $dadosArr = [
                'token' => $token,
                'version' => $version,
                't' => $t_param,
                'url' => $url,
                'method' => $method,
                'headers' => $headers,
                'body' => $body,
                'cookie' => $cookie,
                'query_params' => $queryParams,
                'curl_raw' => $curl,
                'atualizado_em' => date('Y-m-d H:i:s')
            ];
            $dadosJson = json_encode($dadosArr);

            try {
                // Garante que a linha SC exista
                $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('SC', '{}', 0)");
                $stmt->execute();

                // Atualiza os dados e reseta o contador de expiração
                $update = $pdoGlob->prepare("UPDATE conf SET dados = ?, expirado_count = 0 WHERE tela = 'SC'");
                $update->execute([$dadosJson]);

                $status = "✅ Sucesso! Dados do Detran-SC atualizados e sessão ATIVA.";
            } catch (Exception $e) {
                $status = "❌ Erro ao atualizar banco: " . $e->getMessage();
            }
        } else {
            $status = "❌ Não foi possível encontrar o Bearer Token no CURL fornecido.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Configurar Sessão Detran-SC</title>
    <link rel="stylesheet" href="painel/css/styles.css">
    <style>
        body { background: #0f172a; color: #fff; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: #1e293b; padding: 30px; border-radius: 12px; width: 100%; max-width: 600px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        h2 { color: #8bc34a; margin-top: 0; }
        textarea { width: 100%; height: 150px; background: #020617; border: 1px solid #334155; color: #8bc34a; padding: 12px; border-radius: 8px; font-family: monospace; font-size: 12px; margin: 15px 0; resize: none; }
        button { background: #8bc34a; color: #000; border: none; padding: 12px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.2s; }
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
        <h2>🔄 Configurar Detran-SC</h2>
        <p style="color: #94a3b8; font-size: 14px;">Cole o CURL capturado do portal Detran-SC para atualizar o token de acesso.</p>
        
        <?php if ($status): ?>
            <div class="status <?php echo strpos($status, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $status; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <textarea name="curl" placeholder="curl 'https://backend.detran.sc.gov.br/...' -H 'Authorization: Bearer ...'" required></textarea>
            <button type="submit">ATUALIZAR TOKEN SC</button>
        </form>

        <a href="painel/" class="back-link">Voltar ao Painel Administrador</a>
    </div>
</body>
</html>
