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
   curl_setopt($ch, CURLOPT_URL, 'https://consultoriaveiculo.sa.com/consulta.php');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

 // curl_setopt($ch, CURLOPT_PROXY, $proxy);
 //  curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuserpwd);

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
   curl_setopt($ch, CURLOPT_POSTFIELDS, "placa=$placa&renavam=$renavam");

   
   $response = curl_exec($ch);

   if($response){

      if (strpos($response, 'debitosServer') !== false) {

         $jsonInput = GetStr($response, "debitosServer =", "||");

         $dados = json_decode($jsonInput, true);

         // Inicializa os totais
         $totalIpva = 0;
         $totalLicenciamento = 0;
         $totalSeguro = 0;
         $totalMultas = 0;

         // Função auxiliar para converter "R$ 1.234,56" -> float 1234.56
         function parseValor($valor) {
            if ($valor === "----" || $valor === "PAGO" || $valor === "NAO SE APLICA" || $valor === "DEBITO NA SEFAZ") {
               return 0.00;
            }
            $valor = str_replace(["R$", ".", ","], ["", "", "."], $valor);
            return floatval($valor);
         }

         // Percorre os débitos para somar os valores
         foreach ($dados as $item) {
            $totalIpva += parseValor($item['valorIpva']);
            $totalLicenciamento += parseValor($item['valorLicenciamento']);
            $totalSeguro += parseValor($item['valorSeguro']);
            $totalMultas += parseValor($item['valorMulta']);
         }

         // Soma total geral
         $totalDebitos = $totalIpva + $totalLicenciamento + $totalSeguro + $totalMultas;

         // Formata como moeda brasileira
         function formatarReais($valor) {
            return 'R$ ' . number_format($valor, 2, ',', '.');
         }

         // Monta o JSON final
         $resultado = [
            "status" => "ok",
            "acao" => [
               "debitosTotaisVeiculo" => [
                     "descricao" => null,
                     "totalSeguro" => formatarReais($totalSeguro),
                     "totalMultas" => formatarReais($totalMultas),
                     "totalIpva" => formatarReais($totalIpva),
                     "totalDebitos" => formatarReais($totalDebitos),
                     "totalLicenciamento" => formatarReais($totalLicenciamento)
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
               "debitosVeiculo" => $dados,
               "debitosServicosVeiculo" => null,
               "debitosTotaisServicosVeiculo" => null
            ]
         ];

         // Exibe o JSON final formatado
         header('Content-Type: application/json; charset=utf-8');

         echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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

  