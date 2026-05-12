<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www8.receita.fazenda.gov.br/SimplesNacional/Aplicacoes/ATSPO/pgmei.app/Home/Inicio');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'cache-control: max-age=0',
    'priority: u=0, i',
    'sec-ch-ua: "Not:A-Brand";v="99", "Microsoft Edge";v="145", "Chromium";v="145"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: document',
    'sec-fetch-mode: navigate',
    'sec-fetch-site: none',
    'sec-fetch-user: ?1',
    'upgrade-insecure-requests: 1',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0curl',
]);
curl_setopt($ch, CURLOPT_COOKIE, '__RequestVerificationToken_L1NpbXBsZXNOYWNpb25hbC9BcGxpY2Fjb2VzL0FUU1BPL3BnbWVpLmFwcA2=IXNYbMMh_EwFePF01yqoa-5Umj8a9Jo-QsAhupkn-PYbK9Mghk10SEzOSr8HXJ3wyODxRopZ2CK-cBMh6FpFz5YAajhIl_RJ7tZweF9sgqo1; ARRAffinity=e09bffb4169be1fe379ef3b131a0ed3f4bf117e508242445e58e5ec88a661668; ASP.NET_SessionId=bpxt0bi5o33m2cu0ay2lntje');

$response = curl_exec($ch);

curl_close($ch);
echo $response;