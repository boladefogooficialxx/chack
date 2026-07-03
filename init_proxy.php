<?php
// init_proxy.php
require_once "db.php";
try {
    $defaultDados = json_encode([
        'host' => 'brd.superproxy.io',
        'port' => '33335',
        'userpwd' => 'brd-customer-hl_6da07c7b-zone-pgmei_proxy:j0yxh8rpl1ku',
        'active_ms' => true,
        'active_es' => false,
        'active_sc' => false,
        'active_pgmei' => false
    ]);
    
    // Insere ou atualiza as configurações padrão na tabela `conf`
    $stmt = $pdo->prepare("INSERT INTO conf (tela, dados, expirado_count) VALUES ('proxy', ?, 0) ON DUPLICATE KEY UPDATE dados = ?");
    $stmt->execute([$defaultDados, $defaultDados]);
    echo "Tabela 'conf' atualizada com as configuracoes padrao do proxy (Bright Data).\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
?>
