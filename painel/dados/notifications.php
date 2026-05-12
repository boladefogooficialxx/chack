<?php

error_reporting();
session_start();

// Pega token da sessão ou do cookie
$token = $_SESSION['token'] ?? null;

if ($token){

    $idUser = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : null;

    require_once "../../db.php";

    date_default_timezone_set('America/Sao_Paulo');

    header('Content-Type: application/json');

    $sql = "SELECT * FROM users WHERE token = :token LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch();

    if (!$user) {
             echo json_encode(["status" => "error", "message" => "Usuário não tem acesso!"]);
        exit();
    }

    $role = $user['role'];

    $response = [
        'success' => true,
        'typing' => [],
        'AdOn' => [],
        'dominios' => [],
        'erro' => null
    ];

    try {
    
        $check = $pdo->prepare("SELECT atual, audio, hora FROM notifications WHERE id = :id LIMIT 1");
        $check->execute([':id' => 1]);
        $notification = $check->fetch(PDO::FETCH_ASSOC);

        if ($notification) {
            $response = array_merge($response, $notification);
        }

        $pdo->prepare("DELETE FROM typing_status WHERE typing_at < (NOW() - INTERVAL 15 SECOND)")->execute();
        $stmt = $pdo->query("SELECT user_id, DATE_FORMAT(typing_at, '%H:%i:%s') AS hora_sp FROM typing_status ORDER BY typing_at DESC");
        $typing = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['typing'] = $typing;

        // Deixa usuario online
        $update = $pdo->prepare("UPDATE users SET `on` = NOW() WHERE id = ?");
        $update->execute([$idUser]);

        // Pegar todos usuario online 40s
        $stmt = $pdo->prepare("SELECT username FROM users WHERE `on` >= NOW() - INTERVAL 40 SECOND");
        $stmt->execute();
        $AdOn = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response['AdOn'] = $AdOn;

        if ($idUser) {
            try {
                // Verifica se o usuário é 'master'
                if ($role == 'master') {

                    $stmt = $pdo->prepare("
                        SELECT 
                            d.id_dominio AS id,
                            d.nome_dominio,
                            d.status,
                            d.page,
                            u.username AS nome_usuario
                        FROM dominios d
                        INNER JOIN users u ON u.id = d.id_usuario
                        ORDER BY u.username ASC
                    ");
                } else {

                    $stmt = $pdo->prepare("
                        SELECT 
                            d.id_dominio AS id,
                            d.nome_dominio,
                            d.status,
                            d.page,
                            u.username AS nome_usuario
                        FROM dominios d
                        INNER JOIN users u ON u.id = d.id_usuario
                        WHERE d.id_usuario = :idUser
                        ORDER BY d.nome_dominio ASC
                    ");
                    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                }

                $stmt->execute();
                $Dominios_usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response['dominios'] = $Dominios_usuario;
            } catch (Exception $e) {
                $response['erro'] = $e->getMessage();
            }
        }

        echo json_encode($response);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }

}else {
        echo json_encode(["status" => "error", "message" => "Usuário não tem acesso!"]);
    exit();
}