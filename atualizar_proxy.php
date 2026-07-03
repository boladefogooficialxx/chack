<?php
// atualizar_proxy.php
session_start();
require_once "db.php";

// ACL: Apenas master pode acessar
if (!isset($_SESSION['token']) || $_SESSION['role'] !== 'master') {
    header('Location: login/');
    exit();
}

$status = "";
$proxyConf = get_proxy_config();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $active_ms = isset($_POST['active_ms']) && $_POST['active_ms'] == '1';
    $active_es = isset($_POST['active_es']) && $_POST['active_es'] == '1';
    $active_sc = isset($_POST['active_sc']) && $_POST['active_sc'] == '1';
    $active_pgmei = isset($_POST['active_pgmei']) && $_POST['active_pgmei'] == '1';
    
    $host = trim($_POST['host'] ?? '');
    $port = trim($_POST['port'] ?? '');
    $userpwd = trim($_POST['userpwd'] ?? '');
    
    if (!empty($host)) {
        $dadosArr = [
            'host' => $host,
            'port' => $port,
            'userpwd' => $userpwd,
            'active_ms' => $active_ms,
            'active_es' => $active_es,
            'active_sc' => $active_sc,
            'active_pgmei' => $active_pgmei
        ];
        $dadosJson = json_encode($dadosArr);
        
        try {
            // Garante que a linha exista e atualiza
            $stmt = $pdo->prepare("INSERT INTO conf (tela, dados, expirado_count) VALUES ('proxy', ?, 0) ON DUPLICATE KEY UPDATE dados = ?");
            $stmt->execute([$dadosJson, $dadosJson]);
            
            $status = "✅ Sucesso! Configurações do proxy salvas com sucesso.";
            $proxyConf = $dadosArr;
        } catch (Exception $e) {
            $status = "❌ Erro ao atualizar banco: " . $e->getMessage();
        }
    } else {
        $status = "❌ O campo Host do Proxy é obrigatório.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Configurações de Proxy Centralizado</title>
    <link rel="stylesheet" href="painel/css/styles.css">
    <style>
        body { 
            background: #0f172a; 
            color: #f8fafc; 
            font-family: 'Inter', sans-serif; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
            box-sizing: border-box;
        }
        .card { 
            background: #1e293b; 
            padding: 35px; 
            border-radius: 16px; 
            width: 100%; 
            max-width: 550px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.3); 
            border: 1px solid #334155;
        }
        h2 { 
            color: #38bdf8; 
            margin-top: 0; 
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #f8fafc;
            margin-top: 25px;
            margin-bottom: 15px;
            border-bottom: 1px solid #334155;
            padding-bottom: 8px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #94a3b8;
        }
        input[type="text"] { 
            width: 100%; 
            background: #0f172a; 
            border: 1px solid #334155; 
            color: #38bdf8; 
            padding: 12px; 
            border-radius: 8px; 
            font-family: monospace; 
            font-size: 14px; 
            box-sizing: border-box;
            transition: all 0.2s ease;
        }
        input:focus {
            border-color: #38bdf8;
            outline: none;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }
        .switch-group {
            background: #0f172a;
            border-radius: 8px;
            border: 1px solid #334155;
            padding: 5px 15px;
            margin-bottom: 25px;
        }
        .switch-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #1e293b;
        }
        .switch-container:last-child {
            border-bottom: none;
        }
        .switch-label {
            font-size: 14px;
            font-weight: 500;
            color: #f8fafc;
        }
        .switch-desc {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: normal;
            margin-top: 2px;
        }
        /* Toggle Switch styling */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }
        .switch input { 
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #475569;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #38bdf8;
        }
        input:checked + .slider:before {
            transform: translateX(24px);
        }
        button { 
            background: #38bdf8; 
            color: #0f172a; 
            border: none; 
            padding: 14px 20px; 
            border-radius: 8px; 
            font-weight: bold; 
            font-size: 16px;
            cursor: pointer; 
            width: 100%; 
            transition: all 0.2s ease; 
        }
        button:hover { 
            background: #0ea5e9;
            transform: translateY(-1px); 
        }
        button:active {
            transform: translateY(0);
        }
        .status { 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            font-size: 14px; 
        }
        .success { 
            background: rgba(16, 185, 129, 0.1); 
            color: #10b981; 
            border: 1px solid #10b981; 
        }
        .error { 
            background: rgba(239, 68, 68, 0.1); 
            color: #ef4444; 
            border: 1px solid #ef4444; 
        }
        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 25px; 
            color: #64748b; 
            text-decoration: none; 
            font-size: 14px; 
            transition: color 0.2s;
        }
        .back-link:hover { 
            color: #f8fafc; 
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>🌐 Configurações de Proxy Centralizado</h2>
        <p style="color: #94a3b8; font-size: 14px; margin-bottom: 25px;">Defina as credenciais do proxy da Bright Data abaixo e selecione em quais páginas deseja ativar a navegação por proxy.</p>
        
        <?php if ($status): ?>
            <div class="status <?php echo strpos($status, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $status; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="host">Servidor/Host:</label>
                <input type="text" id="host" name="host" placeholder="ex: brd.superproxy.io" value="<?php echo htmlspecialchars($proxyConf['host'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="port">Porta:</label>
                <input type="text" id="port" name="port" placeholder="ex: 33335" value="<?php echo htmlspecialchars($proxyConf['port'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="userpwd">Usuário e Senha (user:pass):</label>
                <input type="text" id="userpwd" name="userpwd" placeholder="ex: brd-customer-hl_...:..." value="<?php echo htmlspecialchars($proxyConf['userpwd'] ?? ''); ?>">
            </div>

            <div class="section-title">Ativação por Tela / Estado</div>
            
            <div class="switch-group">
                <div class="switch-container">
                    <div>
                        <span class="switch-label">Detran-MS</span>
                        <span class="switch-desc">Ativa proxy nas consultas de débitos do MS</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="active_ms" value="1" <?php echo !empty($proxyConf['active_ms']) ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-container">
                    <div>
                        <span class="switch-label">Detran-ES</span>
                        <span class="switch-desc">Ativa proxy nas consultas de débitos do ES</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="active_es" value="1" <?php echo !empty($proxyConf['active_es']) ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-container">
                    <div>
                        <span class="switch-label">Detran-SC</span>
                        <span class="switch-desc">Ativa proxy nas consultas de débitos do SC</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="active_sc" value="1" <?php echo !empty($proxyConf['active_sc']) ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="switch-container">
                    <div>
                        <span class="switch-label">PGMEI</span>
                        <span class="switch-desc">Ativa proxy nas emissões do PGMEI</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="active_pgmei" value="1" <?php echo !empty($proxyConf['active_pgmei']) ? 'checked' : ''; ?>>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <button type="submit">SALVAR CONFIGURAÇÕES</button>
        </form>

        <a href="painel/" class="back-link">Voltar ao Painel Administrador</a>
    </div>
</body>
</html>
