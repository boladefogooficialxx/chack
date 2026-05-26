<?php
require_once "db.php";

try {
    $sql = "CREATE TABLE IF NOT EXISTS `conf` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `tela` VARCHAR(50) UNIQUE NOT NULL,
        `dados` TEXT,
        `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql);
    echo "Tabela 'conf' criada ou já existente.\n";
    
    // Inserir um registro inicial para teste se não existir
    $stmt = $pdo->prepare("INSERT IGNORE INTO conf (tela, dados) VALUES ('teste', '{}')");
    $stmt->execute();
    echo "Registro inicial para 'teste' inserido.\n";
    
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage() . "\n";
}
?>