<?php

error_reporting(0);

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

extract($_GET);

if($placa){

   include_once('./base/function.php');

   include('./base/simple_html_dom.php');

   function PuxarTabela($html){

       $dom = new simple_html_dom();
       $dom->load($html);

       $tabela = array();

       foreach ($dom->find('table tr') as $linha) {
           $linhaArray = array();
           foreach ($linha->find('td, th') as $celula) {
               $linhaArray[] = $celula->plaintext;
           }
           $tabela[] = $linhaArray;
       }

       $dom->clear();
       unset($dom);

       return array('tabela'=>$tabela);
   }

   $doc = new DOMDocument();

    $proxy =  'c31c3577c56b2059.shg.na.pyproxy.io:16666';//URL
    $proxyuserpwd = 'josepdrjw25-zone-resi-region-br:A1b2C3d4';//USUARIO E SENHA

    //$proxy = "x351.fxdx.in:14534";
    //$proxyuserpwd = 'atecubanossmit263350:cjb9yrh1ym91';//USUARIO E SENHA

    //curl -x 4bca989496ccb865.zqz.na.pyproxy.io:16666 -U "brasil10-zone-resi-region-br:10proxy" ipinfo.pyproxy.io
    
   unlink("/cookie.txt");

   $ch = curl_init();

   curl_setopt($ch, CURLOPT_URL, "https://placaipva.com.br/placa/$placa");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

   curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

   curl_setopt($ch, CURLOPT_PROXY, $proxy);
   curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuserpwd);

   curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt');
   curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt');
   curl_setopt($ch, CURLOPT_COOKIE, dirname(__FILE__) . '/cookie.txt');
   curl_setopt($ch, CURLOPT_COOKIESESSION, dirname(__FILE__) . '/cookie.txt');

   $headers = array();
   $headers[] = 'Authority: ipva-goias.emitirguiapagamento.online';
   $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7';
   $headers[] = 'Accept-Language: pt,en;q=0.9,pt-BR;q=0.8,tr;q=0.7,ja;q=0.6,en-US;q=0.5';
   $headers[] = 'Referer: https://ipva-goias.emitirguiapagamento.online/ipva.php';
   $headers[] = 'Sec-Ch-Ua: ^^Google';
   $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
   $headers[] = 'Sec-Ch-Ua-Platform: ^^Windows^^\"\"';
   $headers[] = 'Sec-Fetch-Dest: document';
   $headers[] = 'Sec-Fetch-Mode: navigate';
   $headers[] = 'Sec-Fetch-Site: same-origin';
   $headers[] = 'Sec-Fetch-User: ?1';
   $headers[] = 'Upgrade-Insecure-Requests: 1';
   $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36';
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

   $html = curl_exec($ch);

     if($html){

     if (strpos($html, 'não foi encontrada') !== false){

         echo $dados = json_encode(array('isStatus'=>false, 'message'=>'Verifique seus dados e tente novamente'));

     }else if (strpos($html, 'You are being rate limited') !== false){

             echo $dados = json_encode(array('isStatus'=>false, 'message'=>'Verifique seus dados e tente novamente'));

             exit();

         }else{

             $doc->loadHTML($html);

             $xpath = new DOMXPath($doc);

             $class = 'fipeTablePriceDetail';
             $elementoTitle = $xpath->query("//*[@class='$class']")->item(0);

             if ($elementoTitle) {

                 $htmlD = $doc->saveHTML($elementoTitle);

                 $data = PuxarTabela($htmlD);

             }else{


                 echo $dados = json_encode(array('isStatus'=>false, 'message'=>'Verifique seus dados e tente novamente'));

                 exit();
             }   

             $class = 'divTable';

             $elementoValor = $xpath->query("//*[@class='$class']")->item(0);

             if ($elementoValor) {

                 $htmlS = $doc->saveHTML($elementoValor);

                 $dataV = PuxarTabela($htmlS);

             }


             if (strpos($html, 'Não foram encontrados detalhes de IPVA') !== false){

                 $dataV = json_decode('{"tabela":[["Estado","Valor Venal","Taxa","Valor IPVA"],["AC","00,00"],["AL","00,00","0,00%","00,00"]]}');

             }

             $dados = json_encode(array('isStatus'=>true, 'dados'=>$data,'valores'=>$dataV));

             $dadoARRAY = json_decode($dados);

             for ($i=0; $i < count($dadoARRAY->dados->tabela); $i++) { 

                   if($dadoARRAY->dados->tabela[$i][0]=='Modelo:'){
                       $marcamodelo = $dadoARRAY->dados->tabela[$i][1];
                   }
                   if($dadoARRAY->dados->tabela[$i][0]=='Ano:'){
                       $anodefabricacao = $dadoARRAY->dados->tabela[$i][1];
                   }
                   if($dadoARRAY->dados->tabela[$i][0]=='Marca:'){
                        $Marca = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Importado:'){
                        $Importado = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Ano Modelo:'){
                        $AnoModelo = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Cor:'){
                        $Cor = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Cilindrada:'){
                        $Cilindrada = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Potencia:'){
                        $Potencia = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Combustível:'){
                        $Combustível = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Chassi:'){
                        $Chassi = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Motor:'){
                        $Motor = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Passageiros:'){
                        $Passageiros = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='UF:'){
                        $UF = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Município:'){
                        $Município = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Tipo Veiculo:'){
                        $TipoVeiculo = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Especie Veiculo:'){
                        $EspecieVeiculo = $dadoARRAY->dados->tabela[$i][1];
                    }
                    if($dadoARRAY->dados->tabela[$i][0]=='Segmento:'){
                        $Segmento = $dadoARRAY->dados->tabela[$i][1];
                    }
              }

                for ($i=0; $i < count($dadoARRAY->valores->tabela); $i++) { 

                    if($dadoARRAY->valores->tabela[$i][0]=='Valor IPVA:'){
                        $ValorIPVA = str_replace(',', '.',str_replace('.', '', preg_replace('/[^0-9.,]/', '', $dadoARRAY->valores->tabela[$i][1])));
                    }

                    if($dadoARRAY->valores->tabela[$i][0]=='Aliquota:'){
                        $Aliquota = $dadoARRAY->valores->tabela[$i][1];
                    }

                    if($dadoARRAY->valores->tabela[$i][0]=='Valor Venal:'){
                        $ValorVenal = $dadoARRAY->valores->tabela[$i][1];
                    }
                }

                $debitos =  [];

                if($ValorIPVA){

                    $valorcota = number_format($ValorIPVA/3, 2, '.', '');

                    date_default_timezone_set('America/Sao_Paulo');
                    $dataDia = date('d/m/Y');

                    $debitos = array(
                        ['valortotal'=>$valorcota,'ano'=>'2024','tributo'=>'Cota 1','receita'=>$valorcota,'multa'=>'00,0','juros'=>'00,0','vencimento'=>$dataDia],
                        ['valortotal'=>$valorcota,'ano'=>'2024','tributo'=>'Cota 2','receita'=>$valorcota,'multa'=>'00,0','juros'=>'00,0','vencimento'=>$dataDia],
                        ['valortotal'=>$valorcota,'ano'=>'2024','tributo'=>'Cota 3','receita'=>$valorcota,'multa'=>'00,0','juros'=>'00,0','vencimento'=>$dataDia],
                        ['valortotal'=>$ValorIPVA,'ano'=>'2024','tributo'=>'IPVA Cota unica','receita'=>$ValorIPVA,'multa'=>'00,0','juros'=>'00,0','vencimento'=>$dataDia]
                    );

                }else{
                    $ValorIPVA = 0;
                }

                echo $dados = json_encode(array('isStatus'=>true, 'data'=>array('proprietario'=>array('nome'=>false, 'placa'=>$placa, 'cpfcnpj'=>false, 'renavam'=>false, 'chassi'=>$Chassi, 'municipioRegistro'=>$Município, 'uf'=>$UF, 'Segmento'=>$Segmento, 'EspecieVeiculo'=>$EspecieVeiculo, 'TipoVeiculo'=>$TipoVeiculo, 'Passageiros'=>$Passageiros, 'Motor'=>$Motor, 'Combustível'=>$Combustível, 'Potencia'=>$Potencia, 'Cilindrada'=>$Cilindrada, 'Cor'=>$Cor, 'AnoModelo'=>$AnoModelo, 'Importado'=>$Importado, 'Marca'=>$Marca, 'anodefabricacao'=>$anodefabricacao, 'marcamodelo'=>$marcamodelo, 'valorSemDesconto'=>$ValorIPVA),'debitos'=>$debitos)));
              
                $proprietario = json_encode(json_decode($dados)->data->proprietario);

                if($_COOKIE['vehicle']){

                    setcookie('vehicle', "{'placa':'$placa', proprietario:".$proprietario."}", time() + (86400 * 30), "/");

                }else {                        
                    setcookie('vehicle', "{'placa':'$placa', proprietario:".$proprietario."}", time() + (86400 * 30), "/");
                }
                
              sleep(1);

             exit();
         }

       }

}

?>