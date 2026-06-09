<?php
require_once "db.php";

echo "<h2>Atualização do Banco de Dados</h2>";

try {
    // Tenta adicionar a coluna expirado_count na tabela conf
    $sql = "ALTER TABLE conf ADD COLUMN expirado_count INT DEFAULT 0";
    $pdo->exec($sql);
    echo "<p style='color: green;'>✅ Coluna 'expirado_count' adicionada com sucesso à tabela 'conf'.</p>";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), "Duplicate column name") !== false) {
        echo "<p style='color: blue;'>ℹ️ A coluna 'expirado_count' já existe na tabela 'conf'.</p>";
    } else {
        echo "<p style='color: red;'>❌ Erro ao adicionar coluna: " . $e->getMessage() . "</p>";
    }
}

echo "<br><a href='painel/'>Voltar ao Painel</a>";
?>