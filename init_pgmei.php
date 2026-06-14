<?php
require_once "db.php";
try {
    $cookies = '__RequestVerificationToken_L1NpbXBsZXNOYWNpb25hbC9BcGxpY2Fjb2VzL0FUU1BPL3BnbWVpLmFwcA2=9irpGwvgTDOpsTQ1_FYQ_lqUoX8WWlBPiQ3fkRyxubATlMaNhi1f6hJXx2HonrZXbtgh_guuWJ7S9sg9EFyz2l7sW5MFV9vEib-hrZN7vJs1; ARRAffinity=e09bffb4169be1fe379ef3b131a0ed3f4bf117e508242445e58e5ec88a661668; ASP.NET_SessionId=sl0f4lveowwi11px3kim1grw';
    $token = 'WUuEyIdbBkknRil1smeAJTAC_QMKc7qzj3VRjOjpHVJRGmSHwmLhky4c35HqfRfD2VhqhMG_KiUXKvOOTT3CdG2esDcIw4QoNZDnP4LltwE1';
    
    $dados = json_encode(['cookies' => $cookies, 'token' => $token]);
    
    // Corrigido: Usando placeholders nomeados corretamente para evitar o erro HY093
    $stmt = $pdo->prepare("INSERT INTO conf (tela, dados) VALUES ('PGMEI', :dados1) ON DUPLICATE KEY UPDATE dados = :dados2");
    $stmt->execute([
        ':dados1' => $dados,
        ':dados2' => $dados
    ]);
    
    echo "Tabela 'conf' atualizada com a tela 'PGMEI' e os tokens fornecidos.";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>