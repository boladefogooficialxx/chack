<?php

error_reporting(0);

extract($_GET);

extract($_POST);

if($renavam && $placa){

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://portal.expresso-goias.site/ipva-portal/ipva/api.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "renavam=$renavam&placa=$placa");

    $headers = array();
    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
    $headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
    $headers[] = 'Dnt: 1';
    $headers[] = 'Origin: https://portal.expresso-goias.site';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Priority: u=1, i';
    $headers[] = 'Referer: https://portal.expresso-goias.site/ipva-portal/aipva/?__cf_chl_tk=h6mL-ziv3Xk_vUhvqGCiXapmpdFo4B6.Y4AqiHFlQ92a4zstjEJBTEDpKc-QsExoiuCTZ.HGUP66MOzL-1760564024-1.0.1.1-c8kL1b54M4mdWe_jll1K';
    $headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"141\", \"Not?A_Brand\";v=\"8\", \"Chromium\";v=\"141\"';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    echo $result = curl_exec($ch);

}else{
   echo json_encode(array('status'=>false, 'msg'=>'Parâmetro placa ou Renavam não fornecido!'));
}

