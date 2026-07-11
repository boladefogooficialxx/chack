<?php
// init_mt2.php
require_once "db.php";

echo "<h2>Inicialização da Tela MT2 (eFazenda MS Clone)</h2>";

try {
    $stmt = $pdoGlob->prepare("INSERT IGNORE INTO conf (tela, dados, expirado_count) VALUES ('MT2', '{}', 0)");
    $stmt->execute();

    echo "<p style='color: green;'>✅ Tela 'MT2' registrada com sucesso na tabela 'conf'.</p>";
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ Erro ao registrar tela: " . $e->getMessage() . "</p>";
}

echo "<br><a href='painel/'>Voltar ao Painel</a>";
