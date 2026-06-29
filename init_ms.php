<?php
require_once "db.php";

echo "<h2>Inicialização da Tela MS</h2>";

try {
    $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('MS', '{}', 0)");
    $stmt->execute();

    echo "<p style='color: green;'>✅ Tela 'MS' registrada com sucesso na tabela 'conf'.</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Erro ao registrar tela: " . $e->getMessage() . "</p>";
}

echo "<br><a href='painel/'>Voltar ao Painel</a>";
