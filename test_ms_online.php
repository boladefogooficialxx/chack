<?php
// test_ms_online.php — Executa a API ms.php exibindo erros detalhados
header('Content-Type: text/plain; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_GET['placa'] = 'NSA7173';
$_GET['renavam'] = '00525858237';

echo "=== INICIANDO TESTE ONLINE DA API DETRAN-MS ===\n\n";

try {
    // Tenta incluir db.php primeiro para verificar conexão do banco no contexto
    echo "1. Tentando incluir db.php... ";
    require_once "db.php";
    echo "✅ Conectado ao banco.\n";

    echo "2. Verificando se a tabela conf existe e tem a tela MS... ";
    $Glob = $pdo->prepare("SELECT dados FROM conf WHERE tela = 'MS' LIMIT 1");
    $Glob->execute();
    $row = $Glob->fetch();
    if ($row) {
        echo "✅ Config da tela MS encontrada.\n";
    } else {
        echo "❌ Config da tela MS não encontrada no banco!\n";
    }

    echo "3. Executando api/ms.php...\n";
    
    // Captura saídas HTML se existirem
    ob_start();
    include "api/ms.php";
    $apiOutput = ob_get_clean();

    echo "\n=== RETORNO DA API ===\n";
    echo $apiOutput . "\n";
    echo "=== FIM DO RETORNO ===\n";

} catch (Throwable $e) {
    echo "\n\n❌ ERRO DETECTADO (Throwable):\n";
    echo "Classe do erro: " . get_class($e) . "\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "Linha: " . $e->getLine() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
?>
