<?php

// No Railway (Produção), não devemos exibir erros na tela para não quebrar o layout/headers
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); // Logar tudo, mas esconder avisos e warnings da tela

function Conexao($dbName = null){
    // Configurações Manuais do Railway (Públicas)
    $host = 'yamabiko.proxy.rlwy.net';
    $port = '54916';
    $user = 'root';
    $pass = 'nnOcHNhdSblhJrEromomQJrDHHoukWfv';
    $db   = 'railway'; // Nome do banco padrão no Railway
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        // Logar erro internamente
        error_log("Erro de conexão no Banco: " . $e->getMessage());
        return null;
    }
}

// Conexão principal
$pdo = Conexao();

if (!$pdo) {
    // Se o banco falhar em produção, melhor mostrar uma mensagem limpa
    die("Desculpe, estamos passando por uma manutenção técnica no banco de dados.");
}

$pdoGlob = $pdo;

function get_proxy_config() {
    global $pdo;
    if (!$pdo) {
        return [
            'host'         => 'brd.superproxy.io',
            'port'         => '33335',
            // -country-br garante sempre IP do Brasil
            'userpwd'      => 'brd-customer-hl_6da07c7b-zone-pgmei_proxy-country-br:j0yxh8rpl1ku',
            'active_ms'    => true,
            'active_es'    => false,
            'active_sc'    => false,
            'active_pgmei' => false
        ];
    }
    
    try {
        $stmt = $pdo->prepare("SELECT dados FROM conf WHERE tela = 'proxy' LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $dados = json_decode($row['dados'], true);
            if (is_array($dados)) {
                return $dados;
            }
        }
    } catch (Exception $e) {
        // Ignora erro se a tabela ou linha não existir ainda
    }
    
    // Fallback padrão: sempre Brasil
    return [
        'host'         => 'brd.superproxy.io',
        'port'         => '33335',
        'userpwd'      => 'brd-customer-hl_6da07c7b-zone-pgmei_proxy-country-br:j0yxh8rpl1ku',
        'active_ms'    => true,
        'active_es'    => false,
        'active_sc'    => false,
        'active_pgmei' => false
    ];
}

function apply_proxy_to_curl($ch, $screen = 'ms') {
    $proxyConf = get_proxy_config();
    $activeKey = 'active_' . strtolower($screen);
    if ($proxyConf && !empty($proxyConf[$activeKey])) {
        curl_setopt($ch, CURLOPT_PROXY, $proxyConf['host']);
        if (!empty($proxyConf['port'])) {
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxyConf['port']);
        }
        if (!empty($proxyConf['userpwd'])) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyConf['userpwd']);
        }
        // Ignorar erros de SSL por conta da decriptografia forçada (Immediate Access da Bright Data)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        return true;
    }
    return false;
}


//error_reporting(0);
//
//function Conexao($db)
//{
//
//    $host = 'db';
//    $user = 'bit';
//    $pass = 'Flipmoney123#';
//    $charset = 'utf8mb4';
//
//    $options = [
//        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//        PDO::ATTR_EMULATE_PREPARES => false,
//    ];
//
//    try {
//        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
//        return $pdo;
//    } catch (PDOException $e) {
//        http_response_code(500);
//        echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
//        exit;
//    }
//}
//
//$pdo = Conexao('chak');
//
//$pdoGlob = Conexao('glob');




