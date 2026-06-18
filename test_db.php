<?php
require_once "db.php";
echo "<h1>Teste de Banco de Dados</h1>";

if (!$pdo) {
    echo "<p style='color:red;'>❌ Erro ao conectar.</p>";
    exit;
}

echo "<p style='color:green;'>✅ Conectado ao banco: railway</p>";

try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<h3>Tabelas encontradas:</h3><ul>";
    foreach ($tables as $t) {
        echo "<li>$t</li>";
    }
    echo "</ul>";

    if (in_array('dominios', $tables)) {
        $stmt = $pdo->query("SELECT * FROM dominios");
        $doms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Conteúdo da tabela 'dominios':</h3><pre>";
        print_r($doms);
        echo "</pre>";
    } else {
        echo "<p style='color:orange;'>⚠️ Tabela 'dominios' não encontrada!</p>";
    }

} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Erro na consulta: " . $e->getMessage() . "</p>";
}
