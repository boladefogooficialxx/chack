<?php

// === TOKEN ORIGINAL ===
$jwt = 'eyJ4NXQiOiJZbU0yWkRjMVpqZzFOakk1WkRGaFlqVXdaR0V4TldWaFpEY3hOakZrT0dFMk16Wm1OVFF5WWprek9UQTJNR0ZoTnpCbE5tUmlOamhqWlRWaE9EQTNZdyIsImtpZCI6IlltTTJaRGMxWmpnMU5qSTVaREZoWWpVd1pHRXhOV1ZoWkRjeE5qRmtPR0UyTXpabU5UUXlZamt6T1RBMk1HRmhOekJsTm1SaU5qaGpaVFZoT0RBM1l3X1JTMjU2IiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiIwNDY1NTY2MjM1MiIsImF1dCI6IkFQUExJQ0FUSU9OX1VTRVIiLCJlbWFpbF92ZXJpZmllZCI6InRydWUiLCJwcm9maWxlIjoiaHR0cHM6XC9cL3NlcnZpY29zLmFjZXNzby5nb3YuYnJcLyIsImlzcyI6Imh0dHBzOlwvXC9zc28uZ28uZ292LmJyOjQ0M1wvb2F1dGgyXC90b2tlbiIsInBob25lX251bWJlcl92ZXJpZmllZCI6InRydWUiLCJpc19zZXJ2aWRvciI6Ik4iLCJwaWN0dXJlIjoiaHR0cHM6XC9cL3Nzby5hY2Vzc28uZ292LmJyXC91c2VyaW5mb1wvcGljdHVyZSIsImF1ZCI6IkhEZnRfQklUYlhHcFBqbTlVRzBNT0M5WmZWQWEiLCJuYmYiOjE3NjI5NTY3MTEsImF6cCI6IkhEZnRfQklUYlhHcFBqbTlVRzBNT0M5WmZWQWEiLCJzY29wZSI6ImVtYWlsIGdvdmJyX2NvbmZpYWJpbGlkYWRlcyBvcGVuaWQgcHJvZmlsZSIsIm5hbWUiOiJJVkFMRE8gR09NRVMgREUgTElNQSIsImVtcHJlc2FzIjoiW10iLCJwaG9uZV9udW1iZXIiOiI5OTk4NDE0MDY2NSIsInNlbG9zIjpbIntcIm5pdmVpc1wiOlt7XCJpZFwiOlwiMVwiIiwiXCJkYXRhQXR1YWxpemFjYW9cIjpcIjIwMjMtMDItMjRUMTg6MDk6MTQuNDQ4LTAzMDBcIn0iLCJ7XCJpZFwiOlwiMlwiIiwiXCJkYXRhQXR1YWxpemFjYW9cIjpcIjIwMjUtMDktMjZUMTM6MTQ6MzYuNjAzLTAzMDBcIn1dIiwiXCJjYXRlZ29yaWFzXCI6W3tcImlkXCI6XCIxMDJcIiIsIlwiZGF0YUF0dWFsaXphY2FvXCI6XCIyMDIzLTAyLTI0VDE4OjA5OjE0LjQ0OC0wMzAwXCJ9Iiwie1wiaWRcIjpcIjIwMlwiIiwiXCJkYXRhQXR1YWxpemFjYW9cIjpcIjIwMjUtMDktMjZUMTM6MTQ6MzYuNjAzLTAzMDBcIn1dIiwiXCJjb25maWFiaWxpZGFkZXNcIjpbe1wiaWRcIjpcIjIwMVwiIiwiXCJkYXRhQXR1YWxpemFjYW9cIjpcIjIwMjMtMDItMjRUMTg6MDk6MTQuNDQ4LTAzMDBcIn0iLCJ7XCJpZFwiOlwiNDAxXCIiLCJcImRhdGFBdHVhbGl6YWNhb1wiOlwiMjAyNS0wOS0yNlQxMzoxNDozNi42MDMtMDMwMFwifV19Il0sImV4cCI6MTc2Mjk2MDMxMSwiaWF0IjoxNzYyOTU2NzExLCJqdGkiOiIxZWE3M2Q5ZC1hNTQ0LTRmZWMtOGVkNy1mZTQwOWFiYTA1YTMiLCJlbWFpbCI6Im1hZ25hdGFmMjZAZ21haWwuY29tIn0.GEqKQvXHcU1IOFnTrzpXOzIB6WnuLjLH2h1rVZRxIIEHigC2mmDmzzGqJuJUEuX8X0iWKIvueNkvm0-HxzTVgMou-llDrK0f7KBEUlCpUttr7lw9ahifixQirRczZj0c8GtVb3p4KL3x2vRaYfyem6ZrC6Qe9R99FJgbX16HjGGieE8jfRVlfXJmnuCIrIANKz3W7QGB5oxPJ88xK1CFktf6LeBILFymNwjT0lLudIvupD-97IQWQNMbtXgiFUmWWv2hrNEn68SfDVyLv3R7xS1j45S1IY1fJePSzEhkAOSCpEYWSyXVjoxOqokTra1hqG9FIIbRTmk5b6OWub5_xw';

// === FUNÇÕES AUXILIARES ===

// Base64URL encode (sem usar + ou /)
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// Base64URL decode
function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

// === 1. Decodificar ===
$parts = explode('.', $jwt);
if (count($parts) !== 3) {
    die("Token inválido");
}

list($headerB64, $payloadB64, $signatureB64) = $parts;

$header = json_decode(base64url_decode($headerB64), true);
$payload = json_decode(base64url_decode($payloadB64), true);

// === 2. Alterar algo no payload ===
//$payload['nome'] = 'JOÃO TESTE';  // Exemplo de alteração
$payload['alterado_em'] = date('c');

// === 3. Recriar o token (sem assinar de verdade) ===
$newHeaderB64 = base64url_encode(json_encode($header));
$newPayloadB64 = base64url_encode(json_encode($payload));

// aqui criamos uma assinatura fake (exemplo)
$newSignatureB64 = base64url_encode(hash_hmac('sha256', "$newHeaderB64.$newPayloadB64", 'minha_chave_secreta', true));

// monta o novo JWT
$newJwt = "$newHeaderB64.$newPayloadB64.$newSignatureB64";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.go.gov.br/detran/veiculointegracao/1.0.0/sedi/veiculo/consultarVeiculoPorPlacaRenavam?placa=JFA6J69&renavam=00524783560');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Application-Name: EXPRESSO_CONSULTA_VEICULO';
$headers[] = 'Authorization: Bearer '.$jwt;
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Dnt: 1';
$headers[] = 'Origin: https://www.go.gov.br';
$headers[] = 'Referer: https://www.go.gov.br/';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Site: cross-site';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36';
$headers[] = 'Sec-Ch-Ua: \"Chromium\";v=\"142\", \"Google Chrome\";v=\"142\", \"Not_A Brand\";v=\"99\"';
$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
$headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
$headers[] = 'Session: eyJzaXN0ZW1hIjoiU1NFREkiLCJjb2RnQ2hhdmUiOiJORkY0MjA5IiwiY29kZ1RpcG9DaGF2ZSI6IjAzIiwiaWRTZXJ2aWNvIjoxMzcwOSwiaWRTZXNzYW8iOjE4ODA4MzcxMSwiaXAiOiIxMDMuODguMjMzLjIyMiIsImlkSGlzdE9wZXJhZG9yIjoxMzU2NjI3MDYsImlkSGlzdFNlcnZpY29TaXN0ZW1hIjozMDg4NX0=';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//echo $result = curl_exec($ch);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.go.gov.br/detran/financeiro/1.0.0/sedi/financeiro/consultarVeiculoPorPlacaRenavam?placa=KDL8131&renavam=00706787617');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$headers = array();
$headers[] = 'Accept: */*';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Application-Name: EXPRESSO_CONSULTA_VEICULO';
$headers[] = 'Authorization: Bearer '.$jwt;
$headers[] = 'Connection: keep-alive';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Dnt: 1';
$headers[] = 'Origin: https://www.go.gov.br';
$headers[] = 'Referer: https://www.go.gov.br/';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Site: cross-site';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36';
$headers[] = 'Sec-Ch-Ua: \"Chromium\";v=\"142\", \"Google Chrome\";v=\"142\", \"Not_A Brand\";v=\"99\"';
$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
$headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
$headers[] = 'Session: eyJzaXN0ZW1hIjoiU1NFREkiLCJjb2RnQ2hhdmUiOiJORkY0MjA5IiwiY29kZ1RpcG9DaGF2ZSI6IjAzIiwiaWRTZXJ2aWNvIjoxMzcwOSwiaWRTZXNzYW8iOjE4ODA4MzcxMSwiaXAiOiIxMDMuODguMjMzLjIyMiIsImlkSGlzdE9wZXJhZG9yIjoxMzU2NjI3MDYsImlkSGlzdFNlcnZpY29TaXN0ZW1hIjozMDg4NX0=';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

echo $result = curl_exec($ch);
 
return;

$result = json_decode($daddos);

if($result->token){

    $token = $result->token;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://backend.detran.sc.gov.br/transito-api/veiculo/resposta-consulta?t='.$token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
    $headers[] = 'Authorization: Bearer eyJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiUlNBLU9BRVAtMjU2In0.dInkLPiybL4vTzLouQ9Oe9c4zZm1LyRg7dDPAbTmDbWbPPoo7xWi2DD4OqnqULtNOT2LW9LDJ8COnsz7XkVj8ixHW2B--Mcnk_veRbrNUh4YLyCGXa-rvSC7KAW80M-j_-iBLmOLTb8MHCWjLK6R2OnjYUUJRwiP22LL8p_hIZeAqxLkBguov2zlHf-5f6VuNdL7ndUSv-phpOe6kgDJjbglwaWkyuf0FaneAcaPNGZRe0KtelEcjwKN2fiKuoUGq1Y4vPXvWvqK9hF6UP0n8u5VR7qG5BdRlGUBwXIci7Ngf6Trc9nnFbSs7QJoS90exSDWAETeQw42Uu_gcPYKHQ.oqsqrXDxOGwGYMSe.edp_JF2ApAqD1Zbbuz783qzN4A6tXBw1DJk9LpAHEzKSU_ln1OgIomoyyVZCc1WRv3LAywSQuo7X9Yr8kw4NWFs49ZbDN4ex7a51q687Yr1NzsMSg4g-nSIdEHHsZVl6-4BwjkTeUNwCxkI9myfZGsr9DN6b5goLylaTHtjucFMF0l6IKm3uH24xdJ3SyzgKlcqe2B3UP1G1ltCBCGQzWUQVsKvEn_bQmvDUNMSKC9HppL8hEXF2AAswVADoSY5U_a8VrleoGz_F3tJ-AjYph5HK8RghUDrIf3S_8wtbYB3OHp_8mxLVxC6-DE9_oOjLS6Kj3MV3ZI_qPzff7O7sWi7nV9eO4vWDGDSHSP3taO81DpgyJm9tlr6-e2NU50EQ4Oa2TywXVpaX3i-k56q9J4OUBDraKNV8pYZqWrgKQHHMzpZGPmKRKT0QC8Lb9oHfo0SV3eipPOu8dah5PfJurQpnw1H2wisLqi58MGLPWsrYhThwfD_1zPP3ZJ-T8xG5U6BGHD01D6jWGf3on5oNaTP652MkQumvhpuc0MymXf0HsW-OT3lysExqKUE9k6JxdiaVoKvtjdpE3UlnIJBaB8PBgjOCvJ7PzUcayC2nM6tWfFlwnkml0SEBDp7ZPSyfaDs88Y5c4JLmc_pADuEnwPFtSNpNueDbRVn2KrBZr7QfiJcVKCu7L15S0KJyQ_mfmtWpj6DjfMZFBrPocsVcdNFu4xsdtw.zfdy9Qm8RUjfx8AdMe8fIw';
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Dnt: 1';
    $headers[] = 'Origin: https://servicos.detran.sc.gov.br';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Referer: https://servicos.detran.sc.gov.br/';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Site: same-site';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36';
    $headers[] = 'Sec-Ch-Ua: \"Chromium\";v=\"142\", \"Google Chrome\";v=\"142\", \"Not_A Brand\";v=\"99\"';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    echo $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

}else{

  echo $daddos;

}


