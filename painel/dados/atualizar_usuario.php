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

// Pegar dados do POST
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id_usuario'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do usuário não fornecido']);
    exit();
}

$id_usuario = $data['id_usuario'];
$plataforma = $data['plataforma'] ?? '';
$secret_key = $data['secret_key'] ?? '';
$public_key = $data['public_key'] ?? '';
$webhook_url = $data['webhook_url'] ?? '';
$nome = $data['nome'] ?? '';
$cidade = $data['cidade'] ?? '';
$chave = $data['chave'] ?? '';
$configuracoesFlag = isset($data['configuracoes']) ? (int)$data['configuracoes'] : 0;

try {
    // Verificar se já existe configuração para este usuário
    $sqlCheck = "SELECT id FROM configuracoes WHERE id_usuario = :id_usuario LIMIT 1";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([':id_usuario' => $id_usuario]);
    $configExists = $stmtCheck->fetch();

    if ($configExists) {
        // Atualizar configuração existente
        $sqlUpdate = "UPDATE configuracoes SET 
                  Plataforma = :plataforma,
                  secret_key = :secret_key,
                  public_key = :public_key,
                  webhook_url = :webhook_url,
                  nome = :nome,
                  cidade = :cidade,
                  chave = :chave,
                  last_saved = CURRENT_TIMESTAMP
                  WHERE id_usuario = :id_usuario";
        
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([
            ':plataforma' => $plataforma,
            ':secret_key' => $secret_key,
            ':public_key' => $public_key,
            ':webhook_url' => $webhook_url,
            ':nome' => $nome,
            ':cidade' => $cidade,
            ':chave' => $chave,
            ':id_usuario' => $id_usuario
        ]);
    } else {
        // Inserir nova configuração
        $sqlInsert = "INSERT INTO configuracoes (id_usuario, Plataforma, secret_key, public_key, webhook_url, nome, cidade, chave, web_router_url) 
                      VALUES (:id_usuario, :plataforma, :secret_key, :public_key, :webhook_url, :nome, :cidade, :chave, '')";
        
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([
            ':id_usuario' => $id_usuario,
            ':plataforma' => $plataforma,
            ':secret_key' => $secret_key,
            ':public_key' => $public_key,
            ':webhook_url' => $webhook_url,
            ':nome' => $nome,
            ':cidade' => $cidade,
            ':chave' => $chave
        ]);
    }

    // Atualizar flag de configurações na tabela users
    $sqlUserFlag = "UPDATE users SET configuracoes = :configuracoes WHERE id = :id_usuario";
    $stmtUserFlag = $pdo->prepare($sqlUserFlag);
    $stmtUserFlag->execute([
        ':configuracoes' => $configuracoesFlag,
        ':id_usuario' => $id_usuario
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Configurações atualizadas com sucesso'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao atualizar configurações: ' . $e->getMessage()]);
}
