<?php

// Habilitar erros para debug no Railway
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        die("Erro de conexão no Banco: " . $e->getMessage() . "<br>Host Usado: $host<br>Porta: $port<br>Usuario: $user<br>Banco: $db");
    }
}

// Conexão principal
$pdo = Conexao();

if (!$pdo) {
    die("A variável \$pdo não foi inicializada corretamente.");
}

// Fallback para variáveis globais se o resto do código usar nomes diferentes
$pdoGlob = $pdo;
