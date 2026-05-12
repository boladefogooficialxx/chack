<?php

error_reporting(E_ALL); // Habilitar para ver erros no log do Railway

function Conexao($dbName = null){

    // No Railway, usamos o Root Password se o usuário comum não estiver configurado
    $host = getenv('RAILWAY_PRIVATE_DOMAIN') ?: (getenv('MYSQLHOST') ?: 'db');
    $user = getenv('MYSQLUSER') ?: 'bit';
    $pass = getenv('MYSQL_ROOT_PASSWORD') ?: (getenv('MYSQLPASSWORD') ?: 'Flipmoney123#');
    $port = getenv('MYSQLPORT') ?: '3306';
    $db   = $dbName ?: (getenv('MYSQL_DATABASE') ?: 'chak');
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=$charset", $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // No Railway, o erro aparecerá nos logs do serviço
        error_log('Erro de conexão: ' . $e->getMessage());
        return null;
    }
}

// Conexão principal
$pdo = Conexao();

// Se você realmente precisar de uma conexão chamada 'glob'
$pdoGlob = Conexao('glob');




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



