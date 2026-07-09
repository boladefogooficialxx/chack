<?php
// test_ms_api.php — Simula a chamada da API de MS localmente para pegar o erro
$_GET['placa'] = 'NSA7173';
$_GET['renavam'] = '00525858237';

// Captura a saída do include
ob_start();
try {
    chdir('api');
    include "ms.php";
    chdir('..');
} catch (Throwable $e) {
    echo "\n\n❌ ERRO DETECTADO:\n";
    echo $e->getMessage() . "\n";
    echo "Linha: " . $e->getLine() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
$output = ob_get_clean();

echo "--- SAÍDA DA API ---\n";
echo $output;
echo "\n--- FIM DA SAÍDA ---\n";
