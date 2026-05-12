<?php
header("Content-Type: application/json");
require_once "../db.php"; // conexão PDO

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Nenhum dado recebido"]);
    exit;
}

$secretKey      = $data['secretKey'] ?? '';
$publicKey      = $data['publicKey'] ?? '';
$idUsuario      = $data['id_usuario'] ?? null; 
$webRouterUrl   = $data['webRouterUrl'] ?? null;
$apiEndpoint    = $data['apiEndpoint'] ?? null;
$webhookUrl     = $data['webhookUrl'] ?? '';
$plataforma     = $data['plataforma'] ?? '';
$chavepixnome   = $data['chavepixnome'] ?? '';
$chavepixCidade = $data['chavepixCidade'] ?? '';
$chavepix       = $data['chavepix'] ?? '';


$lastSaved = null;
if ($lastSavedRaw) {
    $timestamp = strtotime($lastSavedRaw);
    if ($timestamp !== false) {
        $lastSaved = date("Y-m-d H:i:s", $timestamp);
    }
}
try {
    if ($idUsuario) {
        // 🔎 Verifica se já existe configuração para esse usuário
        $check = $pdo->prepare("SELECT id FROM configuracoes WHERE id_usuario = :id_usuario LIMIT 1");
        $check->execute([':id_usuario' => $idUsuario]);
        $exists = $check->fetchColumn();

        if ($exists) {
            // Atualiza
            $stmt = $pdo->prepare("
                UPDATE configuracoes SET 
                    secret_key = :secret_key,
                    public_key = :public_key,
                    web_router_url = :web_router_url,
                    api_endpoint = :api_endpoint,
                    webhook_url = :webhook_url,
                    last_saved = :last_saved,
                    Plataforma = :plataforma,
                    nome = :nome,
                    cidade = :cidade,
                    chave = :chave
                WHERE id_usuario = :id_usuario
            ");
        } else {
            // Insere
            $stmt = $pdo->prepare("
                INSERT INTO configuracoes (id_usuario, secret_key, public_key, web_router_url, api_endpoint, webhook_url, last_saved, Plataforma, nome, cidade, chave)
                VALUES (:id_usuario, :secret_key, :public_key, :web_router_url, :api_endpoint, :webhook_url, :last_saved, :plataforma, :nome, :cidade, :chave)
            ");
        }

        $stmt->execute([
            ':id_usuario'    => $idUsuario,
            ':secret_key'    => $secretKey,
            ':public_key'    => $publicKey,
            ':web_router_url'=> $webRouterUrl,
            ':api_endpoint'  => $apiEndpoint,
            ':webhook_url'   => $webhookUrl,
            ':last_saved'    => $lastSaved,
            ':plataforma'    => $plataforma,
            ':nome'          => $chavepixnome,
            ':cidade'        => $chavepixCidade,
            ':chave'         => $chavepix
        ]);
    } else {
        // Configuração global (id = 1 fixo)
        $check = $pdo->query("SELECT id FROM configuracoes WHERE id = 1 LIMIT 1")->fetchColumn();

        if ($check) {
            $stmt = $pdo->prepare("
                UPDATE configuracoes SET 
                    secret_key    = :secret_key,
                    public_key    = :public_key,
                    web_router_url= :web_router_url,
                    api_endpoint  = :api_endpoint,
                    webhook_url   = :webhook_url,
                    last_saved    = :last_saved,
                    Plataforma   = :plataforma,
                WHERE id = 1
            ");
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO configuracoes (id, secret_key, public_key, web_router_url, api_endpoint, webhook_url, last_saved, Plataforma)
                VALUES (1, :secret_key, :public_key, :web_router_url, :api_endpoint, :webhook_url, :last_saved, :plataforma)
            ");
        }

        $stmt->execute([
            ':secret_key'    => $secretKey,
            ':public_key'    => $publicKey,
            ':web_router_url'=> $webRouterUrl,
            ':api_endpoint'  => $apiEndpoint,
            ':webhook_url'   => $webhookUrl,
            ':last_saved'    => $lastSaved,
            ':plataforma'    => $plataforma
        ]);
    }

    echo json_encode(["status" => "success", "message" => "Configurações salvas com sucesso!"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Erro ao salvar: " . $e->getMessage()]);
}
