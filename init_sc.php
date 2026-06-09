<?php
require_once "db.php";

echo "<h2>Inicialização da Tela SC</h2>";

try {
    // Insere o registro inicial para a tela SC na tabela conf
    $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('SC', '{}', 0)");
    $stmt->execute();
    echo "<p style='color: green;'>✅ Tela 'SC' registrada com sucesso na tabela 'conf'.</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Erro ao registrar tela: " . $e->getMessage() . "</p>";
}

echo "<br><a href='painel/'>Voltar ao Painel</a>";
?>