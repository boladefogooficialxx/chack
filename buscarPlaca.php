<?php  


extract($_GET);

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

$proxy =  'c31c3577c56b2059.shg.na.pyproxy.io:16666';//URL
$proxyuserpwd = 'josepdrjw25-zone-resi-region-br:A1b2C3d4';//USUARIO E SENHA

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://www.placai.com/api/placaOrder');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"placa\":\"$placa\",\"product_id\":1,\"utm\":{\"utm_term\":\"\",\"utm_campaign\":\"GA1_MAX\",\"utm_source\":\"google\",\"utm_medium\":\"{asset_id}\"},\"score\":\"0.0\"}");

curl_setopt($ch, CURLOPT_PROXY, $proxy);
curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuserpwd);

$headers = array();
$headers[] = 'Accept: application/json, text/plain, */*';
$headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cache-Control: no-cache';
$headers[] = 'Content-Type: application/json';
$headers[] = 'Dnt: 1';
$headers[] = 'Origin: https://www.placai.com';
$headers[] = 'Pragma: no-cache';
$headers[] = 'Priority: u=1, i';
$headers[] = 'Referer: https://www.placai.com/?utm_source=google&utm_medium={asset_id}&utm_campaign=GA1_MAX&utm_content=&utm_term=&gad_source=1&gad_campaignid=22505068973&gbraid=0AAAAAq4j3pAyjrOB0tjj9hdgyrpKpBYa5&gclid=Cj0KCQjw9czHBhCyARIsAFZlN8QPKJ9dXag1dXhlwqIZfyxZ3MlRnSA1TRNQzb9sxbBNp3qJU1f9h78aAli7EALw_wcB';
$headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"141\", \"Not?A_Brand\";v=\"8\", \"Chromium\";v=\"141\"';
$headers[] = 'Sec-Ch-Ua-Mobile: ?0';
$headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
$headers[] = 'Sec-Fetch-Dest: empty';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);

if($result){

   $dados =  json_decode($result);

    $transaction_id = $dados->data->transaction_id;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.placai.com/api/resultado/$transaction_id/preview");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    $headers = array();
    $headers[] = 'Accept: application/json, text/plain, */*';
    $headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
    $headers[] = 'Cache-Control: no-cache';
    $headers[] = 'Dnt: 1';
    $headers[] = 'Pragma: no-cache';
    $headers[] = 'Priority: u=1, i';
    $headers[] = "Referer: https://www.placai.com/order/$transaction_id";
    $headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"141\", \"Not?A_Brand\";v=\"8\", \"Chromium\";v=\"141\"';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

   $result = curl_exec($ch);

   if($result){

     $dados =  json_decode($result);

    if($dados && $dados->data->veiculo){

        $placa = $dados->data->veiculo->placa;
        $modelo = $dados->data->veiculo->modelo;
        $fabricante = $dados->data->veiculo->fabricante;
        $ano_fabricacao = $dados->data->veiculo->ano_fabricacao;
        $chassi = $dados->data->veiculo->chassi;
        $ano_modelo = $dados->data->veiculo->ano_modelo;
        
        echo $data = json_encode([
            "isStatus" => true,
            "data" => [
                "proprietario" => [
                    "nome" => false,
                    "placa" => $placa,
                    "cpfcnpj" => false,
                    "renavam" => false,
                    "chassi" => $chassi,
                    "municipioRegistro" => false,
                    "uf" => false,
                    "Segmento" => false,
                    "EspecieVeiculo" => false,
                    "TipoVeiculo" => false,
                    "Passageiros" => false,
                    "Motor" => false,
                    "Combustível" => false,
                    "Potencia" => false,
                    "Cilindrada" => false,
                    "Cor" => false,
                    "AnoModelo" => $ano_modelo,
                    "Importado" => false,
                    "Marca" => $fabricante,
                    "anodefabricacao" => $ano_fabricacao,
                    "marcamodelo" => $modelo,
                    "valorSemDesconto" => false
                ]
            ]]);
    }

   }

}