<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

extract($_GET);

header('Content-Type: application/json');

    $session = '58cd35facea4233baa4acf04f4733fb3=2ab3dbf1b6912df633d42fef6673db8d; .AspNetCore.Cookies=chunks-2; .AspNetCore.CookiesC1=CfDJ8LgQVrtYBPRJstTPx-IC2GoRVoBD0b6sFr2a2rNaE_9nl3kW7XLYcgJjd7wYrrjXIokh9Nkegp84aZZJUqim-1KmhPT0CIigtikJvrG4bzsFI-Chd3ODu-qeXL-DMYY9SNloDTCd0aW5Km0oy7IcJUQ37Ufh_R_QpruR3ATMSqEb3Ggj1clqqXeyQ1NNvWyvFltvEe1BHyIdu5u512SPSRJgUtuiYv0wn_x1Cl2pI10HWq-_c0CrXpS8Zgm5KcOhMesA4JM3-cKQDomiK2Mw3kZVR14ehI2FDQd5oEApBBbuq_072H7PghFtIRSL3kNZW-fSyNHO50n88iefcc0cUFl-yxKeoqQdE8VlwkwZTZirGATcprlrZU0OpQPm_gz-6FHhfeWrGYKsRarx76fTZK6lXvA9BSfwtMX__VzDYQSW5-KJoZv1pB5pCIXGz_Lm_lRV61_nk8TP2SnHtiuQF6HGNbxoDG4IJOvuABKZnNrTtVMiQ17AYdmN5rCLmrPwgVDIOhfY5JUrMsYdZ_-yXUgnWvVd8kSCeo1TFlVNF7NcZWjJkuYMbBtWrZnOKZPYkvNygxnP47Dp3Yd2F6iJwlA1amKhQ1H5uVgao-NQ5IfRIaS50q-54UmC8SBzEYqMZEknzOXlKFTjVyTKH2onTnpX8P9dWFSTObiywyv5JnTlldKIhL3s-xqryQNHCVeCgCBuoffTXiCcF6ETbm5wUcHGWqaSQQMkZMEuqGFUhidWOcUsddhyBYPr4-WUytojfNfo5EpEuxvQ1gGPT4uls3L5bqVTFjs9jlZ0oF3WJ8GYbdDhtM3t-CY_4lWae2n71A38vAfmgp8pm03JUfDNIzhtZX9sO0KJrr6_aKgDAq9bBFaYnz5KD-0K9QOJB4y6ekwzbsYQC_nDD4hAsOyadWsE3g8n-fpeoIazdjXEl0KxgNtxrSDqvea8hjyzlwmiwrR1e_p27aPIPeQLxVEy3laElnYVcmHqYP70s4Cwj2KPDDomTdmPquUlj8NmzdPCbpdkJ1riqJpRtQbX2GVGyFehNgWZgy4mtT5upND93iRhS_TOhG5EqizWOmbLiXD1_y-AX1Uaa6Gbjcqo7L1JI_uaaMQWKzrl4WTroWc3IXxTptDS54z-apOFbiAkVMpSev1EFNAgS68DJenSY1nHGuDjh41VCHzuKd3L5eOW6Gf7W9JfmEty7QEXWunvY0VTExt4ntJjuCNLm6v3t7nnsTPqabgB_WomMjnciLhUMJ1Tqg-bNaYww1bm7B-yIdDUhdpTPMXs28krEXBlVGgpmi6p8eBXXODFdLRLVHUdz6CmYfL_Y96g7c1DOAjTGYbtSHQhuW-qstdCEc1bejTn0--vOydrsVw8KCNvlvk-PrxAjZy9xfVffOeRCRr_akiSSJOSIrQ27Djja5gVV10DTxND_zLeZUMAUELw8AqkrCTW2a5hROupJ1xaQ_wIWmTA8TAWjz_y8mI1f-IGi7tIzzk1dVHCHxfJaRImbsbJDzbjyqapELt0P6Sh9TkkFoSTpQMnHjWvC0pc4FKE_Twp8QeXmAlP0H_mazyYkohLM3cfkifxfkV9R31q1LrB5e8_9yaDt4wdMXUGrWlYZdNgVrsVGSY-gzLewWafclaQMfd0ZRXDp8bwT8dhd_ivlSIV6NEY8enFzdj4A0q600MSC3rLkAn0VI3Uw15FFLEQvahLqVtxUBwz8Vnd-5ltpRWeqSbaedSnT4QnPMdQHggz_zE0OupuQlXTZ_vPPlRWgjzF4E2qmfKAFiwTzPMWD6onSisnrHk-nAM2JQ1hUZ2mOEL5KuZfUoTA_u5jh6qifCGKCukFv8A8Er84L_aokcTs_LA19FWR3bpBkPc7PHzbXXvRiDGbj8yGY-6YFRhpaQ6x_QJN3VZ8bKzdUp9BZux0jkxsxPaGrHX5upLv_IPDF0uNQRK_MeqRHRRxDVbtK7N2ENdihtqKLPU1b_lSUdC0uLDLeUpg-S1jnjvjZpWcTDkacyoMDRYjiwfiTfIr_d-gkSUxI7iokgr52EYzPEy2SZsvcJOA3Nrfiserl8mQQbUUdXlitbnPTTEEMgFZg0wzo2BhPkOV-ZkAihkrQF7YrdHB61jTZx0oVbwXiOSNbCqYVa4WudWuskEfMOlRsI6XZYFQ7OtUhxare83n3e2VGCjXNjzX1WiETkGpbneLW9cG1_SR73ClM7OBxc4EJNwIG41s5PruZSXDhYJQupLqPm1ROVvxxUcAf-HunO0UKGzFB_93HDKZEZN_QVFciwqysu9uEaapzjK7aq_yZycR0Wij5rn2aMC-9-fa7DfpB-AhUr_jZViciuOTiFCAOz7knt7E_U-WkG66IvZpn5233eaMSB7sTyzYAAuI_VAc_Cb91v5MM0N6X6hDz3lEOlMvvvGOma1SoTsNEDgNZ75cqA_ubRywHjlfZ3ehKNCYYn9BBbDHxmhXrHf11iWHedrbtihay5MCdw_eeF51FYDCiEOYKv8fsW62s2V3HJOPb_Si8Aw1Tyu6Tnn_NaK9zTmtgebB-Vw2kGJ9vuGOppXZoMdu91ZURziZVsUCpaNJx0ZPr19cHKb2zamFWGnUzCXtcttjTP7re23zwn2HmSAmBZ2UJOYE_bCS7OqmLTqVW2_BeOAMw-_-0EaFejh3M33_W-IOg2KCTPAny7mpeuQGaFcHv9yiTrGj67pd0oiU469o1cSwB4851UsThaEthl4v6cAQ8kqDndL-4w5zYJoNXlw9Kxylhd4bOilp_cQGmhwOb6MCGXb6lpG-qMCrBma1SKHXBDXZ3XcRNnVfEWuCJ-EJc88eH9L7UbYnMVnUJL3IZFUHo8_ac4wkF8WXr8Og9JPzHJE_oPtLL61sYMsJHh2UhRRcafxTiEm5vyP00rFKk4iuGGpcuj2tcSb2ssmZwKZ3mjtq2dX5vkjsFe00bn3Gt1FnQuGCO9HJRoX1incJ8_iiepXANQIfSPl8SViEW289sER20qP__SJ4T2Uo5mUYfZiu90hSuQHTDt9dTrgD8RNsSiVqIGZORhwr9zffOCMvUV4eZP-Q2pE38Ccw3bZMG1WAIff_QWOM8FbIF0OosmmZPD5JiztBrOXzT4kTKaxNUUmU2nXqhbeVz7Vaqw0Eqxe7qKqhGOZck03K1dIAzzdZ1Uie1SRl412aGR6KYNGYL8bbrdbbWVvLfFWAlBag3wDjCriBDlWVZS9d3j3DOiz5LclOeUgz_ah-BuekQSFWaeecTZ7-CPF66vdrivHApPs1vfjf2uHEniG9iDqLOzfHiRHr4XwWCDOzYDt1N1zGX7UFqfaX3PQEI38ZH5EpxvjCUT7oLE2KJ5ADfEIeVm-QDdsLNlRZlztEGc-EoAo3Dex_EjJF7dYYLCBNG-DyALNc4jeKUL6nYbhp_kicGvKioqghPoFiOakomiMRJCdtpGKmrujJ0_V7w68aPHAVt-oypCx83Hl7EiP2lUkMyaOH-IEyLl-wZue5R2RaVswenDTcRpitLlv5tWZC7UgXtpfOpnE_4YCuJLHUWpdEDNAmETWGud-t5NuQl-OWPwAPdl7TL0v2wiYL-x4Xw9NJyQv7XSeQ7RUTNqxS4q5lLVg226z5-uFrIdOUzhDc6CdMKQjycz30XBKLwknaF-GILLC2nlHXZHo4iyEtDeBxPiQ-6s5bxPCV8qTdF9SyM5pTmsymUJsnndzmTyeKeeSTjzOM2byBG_73MqQVa8kFR0nWKXm_pee2vFy2YJUoj-NDmFGoHVlBYPCqxVKnqkQKRZM8eileJsaKS-LqqN_ADmQ_6cFydJS7TuFMB7IEmCK27Osfy7BOBrMSZv3eMysql0BkTWrfmIMKIKglme4nZ_nOIkF5Bn3-x8hDHM3IuyYPWw-ADdk9yWdvd7Ds1ugO5dcjeGr-aYhL7o_u7tE68IJJj3mXkGzfByZ; .AspNetCore.CookiesC2=3NyAGcwAP4OBi7PQ_0JiZneET3MlCAZRGGkTgzzwwXaOy47RUI1To_Rz2hYUJl7Dk7uDjM0vGNKXxUw67DybozNtpIeuEOyuVC4hd25EnNuRon4kBkATe9iPLXMNdCJCW5sz-5SlbXyouf-McM9umOOtslre7ECgiuIBTc7ri9I-x5lDYTINXUOdCDWNZtgwi35BA556vFvrW8pyaFkOV9PIyjngov61AtkRC6CE_I2cpSQ2ghT0L82CWkVPQqlTlkgBEvkDvgb8dHCRxQ5dZkoXGIVrr36k0qWE5htpKxgds5G6v-bTcIPJtcZ-fF1pOLKDEM3-g9y6kqET-3jRXU3ZPSAIZo8v8YMFQza5dRdLXY76FCnLMr5ZO98P5bNXeuup0w3r7kxFvomKDvguZ_5U7BRIUk6nP78oMIr0khftxlGbI06CZaOWTNSyJNmZECoM13AuvVkNtBGdolu_X3ndffd0JA6rL82FytI88sS-PXlDQOt9bfG6kLYIZXNDq3ucTe8cz-JriADaqzEjw5-swdB5KyanAnnbodC7JjSy08yNPz20cOWspgMqLym4t2w_myCUaknTmzedGGz9LYIkX0p8CTRu8_eIDoELle8_Oi1OwoNqId32fBOnkInoF_XV4LProzcpCNkjhTJnGFjk_p8w7v5iU5007p-n500Nf5bG7DX0PG4-VZpO0768ipFf1kbH80cAbNddvAN4pWGm4SvCoJoKQvKCVXoIX1R7Bm5KgeSKggIab6TV1qkkc8qc6NR_6R4Ja_XFnOQAjeFTAdkOfWbh3sS0WoGEGlZ24Jl-FtsXtaXUIWtvhStWPXIeK3bLoMmA8Wzpus6puTNywe4thYWFK0CWP9iT0TQ3e0n_5Cub8yPcFra_srETn066UirYQdXL11WQJ2QHUEkS7Eky4w__BhoxfaNnEWwdKobFk5fnp-0_PWJFpLVZ36LFNC2lDtT6ZjK8LPqTuhrW_2tJX7phtZ9AOLdjt0THt7YTc873A-rcrlFGU_grJmi6Kmo6pyf1TRCUyvgm7jMHawiY2hURA79U9FKIyP9e5lC34ZdOK9zVjePtW5Ui7e7xCnkNVi1_dIUE5bt5erJeiI8QSNeYhw2Qox_kqNiYEaM4sxFhEssEm44RzAINqlCWHPeOp9KtEwgZcj61ErnZSuRnyZNyFxKQlgjbri41u3bDrGS5HbDSsaFwnZemKkolgvqPZ5cPUZX4fJPgZPNf502nu_Pm0AOOIk6WJIcA4KQ2hiEBtzMWPkdklaN7e_zdKDAfV03UaV99IbEksF9Smhy2samyFAISCyeA0N1IDf4aL1rL5c8ubyDibyCg3YjRAPsFBWUyKn_EbT0qgGkn77EURd17eHnY4kFYEoRG4e4Dgj1x-KC25zv0ZbZBlV0u4g_zsTDeYlhkzPZcYwnUZik41oe6r3S0l01V-Pz9Ira_3rzdl_mv7E46oMvgTKR6F8SIkkdSsrjCMT7KfriBkWlLvhbwj7XErv0334PxoeOf1jmSO6cSMeEQrEeBdBzLXofz70aj-A4W_h62nTsK6QJWt6bNrshwsBGmBxOrmU9AoZvsPqN7lxwJc8Q9UinGqanvekJ57hJJpPmRbNF5KXuShDOwiPAz__HBkVmlfvtC2d5ForI8mk73muRx_f1jldFUEVP0K9QOoLvsJ-0Qt1DOPFAMaahN9N9rOXbSnmFTQ1ooe5rPNXDdWJ2Rqhx5ZEqqLQrQ86RJtCtNoej6F_pfBh_q7ZIZkWoRM8L5W3IDJebqFvRrqMXVaLO-0EylRLbG-eeCpI1XR0owwmTHt9hS_pAw-S_kmFjBoYdhb9kWDBez3M_rbNroGy8bGZVqaFNfSv05HQBS-pYMujVUtVdKGXb_rY92htoYzrCcFie2a_qN-L06qRkh-E8kQotYuew_exGnhvn21PfGD-vaC8WNFOugCUczg1KcP-BShdUATiDR_NQqlNUoKm3AyHU27zmEC_YSOlxHmri4b0il0Vg;';

    $header = [
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'content-type: application/json',
            'accept-language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
            'sec-ch-ua: "Not(A:Brand";v="8", "Chromium";v="144", "Microsoft Edge";v="144"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: none',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0',
        ];

    function GetStr($str, $start, $end) {
        $a = explode($end, explode($start, $str)[1] )[0];
        return $a;
    } 

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
   
   if (!isset($_GET['renavam']) || !isset($_GET['placa']) || $_GET['renavam'] == '' || $_GET['placa'] == '') {
      http_response_code(400);
      echo json_encode([
         "error" => "Parâmetros renavam e placa são obrigatórios"
      ]);
      exit;
   }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaLicenciamento');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIE,  $session);

     $response = curl_exec($ch); 

     if (stripos($response, 'Sua sessão expirou') !== false) {

      echo json_encode([
            "IsStatus" => false,
                "error" => 'Sua sessão expirou.' 
            ]);

        exit;
    }

   $CpfAcessoCidadao = GetStr($response, 'hdCpfAcessoCidadao" value="', '"');

   if(!$CpfAcessoCidadao){
      echo json_encode([
         "IsStatus" => false,
         "error" => "Erro ao obter o CpfAcessoCidadao"
      ]);
      exit;
   }

   $renavam = $_GET['renavam'];
   $placa = $_GET['placa'];

   $data = Cloudflare_2captcha('4f16550cac01fcf36238f2e4007822e8', '0x4AAAAAAAy6XXSbwPTDYHHM', 'https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaLicenciamento', 3);

   $token = explode('|', $data)[1];

   if(!$token){
      http_response_code(500);
      echo json_encode([
         "IsStatus" => false,
         "error" => "Erro ao resolver o captcha: $token"
      ]);
      exit;
   }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://servicos.detrannet.es.gov.br/CentralVeiculo/ConsultarVeiculo');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIE, $session);
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"Servico":{"TipoServico":"EmitirDuaLicenciamento","CpfAcessoCidadao":"'.$CpfAcessoCidadao.'"},"Placa":"'.$placa.'","Renavam":"'.$renavam.'","TurnstileToken":"'.$token.'"}');

    $response = curl_exec($ch);

   if (stripos($response, '"errorMessage"') !== false) {
       
      $Dados = json_decode($response, true);

            echo json_encode([
                "error" => $Dados['errorMessage'] 
            ]);

     } else if (stripos($response, '/Debitos') !== false) {

        $Dados = json_decode($response, true);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://servicos.detrannet.es.gov.br'.$Dados['redirectUrl']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_COOKIE, $session);

        $response = curl_exec($ch);

        if ($response === false) {
            echo json_encode([
                "IsStatus" => false,
                "error" => "Erro ao fazer a requisição: " . curl_error($ch) 
            ]);
        } else {


            $html = $response;
            $dom = new DOMDocument('1.0', 'UTF-8');
            libxml_use_internal_errors(true);
            if (stripos($html, 'charset') === false) {
                $html = '<?xml encoding="UTF-8">' . $html;
            }
            $loaded = $dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
            libxml_clear_errors();
            if (!$loaded) {
                echo json_encode([
                    "IsStatus" => false,
                    "error" => "Erro ao carregar o HTML no DOMDocument."
                ]);
                exit;
            }

            $xpath = new DOMXPath($dom);
            $resultado = [];
            // Função para converter "R$ 1.001,87" → 1001.87
            function limparValor($valor) {
                $valor = trim($valor);
                $valor = str_replace(["R$", ".", " "], "", $valor);
                $valor = str_replace(",", ".", $valor);
                return is_numeric($valor) ? floatval($valor) : 0;
            }
            // Busca a div da tabela de débitos
            $tabela = $xpath->query("//div[@id='tabelaDebitos']")->item(0);
            if ($tabela) {
                // Busca todas as linhas de débito dentro da tabela
                $linhas = $xpath->query(".//div[contains(@class, 'linha-detalhe')]", $tabela);
                foreach ($linhas as $linha) {
                    $input = $xpath->query(".//input", $linha)->item(0);
                    if (!$input) continue;
                    // Extrai as colunas para pegar a descrição correta
                    $cols = $xpath->query(".//div[contains(@class, 'col')]", $linha);
                    // Normalmente a descrição está na primeira coluna (item 0)
                    $descricao = isset($cols->item(0)->textContent) ? $cols->item(0)->textContent : $input->getAttribute("data-descricao-debito");
                    // Limpa a descrição de espaços, quebras de linha e múltiplos espaços
                    $descricao = preg_replace('/\s+/', ' ', trim($descricao));
                    $debito = [
                        "guid"               => $input->getAttribute("data-guid"),
                        "descricao"          => $descricao,
                        "exercicio"          => $input->getAttribute("data-exercicio"),
                        "codigo_servico"     => $input->getAttribute("data-codigo-servico"),
                        "codigo_classe"      => $input->getAttribute("data-codigo-classe"),
                        "valor_atualizado"   => $input->getAttribute("data-valor-atualizado"),
                        "data_vencimento"    => $input->getAttribute("data-data-vencimento"),
                        "situacao"           => $input->getAttribute("data-situacao-exibicao"),
                    ];
                    // ...continua extraindo os valores normalmente...
                    // Garante que há colunas suficientes antes de acessar
                    $debito["nominal"]   = isset($cols->item(2)->textContent) ? limparValor($cols->item(2)->textContent) : 0;
                    $debito["corrigido"] = isset($cols->item(3)->textContent) ? limparValor($cols->item(3)->textContent) : 0;
                    $debito["desconto"]  = isset($cols->item(4)->textContent) ? limparValor($cols->item(4)->textContent) : 0;
                    $debito["juros"]     = isset($cols->item(5)->textContent) ? limparValor($cols->item(5)->textContent) : 0;
                    $debito["multa"]     = isset($cols->item(6)->textContent) ? limparValor($cols->item(6)->textContent) : 0;
                    $debito["atual"]     = isset($cols->item(7)->textContent) ? limparValor($cols->item(7)->textContent) : 0;
                    $resultado[] = $debito;
                }
            }

            echo json_encode([
                    "IsStatus" => true,
                    "dados" => $resultado
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        
    }else {

        echo $response;
    }