<?php

// Habilitar erros para debug no Railway
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function Conexao($dbName = null){
    // Prioridade para MYSQLHOST que é mais estável no Railway para PHP
    $host = getenv('MYSQLHOST') ?: (getenv('RAILWAY_PRIVATE_DOMAIN') ?: 'db');
    $user = getenv('MYSQLUSER') ?: 'bit';
    $pass = getenv('MYSQL_ROOT_PASSWORD') ?: (getenv('MYSQLPASSWORD') ?: 'Flipmoney123#');
    $port = getenv('MYSQLPORT') ?: '3306';
    $db   = $dbName ?: (getenv('MYSQL_DATABASE') ?: 'chak');
    $charset = 'utf8mb4';

    // Se houver a URL completa, extraímos tudo dela
    if (getenv('MYSQL_URL')) {
        $url = parse_url(getenv('MYSQL_URL'));
        $host = $url['host'] ?? $host;
        $user = $url['user'] ?? $user;
        $pass = $url['pass'] ?? $pass;
        $port = $url['port'] ?? $port;
        $db   = ltrim($url['path'] ?? '', '/') ?: $db;
    }

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



