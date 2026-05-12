<?php

date_default_timezone_set('America/Sao_Paulo');

$rede_signatures_blocked = [
    // Bots conhecidos
    'googlebot','bingbot','slurp','duckduckbot','baiduspider','yandex','sogou',
    'exabot','facebot','ia_archiver','mj12bot','healthbot','semrushbot','ahrefsbot',
    'twitterbot','applebot','petalbot','linkedinbot',
    // Datacenters / hospedagens conhecidas
    'google llc','amazon','microsoft','ovh','digitalocean','hetzner','Google Singapore Pte', 
    'Level 3 Communications, Inc','contabo','linode','vultr','azure','upcloud','leaseweb','choopa',
    'cloudflare','Psychz Networks','cheapy.host LLC','Level 3 Communications','Huawei International Pte',
    'Tata Tele Services GSM','Chunghwa Telecom Co., Ltd','Online S.A.S.','AT&T Corp.','Datacamp Limited'
];

function isBotNetwork(string $povedor, array $assinaturas): bool {
    foreach ($assinaturas as $sig) {
        if ($sig === '') continue;
        if (stripos($povedor, $sig) !== false) {
            return true;
        }
    }
    return false;
}

function getClientIp(): string {
    return $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? '0.0.0.0';
}

function getFromIp(string $ip): ?object {

    //$url = "http://ip-api.com/json/" . urlencode($ip);
    $url = "https://ipinfo.io/" . urlencode($ip) . "/json";
    $response = @file_get_contents($url);

    if ($response === false) {
        return null;
    }

    $data = json_decode($response);

    // Ajuste para evitar warnings se as propriedades não existirem
    $data->regionName = $data->regionName ?? ($data->region ?? 'Desconhecido');
    $data->status = $data->status ?? (isset($data->ip) ? 'success' : 'fail');
    $data->org = $data->org ?? ($data->as ?? 'Desconhecido');


    if (!isset($data->status) || $data->status !== 'success') {
        return null;
    }

    return $data;
}
