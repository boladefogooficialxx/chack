<?php
session_start();

require_once '../db.php';
require_once "../base/utility.php";

// Se for POST, processa login e retorna JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $input = json_decode(file_get_contents('php://input'), true);
    $login = trim($input['email'] ?? ($_POST['email'] ?? ''));
    $password = $input['password'] ?? ($_POST['password'] ?? '');

    if ($login === '' || $password === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Informe email ou usuário e senha']);
        exit;
    }

    try {

      $sql = "SELECT * FROM users WHERE password = :senha AND (username = :username OR email = :email) LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':senha' => $password,
            ':username' => $login,
            ':email' => $login
        ]);

        $user = $stmt->fetch();

        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Credenciais inválidas']);
            exit;
        }

         // Gera token aleatório seguro
        $token = bin2hex(random_bytes(32));

        // Atualiza token e last_login
        $update = $pdo->prepare("UPDATE users SET token = :token, last_login = NOW() WHERE id = :id");
        $update->execute([
            ':token' => $token,
            ':id' => $user['id']
        ]);

        // Define sessão
        $_SESSION['user_id']  = $user['id']; 
        $_SESSION['username'] = $user['username'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['role']     = $user['role'];
        $_SESSION['token'] = $token;
        $_SESSION['is_admin'] = ($user['role'] === 'master');

        echo json_encode([
            'success' => true,
            'message' => 'Login efetuado com sucesso',
            'role'    => $user['role']
        ]);
        exit;
    } catch (PDOException $ex) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro no servidor: ' . $ex->getMessage()]);
        exit;
    }
}

date_default_timezone_set('America/Sao_Paulo');

$dataAtual = date('d/m/Y');

$DadosIp = getFromIp(getClientIp());


if($DadosIp){
    if($DadosIp->country){
        $servidornet = $DadosIp->org;
        $pais = $DadosIp->country;
        $regionName = $DadosIp->regionName;
        $city = $DadosIp->city;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel Administrativo Lion</title>
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="theme-color" content="#0f172a">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/6079/6079584.png" sizes="192x192">
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
         .dark {
          background: #0f172a;
      color: #ffffff; /* Cor do texto */
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    </style>
</head>
<body class="dark">
    <div class="login-container">
        <div class="bg-grid-pattern"></div>
        
        <!-- Header -->
        <header class="header">
          
            <div class="header-right">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span><?=$city?>, <?=$pais?></span>
            </div>
        </header>

        <!-- Theme Toggle -->
        <button class="theme-toggle" id="themeToggle" aria-label="Alternar tema">
            <svg class="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="5"/>
                <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </svg>
            <svg class="moon-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
        </button>

        <!-- Main Login Card -->
        <div class="login-card">
            <div class="card-header">
                <h1 class="card-title">Painel Administrativo</h1>
                <p class="card-description">Faça login para acessar seu painel</p>
            </div>
            
            <form class="login-form" id="loginForm">
                <div class="form-group">
                    <label for="email" class="form-label">Nome de Usuário</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Digite seu usuário"
                        required
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Senha</label>
                    <div class="password-container">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Digite sua senha"
                            required
                        >
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Mostrar/ocultar senha">
                            <svg class="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="eye-off-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                                <path d="M1 1l22 22"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-options" style="display: none;">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember" class="checkbox">
                        <label for="remember" class="checkbox-label">Lembrar de mim</label>
                    </div>
                    <button type="button" class="forgot-password">Esqueceu a senha?</button>
                </div>

                <button type="submit" class="login-button" id="loginButton">
                    <span class="button-text">Entrar no Painel</span>
                    <div class="loading-spinner">
                        <div class="spinner"></div>
                        <span>Entrando...</span>
                    </div>
                </button>
            </form>

            <div class="signup-section">
                <p>Não tem uma conta? <button type="button" class="signup-link">Solicitar acesso</button></p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-left">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                <span>Sistema de Gestão • São Paulo, Brasil</span>
            </div>
            <div class="footer-right">
                <span id="lastUpdate">Última atualização: <?=$dataAtual?></span>
            </div>
        </footer>

        <!-- Toast Notification -->
        <div class="toast" id="toast">
            <div class="toast-content">
                <div class="toast-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                </div>
                <div class="toast-message">
                    <div class="toast-title">Sucesso!</div>
                    <div class="toast-description">Login realizado com sucesso!</div>
                </div>
            </div>
        </div>
    </div>

    <script src="login.js"></script>
</body>
</html>