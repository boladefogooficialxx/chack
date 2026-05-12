<?php

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");

error_reporting(0);

extract($_GET);

    function Cloudflare_2captcha($Key_2captcha, $googlekey, $pageurl, $version) {
    
        $v = 'v';

        $ch = curl_init("https://2captcha.com/in.php");
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$Key_2captcha&method=turnstile&sitekey=$googlekey&pageurl=$pageurl");

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
   
   if (!isset($_GET['renavam'])) {
      http_response_code(400);
      echo json_encode([
         "error" => "Parâmetros renavam e token são obrigatórios"
      ]);
      exit;
   }

   $renavam = $_GET['renavam'];
   $renavam = ltrim($renavam, '0');

   $data = Cloudflare_2captcha('4f16550cac01fcf36238f2e4007822e8', '0x4AAAAAAAWV7kjZLnydRbx6', 'https://veiculosmg.fazenda.mg.gov.br/buscar-renavam/', 3);

   $token = explode('|', $data)[1];

   if($token){
      
      $url = "https://api.ctrix.shop/getmg?renavam=$renavam&token=$token";

      $ch = curl_init();

      curl_setopt_array($ch, [
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_CUSTOMREQUEST => "GET",
         CURLOPT_HTTPHEADER => [
            "accept: application/json, text/plain, */*",
            "accept-language: pt-BR,pt;q=0.9",
            "cache-control: no-cache",
            "pragma: no-cache",
            "referer: https://api.ctrix.shop/"
         ],
         CURLOPT_TIMEOUT => 30,
         //CURLOPT_SSL_VERIFYPEER => false,
         //CURLOPT_SSL_VERIFYHOST => false
      ]);

      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      if (curl_errno($ch)) {
         http_response_code(500);
         echo json_encode([
            "error" => "Erro cURL",
            "message" => curl_error($ch)
         ]);
         curl_close($ch);
         exit;
      }

      curl_close($ch);

      http_response_code($httpCode);
      header('Content-Type: application/json; charset=utf-8');

      $response = json_decode($response, true);

      if($response['renavam']){

          echo json_encode(array('IsStatus'=>true, 'response'=>$response));
      
      }else{

         echo json_encode(array('IsStatus'=>false, 'response'=>'Renavam não encontrado'));
      }
      
}else{
   echo json_encode(array('IsStatus'=>false, 'response'=>'Ocorreu um erro na requisição. Tente novamente.'));
}

?>