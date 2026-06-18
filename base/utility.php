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
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }

    $ip = $_SERVER['HTTP_CLIENT_IP']
        ?? $_SERVER['HTTP_X_FORWARDED_FOR']
        ?? $_SERVER['REMOTE_ADDR']
        ?? '0.0.0.0';

    if (strpos($ip, ',') !== false) {
        $ips = explode(',', $ip);
        // Tenta encontrar o primeiro IP que não seja privado se houver múltiplos
        foreach ($ips as $i) {
            $i = trim($i);
            if (filter_var($i, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                return $i;
            }
        }
        return trim($ips[0]);
    }
    return $ip;
}

function getFromIp(string $ip): ?object {
    $ip = trim($ip);

    if ($ip === '' || $ip === '0.0.0.0') {
        return null;
    }

    $endpoints = [
        "http://ip-api.com/json/" . urlencode($ip) . "?fields=status,message,country,region,regionName,city,org,as,query",
        "https://ipinfo.io/" . urlencode($ip) . "/json",
    ];

    foreach ($endpoints as $url) {
        $response = @file_get_contents($url);

        if ($response === false) {
            continue;
        }

        $data = json_decode($response);

        if (!$data) {
            continue;
        }

        if (isset($data->status) && $data->status === 'fail') {
            continue;
        }

        $data->regionName = $data->regionName ?? ($data->region ?? 'Desconhecido');
        $data->org = $data->org ?? ($data->isp ?? $data->as ?? 'Desconhecido');
        $data->country = $data->country ?? 'Desconhecido';
        $data->city = $data->city ?? 'Desconhecido';

        return $data;
    }

    return null;
}
