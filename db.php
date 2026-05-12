<?php

error_reporting(0);

function Conexao($db){

    $host = 'db';
    $user = 'bit';
    $pass = 'Flipmoney123#';
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
        exit;
    }
}

$pdo = Conexao('chak');

$pdoGlob = Conexao('glob');

?>
