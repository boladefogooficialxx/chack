<?php
require_once "db.php";

try {
    // 1. Garante que a tabela exista (caso não tenha sido criada no chak.sql)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `notifications` (
        `id` INT PRIMARY KEY,
        `audio` INT DEFAULT 0,
        `atual` VARCHAR(50) DEFAULT '0',
        `hora` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Insere o registro mestre (ID 1) que o sistema todo utiliza
    $stmt = $pdo->prepare("INSERT IGNORE INTO notifications (id, audio, atual, hora) VALUES (1, 0, '0', NOW())");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Sucesso: Registro mestre de notificações criado (ID 1).\n";
    } else {
        echo "Aviso: O registro ID 1 já existia na tabela.\n";
    }

    // 3. Verifica a tabela de logs de texto também
    $pdo->exec("CREATE TABLE IF NOT EXISTS `notificacoes` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `mensagem` TEXT,
        `criado_em` DATETIME
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "Tabela de logs 'notificacoes' verificada.\n";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
?>