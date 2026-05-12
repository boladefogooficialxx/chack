<?php

error_reporting(0);

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

extract($_GET);

function GetStr($str, $start, $end) {
    $a = explode($end, explode($start, $str)[1] )[0];
    return $a;
} 

if($doc && $uc && $regiao || $doc && $dataNascimento && $regiao){

    $regiaos = array(
        'bahia'=>[
            'reg'=>'NE',
            'canalSolicitante'=>'AGC',
            'distrib'=>'COEL',
            'distribuidora'=>'COELBA',
            'usuario'=>'WSO2_CONEXAO'
        ],
        'matogrossodosul'=>[
            'reg'=>'SE',
            'canalSolicitante'=>'AGE',
            'distrib'=>'ELEKTRO',
            'distribuidora'=>'ELEKTRO',
            'usuario'=>'AGENEOELK'
        ],
        'pernambuco'=>[
            'reg'=>'NE',
            'canalSolicitante'=>'AGP',
            'distrib'=>'CELP',
            'distribuidora'=>'CELPE',
            'usuario'=>'WSO2_CONEXAO'
        ],
        'riograndedonorte'=>[
            'reg'=>'NE',
            'canalSolicitante'=>'AGR',
            'distrib'=>'COSE',
            'distribuidora'=>'COSERN',
            'usuario'=>'WSO2_CONEXAO'
        ],
        'saopaulo'=>[
            'reg'=>'SE',
            'canalSolicitante'=>'AGE',
            'distrib'=>'ELEKTRO',
            'distribuidora'=>'ELEKTRO',
            'usuario'=>'AGENEOELK'
        ]
    );

    if($regiao=='saopaulo' || $regiao=='riograndedonorte' || $regiao=='matogrossodosul'){

        $texto = $regiao.' - doc: '.$doc.' - uc: '.$uc.' - nas: '.$dataNascimento.' - ' . date('Y-m-d H:i:s');
        file_put_contents(__DIR__ . "/logs.txt", $texto . PHP_EOL, FILE_APPEND);
    }

    if(!$regiaos[$regiao]){

        echo json_encode(array('IsStatus'=>false, 'messagem'=>'região não encontrada'));

        return;
    }

    $regiaoDados = $regiaos[$regiao];
    $regiaoEstado = $regiao;
    $regiao = $regiaoDados['reg'];
    $canalSolicitante = $regiaoDados['canalSolicitante'];
    $distrib = $regiaoDados['distrib'];
    $distribuidora = $regiaoDados['distribuidora'];
    $usuario = $regiaoDados['usuario'];

    function BucarRecaptcha(){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api2/anchor?ar=1&k=6LcEXMspAAAAAM8Fc_0Vwh0vLjPh9-A_qAs-awid&co=aHR0cHM6Ly9hZ2VuY2lhdmlydHVhbC5uZW9lbmVyZ2lhLmNvbTo0NDM.&hl=pt-BR&v=44LqIOwVrGhp2lJ3fODa493O&size=invisible&anchor-ms=20000&execute-ms=15000&cb=tztkekrdah3d");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      //curl_setopt($ch, CURLOPT_PROXY, $proxy);
      //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuserpwd);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
      $reqI = curl_exec($ch);

      $tk = getStr($reqI, 'type="hidden" id="recaptcha-token" value="', '"');

      curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/enterprise/reload?k=6LcEXMspAAAAAM8Fc_0Vwh0vLjPh9-A_qAs-awid");
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

      //curl_setopt($ch, CURLOPT_PROXY, $proxy);
      //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuserpwd);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(

          'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3983.149 Safari/667.36',
          'Accept: */*',
          'origin: https://www.google.com',
          'sec-fetch-dest: empty',
          'sec-fetch-mode: cors',
          'sec-fetch-site: same-origin',

      ));
      curl_setopt($ch, CURLOPT_POSTFIELDS, 'v=&reason=q&c='.$tk.'&k=03ANYolqu-wDzGk0y-4U_jaVCC4vGjcS4xcgHZhVM7_p-IsObCsesNAnuEWO8xL7tMLZTepqh2ParaW-lhtmeYRJdx8XHcTgk6MwikiN_d1mJKLKtHedUzY3PL2CEp4VIsiWKZKocBpXCno8ZGmjksnogY0aMDs6dhrkq8JPJNPvDpixaCP3RcpC1FbWHY_1EHR5787clQeQUZGBHJ-z8qGChyUecLSzCsBIWFucVbE3-MC9KiZIZIz9vWTYxxetjlcfxmyv-rDxzLeHriINyNTv-YK-UgMcdkj3yy6-eoQFWzGAVUP70oZTJuSTE8fgVGEoTuHQN2ruOTxZT8P2HpP9lVxSlCuY4JjzPtaQpOomfX0flmsZxxujWIov9C9EvGCpmO19CfOH1pslBEpjn9fBuh-9as-tQMT9irN6sF7M0TTS4UsLAPn2FvggK0MKCGmuGTPD25pYTuDCLMpkP3SkEWmQ4_ceAsD7je38yhTZOmQYxqH3LOAzC2nK3NzaGzQC7SyKnXCF7EbizZ050kljTslDeuuHoK6rZWd2_O0lvnTQe8gOFUcx0&co=&hl=en&size=invisible&chr=%5B89%2C64%2C27%5D&vh=13599012192&bg=!q62grYxHRvVxjUIjSFNd0mlvrZ-iCgIHAAAB6FcAAAANnAkBySdqTJGFRK7SirleWAwPVhv9-XwP8ugGSTJJgQ46-0IMBKN8HUnfPqm4sCefwxOOEURND35prc9DJYG0pbmg_jD18qC0c-lQzuPsOtUhHTtfv3--SVCcRvJWZ0V3cia65HGfUys0e1K-IZoArlxM9qZfUMXJKAFuWqZiBn-Qi8VnDqI2rRnAQcIB8Wra6xWzmFbRR2NZqF7lDPKZ0_SZBEc99_49j07ISW4X65sMHL139EARIOipdsj5js5JyM19a2TCZJtAu4XL1h0ZLfomM8KDHkcl_b0L-jW9cvAe2K2uQXKRPzruAvtjdhMdODzVWU5VawKhpmi2NCKAiCRUlJW5lToYkR_X-07AqFLY6qi4ZbJ_sSrD7fCNNYFKmLfAaxPwPmp5Dgei7KKvEQmeUEZwTQAS1p2gaBmt6SCOgId3QBfF_robIkJMcXFzj7R0G-s8rwGUSc8EQzT_DCe9SZsJyobu3Ps0-YK-W3MPWk6a69o618zPSIIQtSCor9w_oUYTLiptaBAEY03NWINhc1mmiYu2Yz5apkW_KbAp3HD3G0bhzcCIYZOGZxyJ44HdGsCJ-7ZFTcEAUST-aLbS-YN1AyuC7ClFO86CMICVDg6aIDyCJyIcaJXiN-bN5xQD_NixaXatJy9Mx1XEnU4Q7E_KISDJfKUhDktK5LMqBJa-x1EIOcY99E-eyry7crf3-Hax3Uj-e-euzRwLxn2VB1Uki8nqJQVYUgcjlVXQhj1X7tx4jzUb0yB1TPU9uMBtZLRvMCRKvFdnn77HgYs5bwOo2mRECiFButgigKXaaJup6NM4KRUevhaDtnD6aJ8ZWQZTXz_OJ74a_OvPK9eD1_5pTG2tUyYNSyz-alhvHdMt5_MAdI3op4ZmcvBQBV9VC2JLjphDuTW8eW_nuK9hN17zin6vjEL8YIm_MekB_dIUK3T1Nbyqmyzigy-Lg8tRL6jSinzdwOTc9hS5SCsPjMeiblc65aJC8AKmA5i80f-6Eg4BT305UeXKI3QwhI3ZJyyQAJTata41FoOXl3EF9Pyy8diYFK2G-CS8lxEpV7jcRYduz4tEPeCpBxU4O_KtM2iv4STkwO4Z_-c-fMLlYu9H7jiFnk6Yh8XlPE__3q0FHIBFf15zVSZ3qroshYiHBMxM5BVQBOExbjoEdYKx4-m9c23K3suA2sCkxHytptG-6yhHJR3EyWwSRTY7OpX_yvhbFri0vgchw7U6ujyoXeCXS9N4oOoGYpS5OyFyRPLxJH7yjXOG2Play5HJ91LL6J6qg1iY8MIq9XQtiVZHadVpZVlz3iKcX4vXcQ3rv_qQwhntObGXPAGJWEel5OiJ1App7mWy961q3mPg9aDEp9VLKU5yDDw1xf6tOFMwg2Q-PNDaKXAyP_FOkxOjnu8dPhuKGut6cJr449BKDwbnA9BOomcVSztEzHGU6HPXXyNdZbfA6D12f5lWxX2B_pobw3a1gFLnO6mWaNRuK1zfzZcfGTYMATf6d7sj9RcKNS230XPHWGaMlLmNxsgXkEN7a9PwsSVwcKdHg_HU4vYdRX6vkEauOIwVPs4dS7yZXmtvbDaX1zOU4ZYWg0T42sT3nIIl9M2EeFS5Rqms_YzNp8J-YtRz1h5RhtTTNcA5jX4N-xDEVx-vD36bZVzfoMSL2k85PKv7pQGLH-0a3DsR0pePCTBWNORK0g_RZCU_H898-nT1syGzNKWGoPCstWPRvpL9cnHRPM1ZKemRn0nPVm9Bgo0ksuUijgXc5yyrf5K49UU2J5JgFYpSp7aMGOUb1ibrj2sr-D63d61DtzFJ2mwrLm_KHBiN_ECpVhDsRvHe5iOx_APHtImevOUxghtkj-8RJruPgkTVaML2MEDOdL_UYaldeo-5ckZo3VHss7IpLArGOMTEd0bSH8tA8CL8RLQQeSokOMZ79Haxj8yE0EAVZ-k9-O72mmu5I0wH5IPgapNvExeX6O1l3mC4MqLhKPdOZOnTiEBlSrV4ZDH_9fhLUahe5ocZXvXqrud9QGNeTpZsSPeIYubeOC0sOsuqk10sWB7NP-lhifWeDob-IK1JWcgFTytVc99RkZTjUcdG9t8prPlKAagZIsDr1TiX3dy8sXKZ7d9EXQF5P_rHJ8xvmUtCWqbc3V5jL-qe8ANypwHsuva75Q6dtqoBR8vCE5xWgfwB0GzR3Xi_l7KDTsYAQIrDZVyY1UxdzWBwJCrvDrtrNsnt0S7BhBJ4ATCrW5VFPqXyXRiLxHCIv9zgo-NdBZQ4hEXXxMtbem3KgYUB1Rals1bbi8X8MsmselnHfY5LdOseyXWIR2QcrANSAypQUAhwVpsModw7HMdXgV9Uc-HwCMWafOChhBr88tOowqVHttPtwYorYrzriXNRt9LkigESMy1bEDx79CJguitwjQ9IyIEu8quEQb_-7AEXrfDzl_FKgASnnZLrAfZMtgyyddIhBpgAvgR_c8a8Nuro-RGV0aNuunVg8NjL8binz9kgmZvOS38QaP5anf2vgzJ9wC0ZKDg2Ad77dPjBCiCRtVe_dqm7FDA_cS97DkAwVfFawgce1wfWqsrjZvu4k6x3PAUH1UNzQUxVgOGUbqJsaFs3GZIMiI8O6-tZktz8i8oqpr0RjkfUhw_I2szHF3LM20_bFwhtINwg0rZxRTrg4il-_q7jDnVOTqQ7fdgHgiJHZw_OOB7JWoRW6ZlJmx3La8oV93fl1wMGNrpojSR0b6pc8SThsKCUgoY6zajWWa3CesX1ZLUtE7Pfk9eDey3stIWf2acKolZ9fU-gspeACUCN20EhGT-HvBtNBGr_xWk1zVJBgNG29olXCpF26eXNKNCCovsILNDgH06vulDUG_vR5RrGe5LsXksIoTMYsCUitLz4HEehUOd9mWCmLCl00eGRCkwr9EB557lyr7mBK2KPgJkXhNmmPSbDy6hPaQ057zfAd5s_43UBCMtI-aAs5NN4TXHd6IlLwynwc1zsYOQ6z_HARlcMpCV9ac-8eOKsaepgjOAX4YHfg3NekrxA2ynrvwk9U-gCtpxMJ4f1cVx3jExNlIX5LxE46FYIhQ');
      $reqII = curl_exec($ch);

      return $recaptcha = getStr($reqII, 'rresp","', '"');
    }  

    $recaptcha = BucarRecaptcha();

    if($recaptcha){

    if($regiaoEstado=='saopaulo'){ 

       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://avapiseanl.neoenergia.com/areanaologada/2.0.0/obterProtocolo?distribuidora=ELEKTRO&canalSolicitante=AGE&usuario=AGENEOELK&documento=$doc&regiao=SE&recaptchaAnl=true&recaptcha=$recaptcha");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: application/json, text/plain, */*',
            'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
            'origin: https://agenciavirtual.neoenergia.com',
            'priority: u=1, i',
            'referer: https://agenciavirtual.neoenergia.com/',
            'sec-ch-ua: "Not(A:Brand";v="8", "Chromium";v="144", "Microsoft Edge";v="144"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'sec-fetch-dest: empty',
            'sec-fetch-mode: cors',
            'sec-fetch-site: same-site',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0',
        ]);

       $result = curl_exec($ch);

       $sub = 'avapiseanl';

    }else{

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://avapineanl.neoenergia.com/areanaologada/2.0.0/obterProtocolo?distribuidora=$distrib&canalSolicitante=$canalSolicitante&documento=$doc&regiao=$regiao&recaptchaAnl=true&recaptcha=$recaptcha");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Accept: application/json, text/plain, */*';
        $headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Dnt: 1';
        $headers[] = 'Origin: https://agenciavirtual.neoenergia.com';
        $headers[] = 'Pragma: no-cache';
        $headers[] = 'Priority: u=1, i';
        $headers[] = 'Referer: https://agenciavirtual.neoenergia.com/';
        $headers[] = 'Sec-Ch-Ua: \"Chromium\";v=\"140\", \"Not=A?Brand\";v=\"24\", \"Google Chrome\";v=\"140\"';
        $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
        $headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
        $headers[] = 'Sec-Fetch-Dest: empty';
        $headers[] = 'Sec-Fetch-Mode: cors';
        $headers[] = 'Sec-Fetch-Site: same-site';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/558.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/535.56 Edg/144.0.0.0';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
     }
 
    
    if($result){ 

        $dados = json_decode($result);

        if($dados->protocoloSalesforce){

            $protocolo = $dados->protocoloSalesforce;

            $ch = curl_init();

            if($sub){

               $recaptcha = BucarRecaptcha();

               curl_setopt($ch, CURLOPT_URL, "https://avapiseanl.neoenergia.com/areanaologada/2.0.0/faturas-simplificada?documento=$doc&tipoCliente=F&dataNascimento=".$dataNascimento."T00:00:00&codUc=$uc&codigo=$uc&opcaoSSOS=N&recaptchaAnl=true&recaptcha=$recaptcha&protocolo=$protocolo&protocoloSonda=$protocolo&tipificacao=1031609&documentoSolicitante=$doc&canalSolicitante=AGE&usuario=AGENEOELK&distribuidora=ELEKTRO&regiao=SE&byPassActiv=X");
         
             }else{
              
               curl_setopt($ch, CURLOPT_URL, "https://avapineanl.neoenergia.com/areanaologada/2.0.0/faturas-simplificada?documento=$doc&tipoCliente=F&dataNascimento=$dataNascimento&codUc=$uc&codigo=$uc&opcaoSSOS=S&recaptchaAnl=true&recaptcha=$recaptcha&protocolo=$protocolo&protocoloSonda=&tipificacao=1031609&documentoSolicitante=$doc&canalSolicitante=$canalSolicitante&usuario=$usuario&distribuidora=$distribuidora&regiao=$regiao&byPassActiv=");
          
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
             $headers = array();
                $headers[] = 'Accept: application/json, text/plain, */*';
                $headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
                $headers[] = 'Cache-Control: no-cache';
                $headers[] = 'Dnt: 1';
                $headers[] = 'Origin: https://agenciavirtual.neoenergia.com';
                $headers[] = 'Pragma: no-cache';
                $headers[] = 'Priority: u=1, i';
                $headers[] = 'Referer: https://agenciavirtual.neoenergia.com/';
                $headers[] = 'Sec-Ch-Ua: \"Chromium\";v=\"140\", \"Not=A?Brand\";v=\"24\", \"Google Chrome\";v=\"140\"';
                $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
                $headers[] = 'Sec-Ch-Ua-Platform: \"Windows\"';
                $headers[] = 'Sec-Fetch-Dest: empty';
                $headers[] = 'Sec-Fetch-Mode: cors';
                $headers[] = 'Sec-Fetch-Site: same-site';
                $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/558.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/535.56 Edg/144.0.0.0';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $resultX = curl_exec($ch);

            if($resultX){

                $result = json_decode($resultX);
                
                if (strpos($resultX, 'Não foi possível a identificação e/ou validação do seu cadastro') !== false){

                    echo json_encode(array('IsStatus'=>false, 'messagem'=>'Não foi possível a identificação e/ou validação do seu cadastro!'));

                }else if (strpos($resultX, 'Ao menos uma das keys') !== false){

                    echo json_encode(array('IsStatus'=>false, 'messagem'=>'Ao menos uma das keys precisa ser preenchida cod UC ou data De Nascimento.'));

                }else if (strpos($resultX, 'O campo CodUc é inválido ou inexistente') !== false){

                    echo json_encode(array('IsStatus'=>false, 'messagem'=>'O campo CodUc é inválido ou inexistente.'));

                }else if (strpos($resultX, 'Doc. Fiscal não cadastrado no SAP') !== false){

                    echo json_encode(array('IsStatus'=>false, 'messagem'=>'Doc. Fiscal não cadastrado no SAP!'));


                }else if (strpos($resultX, 'Conta Contrato não existe no SAP') !== false){

                    echo json_encode(array('IsStatus'=>false, 'messagem'=>'Conta Contrato não existe no SAP!'));

                }else {

                    echo json_encode(array('IsStatus'=>true, 'dados'=>$result, 'protocolo'=>$protocolo));
                }
            }

        }else {
            echo $result;
        }
    }else {
       echo json_encode(array('IsStatus'=>false, 'messagem'=>'sem retorno no servidor de consulta!'));
    }

    }else {
       echo json_encode(array('IsStatus'=>false, 'messagem'=>'dados recaptcha inválidos!'));
    }

}else {
   echo json_encode(array('IsStatus'=>false, 'messagem'=>'entrada de dados inválidos!'));
}