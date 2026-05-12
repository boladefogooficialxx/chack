<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Configurações globais
$session = '58cd35facea4233baa4acf04f4733fb3=2ab3dbf1b6912df633d42fef6673db8d; .AspNetCore.Cookies=chunks-2; .AspNetCore.CookiesC1=CfDJ8LgQVrtYBPRJstTPx-IC2Gp5XyKNO2FG_zeM0o73NpdlLWKkyfD-tI8K-dKRvZ8ZHmmFVXgIqTM6NYqNqzq2hHir7-WOeYR-ntbRuvrVt2RjudJMAeArLEpPGSLd-wVfdKEcG4kKVrw2cyFPNB4ehMZUZoZIlhNFzRGsEXr1AhOQdWojriUQQKKDBxQ_K0dtpOBq089kxbJXQM9L5lX6Uzk97Dhr8CMBoRmKWM4wVZE03c6qpcT2p6eqFnOrKGaASqWQ0VFGJQe5kJva887VWmywZB_fTd4GodtFUfryn2GGqahJxLgX8qjDzTNnwBVykVmTLZZpee1aSDQzIjOh5-K5CzLJRcCNzT2Nh48lQhMKTmi7wLLS_GbEp1uQCTpeudsR7B72GM_c27OqsgPnnAX6JcgCoF2PZKzIM-FlYDrNYWaFi6Ql-F3f9AgJGd3Mp-ACLHqP7hv3BlMEtpuOzHQPxS5Zw8MUSQSsq-QCls6dcMNBAMyfy_ONC0qfM8pInD-9g3XeTDNp5OKGyzwAtR9yxRnqx8leeAKcVhF5upuxLqDwh9p-kXWzDxAHXzvK9EvUxhNjimfUZeb3J2r77OdoUTpGN4S7x7NLQhzsQG1wM5pkkd3F_2KPZ2xx7jPTwyvPt5mehrl6T51iawnaI8YwmTXQxHWWErkrq28nndV9TMawk6GYrdzNKCaA0i-YXSQcsnlLAtBb2mOhoc2EDSLOG0v2tCmhWB092rive9vo4TnzC-kkqpCnoRo6pHRLrHPTC6udwZXhQRjOExWlfdCVDct8Tw-SC9BtbzUA5NmJ5e_etSdco7oBjJUgs8Kl9mbQCwmuRJ7QXXv3sCjSKftJgakOQSSIP3UtcJYIWLO8hi0du0g0MtNpvSi7nT2xW9hjkkWLYlFfTeGkJehQLdwF3mZHKdxarE_R1ESgfT35nqIWoffS1oLXS64J6HCyRR21_9UhtS-GM2-ugjOBKT16M6S9bVF8rKdm4axs9DLB2ph-Qn0wQheZDj24ESHG5U_4TTz-RcU4memM2IUDFu6Cz3_ZtD9Sz0sE75HhNasK96RD-xJ5i7Wsn9qPE6olVPydu315DmLQrpy9oP8Q2rECAOIRaCKt7fibngKWf7zx_7tbowy2rE4uucsoPnNn1iz6I9wJZOJhkIGxyKuQQF2rIKSIabF1OYMsA1Remtq1gvcnRYqYEXoz94f5BYUTSxuu6FGPJNRBCLjgZ7yRK4_C6LvHJQlvP59UOtFi-4ZKOo2t9JJGaWIBaoQcV1TLXN9buIiI5ERAvUbkrbWPRvlytJJLXkv1Z-TTv11n3K_2wd6XjRJY_6zmPHe_lusMezAn7Z-xQ0xaAtv47vo9yO-57wyRDHPEX_gU5ILuqeeJ1MY4zTSASN3xYWp_-vzqMXKiu60h1rpp_4nXM-4D7hoIMjvTo4QIPQLF1EscTZsQVj2Rg1aX8uUE0M8-TJuHFPChxWq_uEPLkmXk9Ew543YieqqTk69oMhsBbQPBr7aJZlhvJkBD49QGVHyG-V6KsWahz4IqoopxULx2cex3Fhk4hYzJBRGJ0MFbx1ZfDkedTFtYswXBMG2rSvPnVGG5CGlMFY9CuR3wooEX4w2tN1LzSl9bfwbtwSRBpXv7XtXYkiKhXI94HvlffDEAhBzyxKGZcxAFm1xZqYNr9YrGKtrsztrJAeUwX98R4uev6dilB1fREfhWyeJW2n-X9asurmQvE9YlcChJPijwqnDRkj2iBbLbQWk_8lhsU4DLi4M8nQHLg7s79RIqf0_u4LRR90MVz_Bm-HJLwSxveJoS0SKkj5l_-MpwmP06fubKXRvwydLwwiyIn1m68RZ26wjE9Pg-I70SW6xWje3Xn1mWX9_NcqSoIaVpVYO02rOvXajYezR2mJ_AFdCJkW2RoHtgeq8lM01I9Pzqy7LU-fItvgeDDukrlJcWWEwQtbL7TrrYExMMI63w1EXgdUl-P-A46gGmsadK-3QdeK7Q26O82q1UsnD2RMJ3xLJfOjp2XzQ_8QoW4P73iWaDqsUwjGdOz6-8MkofDad3gzx5aLxQnAW3YMXLND9i-TZPq5ddXwOTJXC0decs2s1k8ql3CLBtox9ajEfVHTqWSmU2uOqqnLmOdRo3xO4S5lMIJmk45kVibbZ_DBSXPdwqIm6qj-7Rvpdqpnbirz0TPRlWpkk7SalOoflffH8jpbLcQ4eFOFFLTZoDxBFY-ktr-LvPbCoIKfTlhjjQd2jrFLQrd9TnQunI3OMfpLQtoFXy_s9tuwvidhy3871jPSrx5J3ETrNQ-eBidl1KEPTS_umk3HKSf4VVCosS3dIijlOJCPpNqmsZhaArkRnZhSUdA_alk80x97ndt1iXeMLLY7heZ9MupOGfB2ynfmvZSquI7ojsBPRHZAQEaBsfnhJheSkMJ4Pre7Y5tfOzqS6wPgrWOOrfWK8jlsZ1kPliaLlBf6fx_Xv_z7rM0oPI7acUsiFKwNZszC5KCy_l5lMpBqTyqcWEqAysiFE9zwyg_-CJq8ctSdhIzrZmPXgnQievGF65sGfgpjgGUyk3QcRYwNL930uYKfHVgwGwR1wJ8viF0PDNHXxRFUAnXmtodQ_rXQd_Q5VRuwYjusQ2JklTj36bbjzoDzMg7AkodOd9jFwhz3vI8e-bb9OAe0pPC0Nz351Pee5G5js1rI3CbRZS0ZWZ1vif5KbVJcpS-ySxpyY82kODUjjzG5d6vFpTFeXrFs09vj7q4EIu8BzoZ--l9TiUKVQ3gm-syVK9KUVwldd2nhVc-x9Z4XhAKir5Zu_7cQ_nI7QWqAcwzYi5zUWqeL47DbHMVQMqeaOfy_AKT3aqUFMktX25iCzUTcUEyfPVkmGOApCbumNkFNunfwvXlOMrB180dgjkQcpe7F_gLRsXT3C58kOuotonmt8OAa92M4kqSAUgiwj-MKxtFRVedFoOhcVd_5LUrcyt2Hnh19c4rx1k927lU1j6cCWD1BssSyi4C72Ru2-H9A-mJ_0KQPmbH5r0FR6DpfwGc9_8B47S13JcJ1S_uGdXjInYhbY7cxy9517zQsWTB5K5GMGYjgclwoylEi6GqAW5L9tsoczFYoNpD_N5Gsw1asiKQ-LwtYrwnio5AikHlGHL_vjLssSWaxE6GkiHDTCx2xKgWUVIR2xa0N9AkyDBum6vw0baVFCrViMPyZQMcu6GAAGAekMiJEfSVAMo6q9jkkehtOZeKmbYec5DGBp2a3JUDh5Ox9RyjzIpC203QNO6Sis3cFnyIYpwqo2o5h7d_CaIZna2AnLZSULEqk9rQTcg4weFo_HJ7I-HHjvOyzHxdzHfGaFL81z-T49hr-3-2BXpoab1Z3bIz5Zs5e-ec9uMCrdLfu4OHBNrnn-Ot5-SvY0ZwvtyLFoXq6U6r9I1o5CYDonIkAOsJJlc8v-PDsAqPQaTz1YHsj5C5VrRtNPjce1R9LBeYBLu4GBB37fDXS0nE4nP1YPuePClpZ_B0UfBDU3cwM3ZWJpw8acWK-bzbUVUjbMVhZwHhhT41TkDhFaxvuU0sqjrOwoqsv1zmH24GNSxyod6r10J0Z4l3NeyuZSRPnse5is5vYDiq6AZuZNdSr0u6swpygWkBkXiyOs0g18dp_G5Ox5NXbg-v0sbcGV1KwidvRjzCF81NhQz9ew4Zw64IrXktYt8LebsHA4u6mZTIAlsflHKbDyQ-NTIEIZSD0N0i6gDin0LeWcTnKWw1CkQsgUgIwtDNb1oXJgvxJKD8O-KbnS9Zh-wyKpDj1Ap4KcR6n4BIeSki0KXmoQr4PFJ6Nc5vnhxVm9s1DYbipgK38Usn7t23M5xfmhzplkhPzzn81yfGVFmIRXJILNwc5x81w-SRtcdzJ2jvoXz7BbkeYQZrceBvEq_wZ_wP6dKc_oZZfVLezZfJk_SJNOMBuRV3o7; .AspNetCore.CookiesC2=0UjVa9hfA2p5J6rCWr0B5lXEtUSU98YQBqoIOcshMinMBFQ2B4AiWVKNqTj3XDwKApOm_wKdw1AyZ3Mhq3ivo9pZgb5QWZX4Ch9BYo6OV1wx1GVhpELN2KH9Cp7h8Rm7059QTG_G_iqTUwaw8Mwi2WeYlRWW7SqrCELFWtWwyfIjLLELhaTIezU4JlUUgVtT70-1RVYTYjSc2qPYYNg2XxpkXPBA1DK3TFRJi3DE1meA0AC18Rennj5cs9_8wlClFokDPkyIuKUdQcG4LyJe99Ik3wo9R8VgVtPLuAGeTLBzkWa-8Y6RoKiFKZhh4RlOXh_-lA4KhFWFb2fAoMICpNXFccej1Cy0NzB3A9Rzzj1OojiBANIxBEIEzGxJeVUDchJtLQtphzBQ7_7bHse9e3J1inldu8vElUmOtlUSATU-lAGgVh5D2dUDO_zGD3qNDy-IIdV1L1rucymBc8a6j1fZkFRYlATwA9p86mn1Mv5SWI_UxmtDV7SeFik1NeILaRbzAs58hDbhDxTgDIGSMLsdXOB4Tz4i12n7rscy1Mvm-DKjyuA4IS42cKvgXdglV1ThlsyQ0EAjxCE6raeUhAie-XQ1_FZHNrQNl_HtQrqKEaq6Hob8qBEa0QG9_RT6vkktl-DhzLpY9CEpiXUtkYaaTXZQ3o0XpW3GAxYA00pvioAnMGlRPrq-P3_PVkRUwcdBGSI8jJRFjO-vAIKcSBatOfjt47R7ogLznQt7ZrnHgZTmRNJLeaqef3jXFZCNoIE5aQ6MnL6v19kTR_Zyq90rL3tuvnPTqnPX50hGc53PgLm8vMudiI-s6rnKB3m8T4gjY43CYpSll6TDEAubFQEAVcBaBhslGDXFE83U13CxtMuXUP9h6--F7dxKqf0jqmo14ogyVezWnMo22RF-oEW_d3VhiJXS4xtjdwx84Aald-WolWn29zqp18wCG8cG05vMv0HL1IE6SZ8PIFQ7o7gpesAIT1r08CPH2j8k69bv8EcR1bWjZaO2SijpogLlDDt_Mkix2kIl_-ONpoXzYmqBIecw78e5r6KBMfcpLCfCLbBz3kSXqprYEScGHrvGLuzcAM-YkPjCbFoma3y3LBiC2D0vPdrIhbwIhD2O3zk4We-RPq2tgjlsflyBs9Tc9Z36ww6Se4BgK-2SFep2j8bSJnNuuC-ZD08SYBbGK3GNoAi5kgbGQvSDZ5nzOuNfdCMlwST-rPiro8_qZ2JQ73qVPNL-agckdHosFEvqtT95UfXOsBegX2lOrALoSLkO6_13Nrty8WBMjQoyk-OfGr1S_AsKR8AmwkP2SPyqxE4ouBGL8JaDvT_WDz3dOQL7bM0Rq7J-Djays-GJQOXg35ZpFM9gDL4IXGnBallJBnvhwYtxI-jYn3Jp3-dN9hTXw6oBKpt0iPcb3LQSbLLlzekXyhbDpjEFD1jpip2uTrGJHZyEFkIepiFiid_RQBemlaNP68xHvSqGiouGew4BHTH3bucgoteMKJAqqf-g-P7VR8mbQFrGSmA0IdQ5la-kXUZ4cQt7sAWKiyVDJ2djBXASJViStQaFp5n889daOwgMB2CIATeh3H0zHISb3G2-HmKR-n1CYQJXh690JuLx3BmJ8fyQuya0z9LmYw-2yrhP7J7F-f4XN5yzUSRMH87NqO7FtPkWjEyR7FUGlBycHU8b1eXPfGta9P9AlrYtkThA_EFnu65nBqOHnSSTrHKrcgSpF9I9ZfNcC4FLeWNpj_czVg9qSKW3fG0EimFN7KDhJITP-yfcYGMGuOzHm5wVA3vRq9ZvK__LAaiuXAFdLQZANOX6MGJHLnxo_Qfy8qNozDD2vZ1N8ZXUfLprC4xxCprHOWSSZpKoCYVyQa5ewUH5misz8L5HHV8IL2mzxqqSxECDXQ_twLP3L1GyA1FAuUZ6F8OvRyith09bmxOR1PptU5i4V9VudnxNJYQYW-pFvpN6xIUWVI8V-dDHk1VywrqdDs4hyxSnPBn0sx2g-LCV2OA;';  
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

// Funções utilitárias
function getStr($str, $start, $end) {
    $a = explode($end, explode($start, $str)[1] )[0];
    return $a;
}

function limparValor($valor) {
    $valor = trim($valor);
    $valor = str_replace(["R$", ".", " "], "", $valor);
    $valor = str_replace(",", ".", $valor);
    return is_numeric($valor) ? floatval($valor) : 0;
}

function cloudflare2captcha($key, $googlekey, $pageurl) {
    $ch = curl_init("https://2captcha.com/in.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$key&method=turnstile&sitekey=$googlekey&pageurl=$pageurl");
    $res = curl_exec($ch);
    if (strpos($res, 'OK') !== false) {
        $id = explode('|', $res)[1];
        for ($i = 0; $i < 50; $i++) {
            $ch2 = curl_init("https://2captcha.com/res.php?key=$key&action=get&id=$id");
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $res2 = curl_exec($ch2);
            if (strpos($res2, 'OK') !== false) {
                return explode('|', $res2)[1];
            }
            sleep(3);
        }
    }
    return false;
}

function jsonError($msg, $statusCode = 400) {
    http_response_code($statusCode);
    echo json_encode(["IsStatus" => false, "error" => $msg]);
    exit;
}

// Validação de parâmetros
if (empty($_GET['renavam']) || empty($_GET['placa'])) {
    jsonError("Parâmetros renavam e placa são obrigatórios", 400);
}

$renavam = $_GET['renavam'];
$placa = $_GET['placa'];

// 1. Obter página inicial
$ch = curl_init('https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaLicenciamento');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_COOKIE, $session);
$response = curl_exec($ch);
if (stripos($response, 'Sua sessão expirou') !== false) {
    jsonError('Sua sessão expirou.', 401);
}
$CpfAcessoCidadao = getStr($response, 'hdCpfAcessoCidadao" value="', '"');
if (!$CpfAcessoCidadao) {
    jsonError("Erro ao obter o CpfAcessoCidadao", 500);
}

// 2. Resolver captcha
$token = cloudflare2captcha('4f16550cac01fcf36238f2e4007822e8', '0x4AAAAAAAy6XXSbwPTDYHHM', 'https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaLicenciamento');
if (!$token) {
    jsonError("Erro ao resolver o captcha", 500);
}

// 3. Consultar veículo
$ch = curl_init('https://servicos.detrannet.es.gov.br/CentralVeiculo/ConsultarVeiculo');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_COOKIE, $session);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "Servico" => ["TipoServico" => "EmitirDuaLicenciamento", "CpfAcessoCidadao" => $CpfAcessoCidadao],
    "Placa" => $placa,
    "Renavam" => $renavam,
    "TurnstileToken" => $token
]));
$response = curl_exec($ch);

// 4. Processar resposta
if (stripos($response, '"errorMessage"') !== false) {
    $Dados = json_decode($response, true);
    jsonError($Dados['errorMessage'] ?? 'Erro desconhecido', 400);
}
if (stripos($response, '/Debitos') !== false) {
    $Dados = json_decode($response, true);
    $ch = curl_init('https://servicos.detrannet.es.gov.br' . $Dados['redirectUrl']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_COOKIE, $session);
    $response = curl_exec($ch);
    if ($response === false) {
        jsonError("Erro ao fazer a requisição: " . curl_error($ch), 500);
    }
    $html = $response;
    $dom = new DOMDocument('1.0', 'UTF-8');
    libxml_use_internal_errors(true);
    if (stripos($html, 'charset') === false) {
        $html = '<?xml encoding="UTF-8">' . $html;
    }
    $loaded = $dom->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR);
    libxml_clear_errors();
    if (!$loaded) {
        jsonError("Erro ao carregar o HTML no DOMDocument.", 500);
    }
    $xpath = new DOMXPath($dom);
    $resultado = [];
    $tabela = $xpath->query("//div[@id='tabelaDebitos']")->item(0);
    if ($tabela) {
        $linhas = $xpath->query(".//div[contains(@class, 'linha-detalhe')]", $tabela);
        foreach ($linhas as $linha) {
            $input = $xpath->query(".//input", $linha)->item(0);
            if (!$input) continue;
            $cols = $xpath->query(".//div[contains(@class, 'col')]", $linha);
            $descricao = isset($cols->item(0)->textContent) ? $cols->item(0)->textContent : $input->getAttribute("data-descricao-debito");
            $descricao = preg_replace('/\s+/', ' ', trim($descricao));
            $debito = [
                "guid" => $input->getAttribute("data-guid"),
                "descricao" => $descricao,
                "exercicio" => $input->getAttribute("data-exercicio"),
                "codigo_servico" => $input->getAttribute("data-codigo-servico"),
                "codigo_classe" => $input->getAttribute("data-codigo-classe"),
                "valor_atualizado" => $input->getAttribute("data-valor-atualizado"),
                "data_vencimento" => $input->getAttribute("data-data-vencimento"),
                "situacao" => $input->getAttribute("data-situacao-exibicao"),
                "nominal" => isset($cols->item(2)->textContent) ? limparValor($cols->item(2)->textContent) : 0,
                "corrigido" => isset($cols->item(3)->textContent) ? limparValor($cols->item(3)->textContent) : 0,
                "desconto" => isset($cols->item(4)->textContent) ? limparValor($cols->item(4)->textContent) : 0,
                "juros" => isset($cols->item(5)->textContent) ? limparValor($cols->item(5)->textContent) : 0,
                "multa" => isset($cols->item(6)->textContent) ? limparValor($cols->item(6)->textContent) : 0,
                "atual" => isset($cols->item(7)->textContent) ? limparValor($cols->item(7)->textContent) : 0,
            ];
            $resultado[] = $debito;
        }
    }
    echo json_encode(["IsStatus" => true, "dados" => $resultado], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}
// Caso não seja erro nem débito, retorna resposta bruta
echo $response;