<?php
// test_pyproxy.php — Testa o PyProxy que já está no buscarPlaca.php
header('Content-Type: application/json');

$proxy     = 'c31c3577c56b2059.shg.na.pyproxy.io:16666';
$proxyUser = 'josepdrjw25-zone-resi-region-br';
$proxyPass = 'A1b2C3d4';

// ─── TESTE 1: GET — verifica IP e localização ───────────────────────────────
$ch = curl_init('https://api.ipify.org?format=json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_PROXY,         $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD,  "$proxyUser:$proxyPass");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT,       15);

$ipRes   = curl_exec($ch);
$ipInfo  = curl_getinfo($ch);
$ipError = curl_error($ch);
curl_close($ch);

$ipData = json_decode($ipRes, true);

// ─── TESTE 2: GET geolocalização do IP ──────────────────────────────────────
$geoOk = false;
$geoData = null;
if (!empty($ipData['ip'])) {
    $chGeo = curl_init("https://ipapi.co/{$ipData['ip']}/json/");
    curl_setopt($chGeo, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chGeo, CURLOPT_TIMEOUT, 10);
    $geoRes  = curl_exec($chGeo);
    curl_close($chGeo);
    $geoData = json_decode($geoRes, true);
    $geoOk   = true;
}

// ─── TESTE 3: POST — verifica se POST funciona através do proxy ──────────────
$chPost = curl_init('https://httpbin.org/post');
curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chPost, CURLOPT_POST,           true);
curl_setopt($chPost, CURLOPT_POSTFIELDS,     json_encode(['teste' => 'post_via_proxy']));
curl_setopt($chPost, CURLOPT_HTTPHEADER,     ['Content-Type: application/json']);
curl_setopt($chPost, CURLOPT_PROXY,          $proxy);
curl_setopt($chPost, CURLOPT_PROXYUSERPWD,   "$proxyUser:$proxyPass");
curl_setopt($chPost, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chPost, CURLOPT_TIMEOUT,        15);

$postRes   = curl_exec($chPost);
$postInfo  = curl_getinfo($chPost);
$postError = curl_error($chPost);
curl_close($chPost);

$postOk = ($postInfo['http_code'] === 200);

// ─── RESULTADO ───────────────────────────────────────────────────────────────
echo json_encode([
    'proxy_testado'  => $proxy,

    'teste_GET' => [
        'funcionou'  => ($ipInfo['http_code'] === 200),
        'http_code'  => $ipInfo['http_code'],
        'erro'       => $ipError ?: null,
        'ip_retornado' => $ipData['ip'] ?? null,
    ],

    'geolocalizacao' => $geoOk ? [
        'pais'        => $geoData['country_name'] ?? null,
        'regiao'      => $geoData['region'] ?? null,
        'cidade'      => $geoData['city'] ?? null,
        'operadora'   => $geoData['org'] ?? null,
    ] : null,

    'teste_POST' => [
        'funcionou'  => $postOk,
        'http_code'  => $postInfo['http_code'],
        'erro'       => $postError ?: null,
        'bloqueado_proxy' => (!$postOk && strpos($postRes, 'not allowed') !== false),
        'resposta_raw' => $postOk ? '(POST respondeu corretamente)' : substr($postRes, 0, 300),
    ],

    'conclusao' => $postOk
        ? '✅ PyProxy funcional! GET e POST funcionando com IP brasileiro.'
        : '❌ PyProxy com problema no POST. Verifique as credenciais ou troque de zona.',

], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
