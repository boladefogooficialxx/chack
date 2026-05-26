<?php

error_reporting(0);

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");

$json = file_get_contents("php://input");
$data = json_decode($json, true);

if(isset($data['bearer'])){
    $data['bearer'] = preg_replace('/\s+/', '', $data['bearer']);
}

$tela = $data['tela'];

if($tela){

    require_once "../db.php";
    require_once "../base/utility.php";

    function idSessao($cpfCidadao, $Bearer) {
    
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

        $Session = base64_encode('{"sistema":"SSEDI","codgTipoChave":"03","idServico":13679,"idSessao":"","ip":"146.70.214.5","idHistServicoSistema":30825}');

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

    $bearer = $data['bearer'];
    $doc = $data['doc'];
    
    if ($tela !== 'teste') {
        $idSessao = json_decode(idSessao(
          $doc,
          $bearer
        ));
        $data['idSessao'] = $idSessao->id;
    } else {
        $data['idSessao'] = 'mock_session_id_teste';
    }

    $jsonLimpo = json_encode($data);

    $updateStmt = $pdoGlob->prepare("UPDATE conf SET dados = :dados WHERE tela = :tela");
    $updateStmt->execute([':dados' => $jsonLimpo, ':tela' => $tela]);

   echo  json_encode(array("IsStatus" => true, "message" => "token salvo com sucesso!", "data" => $jsonLimpo));

}

?>