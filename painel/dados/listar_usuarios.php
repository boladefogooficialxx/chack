<?php
session_start();
error_reporting(0);

require_once '../../db.php';

// Verificar se o usuário está logado e é Master
$token = $_SESSION['token'] ?? null;

if (!$token) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit();
}

$sql = "SELECT * FROM users WHERE token = :token LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':token' => $token]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'master') {
    http_response_code(403);
    echo json_encode(['error' => 'Acesso negado. Apenas usuários Master podem acessar esta funcionalidade.']);
    exit();
}

try {
    // Buscar todos os usuários
    $sqlUsers = "SELECT id, username, email, role, created_at, last_login, configuracoes FROM users ORDER BY id ASC";
    $stmtUsers = $pdo->prepare($sqlUsers);
    $stmtUsers->execute();
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    $resultado = [];

    foreach ($users as $usuario) {
        // Buscar configurações de pagamento do usuário
        $sqlConfig = "SELECT * FROM configuracoes WHERE id_usuario = :id_usuario LIMIT 1";
        $stmtConfig = $pdo->prepare($sqlConfig);
        $stmtConfig->execute([':id_usuario' => $usuario['id']]);
        $config = $stmtConfig->fetch(PDO::FETCH_ASSOC);

        // Buscar domínios associados ao usuário
        $sqlDominios = "SELECT * FROM dominios WHERE id_usuario = :id_usuario ORDER BY id_dominio ASC";
        $stmtDominios = $pdo->prepare($sqlDominios);
        $stmtDominios->execute([':id_usuario' => $usuario['id']]);
        $dominios = $stmtDominios->fetchAll(PDO::FETCH_ASSOC);

        $resultado[] = [
            'id' => $usuario['id'],
            'username' => $usuario['username'],
            'email' => $usuario['email'],
            'role' => $usuario['role'],
            'created_at' => $usuario['created_at'],
            'last_login' => $usuario['last_login'],
            'configuracoes' => $usuario['configuracoes'],
            'config' => $config ?: null,
            'dominios' => $dominios ?: []
        ];
    }

    echo json_encode([
        'success' => true,
        'users' => $resultado
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar usuários: ' . $e->getMessage()]);
}
