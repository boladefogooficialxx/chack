<?php

error_reporting(0);

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');

date_default_timezone_set('America/Sao_Paulo');

extract($_GET);

extract($_POST);

if($placa && $renavam){

require_once "../db.php";

   function consultarVeiculo($url, $bearer, $session){
    
      if(!$url) return;

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

      $headers = [
         'Accept: */*',
         'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
         'Application-Name: EXPRESSO_CONSULTA_VEICULO',
         'Authorization: Bearer ' . $bearer,
         'Connection: keep-alive',
         'Content-Type: application/json',
         'Dnt: 1',
         'Origin: https://www.go.gov.br',
         'Referer: https://www.go.gov.br/',
         'Sec-Fetch-Dest: empty',
         'Sec-Fetch-Mode: cors',
         'Sec-Fetch-Site: cross-site',
         'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36',
         'Sec-Ch-Ua: "Chromium";v="142", "Google Chrome";v="142", "Not_A Brand";v="99"',
         'Sec-Ch-Ua-Mobile: ?0',
         'Sec-Ch-Ua-Platform: "Windows"',
         'Session: ' . $session
      ];

      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      return curl_exec($ch);
   }

   function converterDadosVeiculo($jsonApi){

      $d = json_decode($jsonApi, true);

      $placa           = $d["placa"] ?? false;
      $renavam         = $d["renavam"] ?? false;
      $chassi          = $d["chassi"] ?? false;
      $fabricante      = $d["nomeMarcaModelo"] ?? false; 
      $modelo          = $d["nomeMarcaModelo"] ?? false;
      $ano_fabricacao  = $d["anoFabricacao"] ?? false;
      $ano_modelo      = $d["anoModelo"] ?? false;
      $municipio       = $d["municipio"] ?? false;
      $cpfCnpj         = $d["cpfCnpj"] ?? false;
      $especie         = $d["especie"] ?? false;
      $tipo            = $d["tipo"] ?? false;
      $passageiros     = $d["capacidadePassageiros"] ?? false;
      $motor           = $d["nrMotor"] ?? false;
      $combustivel     = $d["combustivel"] ?? false;
      $potencia        = $d["potencia"] ?? false;
      $cilindradas     = $d["cilindradas"] ?? false;
      $cor             = $d["cor"] ?? false;

      $data = [
         "proprietario" => [
            "nome" => $fabricante,
            "placa" => $placa,
            "cpfcnpj" => $cpfCnpj,
            "renavam" => $renavam,
            "chassi" => $chassi,
            "municipioRegistro" => $municipio,
            "uf" => false,
            "Segmento" => false,
            "EspecieVeiculo" => $especie,
            "TipoVeiculo" => $tipo,
            "Passageiros" => $passageiros,
            "Motor" => $motor,
            "Combustível" => $combustivel,
            "Potencia" => $potencia,
            "Cilindrada" => $cilindradas,
            "Cor" => $cor,
            "AnoModelo" => $ano_modelo,
            "Importado" => false,
            "Marca" => $fabricante,
            "anodefabricacao" => $ano_fabricacao,
            "marcamodelo" => $modelo,
            "valorSemDesconto" => false
         ]
      ];

      return $data;
   }

   function Notifications($mensagem){
      global $pdo;

      $criado_em = date('Y/m/d H:i:s');

      $stmt = $pdo->prepare("INSERT INTO notificacoes (mensagem, criado_em) VALUES (:mensagem, :criado_em)");
      $stmt->execute([':mensagem' => "$mensagem - $criado_em", ':criado_em' => $criado_em]);

      $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
      $updateStmt->execute([':audio' => 5, ':atual' => rand(100000000, 99999999999), ':hora' => $criado_em, ':id' => 1]);
   }

   $Glob = $pdoGlob->query("SELECT dados FROM conf WHERE tela = 'goApi' LIMIT 1")->fetchColumn();

   $GlobDados = json_decode($Glob, true);

   $Bearer = trim($GlobDados['bearer']);
   $ip = $GlobDados['ip'];
   $doc = $GlobDados['doc'];

   function idSessao($cpfCidadao, $Bearer, $ip) {
    
        $ch = curl_init("https://api.go.gov.br/detran/autenticacao/1.0.0/sedi/realizarLogin");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "cpfCidadao" => $cpfCidadao,
            "atendente" => null,
            "selos" => [
                "niveis" => [
                    ["id" => "2", "dataAtualizacao" => "2024-11-13T15:37:49.512-0300"]
                ]
            ],
            "empresas" => [],
            "nomeServico" => "CONSULTA DE VEICULOS WEB"
        ]));

        $Session = base64_encode('{"sistema":"SSEDI","codgTipoChave":"03","idServico":13679,"idSessao":"","ip":"'.$ip.'","idHistServicoSistema":30825}');

        $headers = [
            "Content-Type: application/json",
            "Accept: */*",
            "Application-Name: EXPRESSO_CONSULTA_VEICULO",
            "Authorization: Bearer $Bearer",
            "session: ".$Session
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return curl_exec($ch);

    } 
    
   $idSessao = json_decode(idSessao($doc,$Bearer,$ip));

   $idSessao = $idSessao->id;

   $Session = base64_encode('{"sistema":"SSEDI","codgChave":"'.$doc.'","codgTipoChave":"04","idServico":13709,"idSessao":'.$idSessao.',"ip":"'.$ip.'","idHistOperador":135664813,"idHistServicoSistema":30885}');

   $result = consultarVeiculo(
      "https://api.go.gov.br/detran/veiculointegracao/1.0.0/sedi/veiculo/consultarVeiculoPorPlacaRenavam?placa=$placa&renavam=$renavam",
      $Bearer,
      $Session
   );

   if (strpos($result, 'chassi"') === false) {

      $Session = base64_encode('{"sistema":"SSEDI","codgChave":"'.$placa.'","codgTipoChave":"04","idServico":13709,"idSessao":'.$idSessao.',"ip":"'.$ip.'","idHistOperador":135664813,"idHistServicoSistema":30885}');

      $result = consultarVeiculo(
         "https://api.go.gov.br/detran/veiculointegracao/1.0.0/sedi/veiculo/consultarVeiculoPorPlacaRenavam?placa=$placa&renavam=$renavam",
         $Bearer,
         $Session
      );
   }

   if (strpos($result, 'chassi"') !== false){

      $DadosVeiculo = converterDadosVeiculo($result);

      $result = consultarVeiculo(
         "https://api.go.gov.br/detran/financeiro/1.0.0/sedi/financeiro/consultarVeiculoPorPlacaRenavam?placa=$placa&renavam=$renavam",
         $Bearer,
         $Session
      );

      $data = json_decode($result, true);

      $novoModelo = [
         "status" => "ok",
         "acao" => [
            "proprietario" => $DadosVeiculo['proprietario'],
            "debitosTotaisVeiculo" => [
                  "descricao" => $data["debitosTotaisVeiculo"]["descricao"] ?? null,
                  "totalSeguro" => $data["debitosTotaisVeiculo"]["totalSeguro"] ?? "R$ 0,00",
                  "totalMultas" => $data["debitosTotaisVeiculo"]["totalMultas"] ?? "R$ 0,00",
                  "totalIpva" => $data["debitosTotaisVeiculo"]["totalIpva"] ?? "R$ 0,00",
                  "totalDebitos" => $data["debitosTotaisVeiculo"]["totalDebitos"] ?? "----",
                  "totalLicenciamento" => $data["debitosTotaisVeiculo"]["totalLicenciamento"] ?? "R$ 0,00"
            ],
            "situacaoMultaVeiculo" => [
                  "multasVencidas" => $data["situacaoMultaVeiculo"]["multasVencidas"] ?? [],
                  "multasNaoVencidas" => $data["situacaoMultaVeiculo"]["multasNaoVencidas"] ?? [],
                  "multasSubJudice" => $data["situacaoMultaVeiculo"]["multasSubJudice"] ?? [],
                  "multasParceladas" => $data["situacaoMultaVeiculo"]["multasParceladas"] ?? [],
                  "multasNotificadas" => $data["situacaoMultaVeiculo"]["multasNotificadas"] ?? [],
                  "multasAtivaSne" => $data["situacaoMultaVeiculo"]["multasAtivaSne"] ?? [],
                  "multasNaoNotificadas" => $data["situacaoMultaVeiculo"]["multasNaoNotificadas"] ?? []
            ],
            "debitosVeiculo" => $data["debitosVeiculo"] ?? [],
            "debitosServicosVeiculo" => $data["debitosServicosVeiculo"] ?? null,
            "debitosTotaisServicosVeiculo" => $data["debitosTotaisServicosVeiculo"] ?? null,
         ]
      ];

      echo json_encode($novoModelo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

   }else {
          
         if (strpos($result, 'Voce foi bloqueado') !== false){

             echo json_encode(array("status" => "error", "msg"=>"Voce foi bloqueado"));

             Notifications('Voce foi bloqueado');

        }else if (strpos($result, 'Invalid Credentials') !== false){
             
             echo json_encode(array("status" => "error", "msg"=>"Invalid CredentialsInvalid Credentials"));

             Notifications('Invalid Credentials');

         }else{

             echo $result;

             //echo json_encode(array("error"=>"veiculo nao encontrado"));

         }
   }

}else{

   echo json_encode(array("error"=>"missing parameters"));
}

?>