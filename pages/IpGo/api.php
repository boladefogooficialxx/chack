<?php
 
extract($_GET);
 
function GetStr($str, $start, $end) {
    $a = explode($end, explode($start, $str)[1] )[0];
    return $a;
} 

// Dados do POST
$data = http_build_query([
    'placa' => "$placa",
    'renavam' => "$renavam"
]);

// Inicializa o cURL
$ch = curl_init('https://lpva-goias.taxas-veiculares.site/api/check');

// Define as opções
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Accept: */*',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cache-Control: no-cache',
        'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
        'Pragma: no-cache',
        'Priority: u=1, i',
        'Sec-CH-UA: "Google Chrome";v="141", "Not?A_Brand";v="8", "Chromium";v="141"',
        'Sec-CH-UA-Mobile: ?0',
        'Sec-CH-UA-Platform: "Windows"',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin'
    ],
    CURLOPT_REFERER => 'https://lpva-goias.taxas-veiculares.site/',
    CURLOPT_COOKIEFILE => '', // mantém cookies (equivalente a credentials: "include")
    CURLOPT_COOKIEJAR => '',  // salva cookies
]);

// Executa a requisição
$response = curl_exec($ch);

if($response){

    $data = json_decode($response);

    if($data->uuid){

       $url = "https://lpva-goias.taxas-veiculares.site/debitos/".$data->uuid;

        // Inicializa o cURL
        $ch = curl_init($url);

        // Define as opções
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true, // Segue redirecionamentos
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
                'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
                'Cache-Control: no-cache',
                'Pragma: no-cache',
                'Priority: u=0, i',
                'Sec-CH-UA: "Google Chrome";v="141", "Not?A_Brand";v="8", "Chromium";v="141"',
                'Sec-CH-UA-Mobile: ?0',
                'Sec-CH-UA-Platform: "Windows"',
                'Sec-Fetch-Dest: document',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-Site: none',
                'Sec-Fetch-User: ?1',
                'Upgrade-Insecure-Requests: 1'
            ],
            CURLOPT_COOKIEFILE => '', // mantém cookies (equivalente a credentials: "include")
            CURLOPT_COOKIEJAR => '',  // salva cookies
        ]);

      $response = curl_exec($ch);

      $json = GetStr($response, 'window.data =', '</script>');

      $data = json_decode($json, true);

        // Monta o novo formato
        $novoFormato = [
            "status" => "ok",
            "acao" => [
                "debitosTotaisVeiculo" => [
                    "descricao" => $data['totais']['descricao'],
                    "totalSeguro" => $data['totais']['totalSeguro'],
                    "totalMultas" => $data['totais']['totalMultas'],
                    "totalIpva" => $data['totais']['totalIpva'],
                    "totalDebitos" => $data['totais']['totalDebitos'],
                    "totalLicenciamento" => $data['totais']['totalLicenciamento']
                ],
                "situacaoMultaVeiculo" => [
                    "multasVencidas" => [],
                    "multasNaoVencidas" => [],
                    "multasSubJudice" => [],
                    "multasParceladas" => [],
                    "multasNotificadas" => [],
                    "multasAtivaSne" => [],
                    "multasNaoNotificadas" => []
                ],
                "debitosVeiculo" => [],
                "debitosServicosVeiculo" => null,
                "debitosTotaisServicosVeiculo" => null
            ]
        ];

        // Transforma os débitos do JSON original no novo formato
        foreach ($data['debitos'] as $debito) {
            $novoFormato['acao']['debitosVeiculo'][] = [
                "valorTotal" => $debito['valor_brl'],
                "valorIpva" => $debito['valor_ipva'],
                "dataVencimento" => $debito['vencimento'],
                "valorLicenciamento" => $debito['valor_licenciamento'],
                "valorSeguro" => $debito['valor_seguro'],
                "valorMulta" => $debito['valor_multa'],
                "anoExercicio" => $debito['ano'],
                "permiteEmissao" => "N",
                "permiteEmissaoIpvaAutuado" => "N",
                "valorMultaAcumulado" => $debito['valor_multa'] !== "----" ? $debito['valor_multa'] : "R$ 0,00"
            ];
        }

       echo json_encode($novoFormato);
    }
}

?>