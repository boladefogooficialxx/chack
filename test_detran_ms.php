<?php
// test_detran_ms.php — Testa se o proxy consegue acessar o site do Detran-MS
header('Content-Type: application/json');

$proxyConf = [
    'host' => '46.149.128.20',
    'port' => '63352',
    'userpwd' => 'akZVur7b:YAPY7WjE'
];

$ch = curl_init('https://www.meudetran.ms.gov.br/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

// Aplica proxy
curl_setopt($ch, CURLOPT_PROXY, $proxyConf['host']);
curl_setopt($ch, CURLOPT_PROXYPORT, $proxyConf['port']);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyConf['userpwd']);

$response = curl_exec($ch);
$info = curl_getinfo($ch);
$error = curl_error($ch);
curl_close($ch);

echo json_encode([
    'url_testada' => 'https://www.meudetran.ms.gov.br/',
    'http_code' => $info['http_code'],
    'curl_error' => $error ?: null,
    'tamanho_resposta' => strlen($response),
    'resposta_contem_detran' => (strpos($response, 'detran') !== false || strpos($response, 'Detran') !== false),
    'inicio_resposta' => substr(strip_tags($response), 0, 300),
    'conclusao' => ($info['http_code'] === 200) 
        ? '✅ O proxy consegue acessar o Detran-MS perfeitamente!' 
        : '❌ Acesso falhou através do proxy.'
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
