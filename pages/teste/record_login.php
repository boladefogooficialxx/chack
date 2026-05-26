<?php
require_once "../../db.php";

header('Content-Type: application/json');

$placa = $_POST['placa'] ?? 'TST-2026';
$id_usuario = $_COOKIE['campanha'] ?? 1;
$identity = $_COOKIE['Identity'] ?? 'chakal';
$page = 'teste';

try {
    $horaCaptura = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    
    // Simula dados do veículo
    $dados = "SIMULADO/TESTE";
    $debitos = "1 | 10,00";
    $login_info = json_encode([['label' => 'Placa', 'value' => $placa]]);
    $resposta = "Simulação de consulta realizada com sucesso via Laboratório.";

    $stmt = $pdo->prepare("INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta) VALUES (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta)");
    
    $stmt->execute([
        ':page' => $page,
        ':dados' => $dados,
        ':debitos' => $debitos,
        ':ip' => $ip,
        ':pais' => 'BR - Laboratório',
        ':identity' => $identity,
        ':hora' => $horaCaptura,
        ':login_info' => $login_info,
        ':id_usuario' => $id_usuario,
        ':resposta' => $resposta
    ]);

    // Dispara som de consulta (Audio 1) se necessário, ou som de sucesso na captura?
    // O tracker já faz o audio 1. Vamos disparar o 2 que costuma ser consulta/login.
    $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
    $updateStmt->execute([
        ':audio' => 2,
        ':atual' => rand(100000000, 99999999999),
        ':hora' => $horaCaptura,
        ':id' => 1
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Consulta registrada no painel!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
