<?php
// proxy_test.php — Diagnóstico completo do proxy Bright Data
require_once "db.php";
header('Content-Type: application/json');

// Lê config atual do banco (sem depender do active_*)
$proxyConf = get_proxy_config();

// Força o proxy independente dos flags active_*, apenas para teste
$ch = curl_init('https://api.ipify.org?format=json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);

$proxyAplicado = false;
if (!empty($proxyConf['host'])) {
    curl_setopt($ch, CURLOPT_PROXY, $proxyConf['host']);
    if (!empty($proxyConf['port'])) {
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxyConf['port']);
    }
    if (!empty($proxyConf['userpwd'])) {
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyConf['userpwd']);
    }
    $proxyAplicado = true;
}

$response = curl_exec($ch);
$info     = curl_getinfo($ch);
$error    = curl_error($ch);
curl_close($ch);

// Também testa sem proxy para comparar o IP real do servidor
$chSemProxy = curl_init('https://api.ipify.org?format=json');
curl_setopt($chSemProxy, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chSemProxy, CURLOPT_TIMEOUT, 10);
$ipReal       = curl_exec($chSemProxy);
$errorIpReal  = curl_error($chSemProxy);
curl_close($chSemProxy);

$ipRealData = json_decode($ipReal, true);

echo json_encode([
    "proxy_funcionando"  => ($info['http_code'] == 200),
    "http_code"          => $info['http_code'],
    "erro_proxy"         => $error ?: null,
    "geo_info_via_proxy" => json_decode($response, true),
    "ip_real_servidor"   => $ipRealData['ip'] ?? ($errorIpReal ?: 'erro'),
    "config_no_banco"    => [
        "host"          => $proxyConf['host'] ?? '(não configurado)',
        "port"          => $proxyConf['port'] ?? '(não configurado)',
        "userpwd_set"   => !empty($proxyConf['userpwd']) ? '✅ sim' : '❌ não',
        "active_ms"     => $proxyConf['active_ms'] ?? false,
        "active_es"     => $proxyConf['active_es'] ?? false,
        "active_sc"     => $proxyConf['active_sc'] ?? false,
        "active_pgmei"  => $proxyConf['active_pgmei'] ?? false,
    ],
    "proxy_aplicado_no_teste" => $proxyAplicado,
    "instrucao" => $info['http_code'] == 200
        ? "✅ Proxy OK! IP do servidor vai aparecer como Bright Data nas consultas onde active_* = true."
        : "❌ Proxy com problema. Verifique as credenciais e se a porta está liberada."
], JSON_PRETTY_PRINT);
