<?php
require_once "db.php";
try {
    $stmt = $pdo->prepare("INSERT IGNORE INTO conf (tela, dados) VALUES ('ES', '{}')");
    $stmt->execute();
    echo "Tabela 'conf' atualizada com a tela 'ES'.";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>