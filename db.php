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
?>



// error_reporting(0);
//
// function Conexao($db){
//
//     $host = 'db';
//     $user = 'bit';
//     $pass = 'Flipmoney123#';
//     $charset = 'utf8mb4';
//
//     $options = [
//         PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::ATTR_EMULATE_PREPARES   => false,
//     ];
//
//     try {
//         $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
//         return $pdo;
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
//         exit;
//     }
// }
//
// $pdo = Conexao('chak');
//
// $pdoGlob = Conexao('glob');
//

?>



