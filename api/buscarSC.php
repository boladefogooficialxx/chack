<?php

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

require_once "../db.php";

// 1. Busca dados no banco para SC
$stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'SC' LIMIT 1");
$stmt->execute();
$confSC = $stmt->fetch();
$dadosSC = json_decode($confSC['dados'], true);

// Fallback para tokens mockados ou em branco
$session_token = $dadosSC['token'] ?? '';

if (empty($_GET['renavam']) || empty($_GET['placa'])) {
    echo json_encode(["IsStatus" => false, "error" => "Placa e Renavam obrigatorios"]);
    exit;
}

$placa = $_GET['placa'];
$renavam = $_GET['renavam'];

/**
 * NOTA: Esta é uma estrutura baseada no ES. 
 * Em um cenário real de produção, a URL e os parâmetros de POST/GET 
 * do Detran-SC seriam diferentes.
 */

// Lógica de Detecção de Expiração
if (empty($session_token)) {
    try {
        $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'SC'")->execute();
        $stmtNot = $pdoGlob->prepare("INSERT INTO notificacoes (mensagem) VALUES (:msg)");
        $stmtNot->execute([':msg' => "SC >> Erro: Sua sessão expirou. Por favor, autentique-se novamente."]);
    } catch (Exception $e) {}

    echo json_encode(["IsStatus" => false, "error" => "Sua sessão expirou. Por favor, autentique-se novamente."]);
    exit;
}

// Simulando resposta do SC (Mock)
// Em um sistema real, aqui iria o CURL para os endpoints do Detran-SC
$mock_data = [
    "IsStatus" => true,
    "proprietario" => "JOAO SILVA COSTA",
    "dados" => [
        [
            "descricao" => "IPVA 2026 - COTA ÚNICA",
            "data_vencimento" => "10/03/2026",
            "situacao" => "PENDENTE",
            "atual" => 450.50
        ],
        [
            "descricao" => "LICENCIAMENTO ANUAL 2026",
            "data_vencimento" => "10/03/2026",
            "situacao" => "PENDENTE",
            "atual" => 165.20
        ],
        [
            "descricao" => "MULTA POR EXCESSO DE VELOCIDADE",
            "data_vencimento" => "15/01/2026",
            "situacao" => "VENCIDO",
            "atual" => 195.23
        ]
    ]
];

echo json_encode($mock_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
