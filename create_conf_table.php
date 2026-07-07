<?php
require_once "db.php";

try {
    // Cria a tabela com TODAS as colunas necessárias
    $sql = "CREATE TABLE IF NOT EXISTS `conf` (
        `id`              INT AUTO_INCREMENT PRIMARY KEY,
        `tela`            VARCHAR(50) UNIQUE NOT NULL,
        `dados`           TEXT,
        `expirado_count`  INT NOT NULL DEFAULT 0,
        `atualizado_em`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($sql);
    echo "✅ Tabela 'conf' criada ou já existente.\n";

    // Adiciona a coluna expirado_count se ainda não existir (migração segura)
    try {
        $pdo->exec("ALTER TABLE conf ADD COLUMN expirado_count INT NOT NULL DEFAULT 0");
        echo "✅ Coluna 'expirado_count' adicionada.\n";
    } catch (PDOException $e) {
        // Se já existe, ignora o erro (Duplicate column name)
        if (strpos($e->getMessage(), 'Duplicate column') !== false) {
            echo "ℹ️ Coluna 'expirado_count' já existe — sem alterações.\n";
        } else {
            throw $e;
        }
    }
    
    // Garante que a linha de proxy exista com config padrão
    $stmt = $pdo->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('proxy', '{}', 0)");
    $stmt->execute();
    echo "ℹ️ Linha 'proxy' garantida na tabela conf.\n";
    
    echo "\n✅ Setup completo!\n";
    
} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}
?>