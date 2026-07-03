<?php
// proxy_test.php
require_once "db.php";
header('Content-Type: application/json');

$ch = curl_init('https://geo.brdtest.com/mygeo.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
apply_proxy_to_curl($ch);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$info = curl_getinfo($ch);
$error = curl_error($ch);
curl_close($ch);

echo json_encode([
    "success" => ($info['http_code'] == 200),
    "http_code" => $info['http_code'],
    "error" => $error,
    "geo_info" => json_decode($response, true),
    "proxy_used" => "brd.superproxy.io:33335"
], JSON_PRETTY_PRINT);
