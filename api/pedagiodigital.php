<?php

extract($_GET);

header('Content-Type: application/json');

if (!isset($_GET['placa']) || !$placa) {
    http_response_code(400);
    echo json_encode([
        "IsStatus" => false,
        "error" => "Parâmetro placa é obrigatório"
    ]);
    exit;
}

sleep(2);

function gerarValor() {
    // Valor entre 10.00 e 60.00
    $valor = mt_rand(1000, 6000) / 100;
    return number_format($valor, 2, '.', '');
}

function formatarReal($valor) {
    return  number_format($valor, 2, ',', '.');
}

echo $json = '{
    "IsStatus": true,
    "debitos": [
        {
            "idPassagem": 16878467,
            "placa": "' . $placa . '",
            "concessao": "MSVia",
            "concessaoCNPJ": "19.642.306/0001-70",
            "data": "2022-09-05T19:01:27",
            "valor": "' . gerarValor() . '",
            "vencimento": "2022-10-05T19:01:27",
            "vencimentoFormatado": "05/10/2022",
            "local": "",
            "status": "Pendente",
            "eixos": null,
            "motivoCobranca": null,
            "valorJuros": "0.0000",
            "encargos": null,
            "valorMulta": "0.0000",
            "valorTotal": "' . formatarReal(gerarValor()) . '",
            "bl_Pix_Pedido": false,
            "bl_Contestacao": 0,
            "bl_FreeFlow": false
        },
        {
            "idPassagem": 16792850,
            "placa": "' . $placa . '",
            "concessao": "MSVia",
            "concessaoCNPJ": "19.642.306/0001-70",
            "data": "2022-09-05T20:08:09",
            "valor": "' . gerarValor() . '",
            "vencimento": "2022-10-05T20:08:09",
            "vencimentoFormatado": "05/10/2022",
            "local": "",
            "status": "Pendente",
            "eixos": null,
            "motivoCobranca": null,
            "valorJuros": "0.0000",
            "encargos": null,
            "valorMulta": "0.0000",
            "valorTotal": "' . formatarReal(gerarValor()) . '",
            "bl_Pix_Pedido": false,
            "bl_Contestacao": 0,
            "bl_FreeFlow": false
        }
    ]
}';


return;

function Key_2captcha($Key_2captcha, $googlekey, $pageurl, $version, $re=false) {
    $v = 'v';

    if($re){
        $ch = curl_init("https://2captcha.com/in.php?key=$Key_2captcha&method=hcaptcha&sitekey=$googlekey&pageurl=$pageurl");
    }else{
        $ch = curl_init("https://2captcha.com/in.php?key=$Key_2captcha&method=userrecaptcha&googlekey=$googlekey&pageurl=$pageurl&version=$version");
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    $res = curl_exec($ch);

    if (strpos($res, 'OK') !== false){

        $res2=false;
        $id = explode('|', $res)[1];

            for($i=0;$i<50;$i++){

                        if (strpos($res2, 'OK') !== false){
                            $r = explode('|', $res2)[1];
                            return $i.'|'.$r;
                             $i = 50;

                        }else{ 
                            $ch = curl_init("https://2captcha.com/res.php?key=$Key_2captcha&action=get&id=$id");
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                            $res2 = curl_exec($ch);
                            $i++; 
                        }
              sleep(3);
            }

    }else{
        return $res;
    }

}

$DataCap  =  Key_2captcha('4f16550cac01fcf36238f2e4007822e8','6LfNthIrAAAAAIezkzLOg01fWHcyQtk-PjbraHwz', 'https://pedagiodigital.com/', 3);
echo $recap = explode('|', $DataCap)[1];

if(!$recap){
    echo json_encode([
        "IsStatus" => false,
        "error" => "Não foi possível resolver o captcha"
    ]);
    exit;
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://pedagiodigital.com/pedagiodigital-api/api/Passagem/list-avulso');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json, text/javascript, */*; q=0.01',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'content-type: application/json; charset=UTF-8',
    'origin: https://pedagiodigital.com',
    'priority: u=1, i',
    'sec-ch-ua: "Not:A-Brand";v="99", "Microsoft Edge";v="145", "Chromium";v="145"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0',
    'x-requested-with: XMLHttpRequest',
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, '{"placa":"'.$placa.'","token":"Ux2Ycn5uUty1SSTMKHnoXlNeN8KDN2ZItZqj7wlm6Zo","tokenCaptcha":"'.$recap.'"}');

echo $response = curl_exec($ch);


return;
if(!$response){

    echo json_encode([
        "IsStatus" => false,
        "error" => "Não foi possível obter a resposta da API"
    ]);
    exit;

}else if(strpos($response, 'Captcha inválido') !== false){

    echo json_encode([
        "IsStatus" => false,
        "error" => "Captcha Token de acesso inválido"
    ]);
    exit;   

}else{
    echo json_encode([
        "IsStatus" => true,
        "data" => json_decode($response)
    ]);     

}

 