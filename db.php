<?php

// No Railway (Produção), não devemos exibir erros na tela para não quebrar o layout/headers
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // Logar tudo, mas esconder avisos e warnings da tela

function Conexao($dbName = null){
    // Configurações Manuais do Railway (Públicas)
    $host = 'yamabiko.proxy.rlwy.net';
    $port = '54916';
    $user = 'root';
    $pass = 'nnOcHNhdSblhJrEromomQJrDHHoukWfv';
    $db   = 'railway'; // Nome do banco padrão no Railway
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        // Logar erro internamente
        error_log("Erro de conexão no Banco: " . $e->getMessage());
        return null;
    }
}

// Conexão principal
$pdo = Conexao();

if (!$pdo) {
    // Se o banco falhar em produção, melhor mostrar uma mensagem limpa
    die("Desculpe, estamos passando por uma manutenção técnica no banco de dados.");
}

$pdoGlob = $pdo;
