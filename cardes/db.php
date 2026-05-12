<?php
$host = "localhost";
$dbname = "cardes";
$user = "bit";  // Altere conforme seu usuário
$pass = "Flipmoney123#";      // Altere conforme sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
