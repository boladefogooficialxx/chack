<?php

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

require_once "../db.php";

// 1. Busca dados no banco
$stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'ES' LIMIT 1");
$stmt->execute();
$confES = $stmt->fetch();
$dadosES = json_decode($confES['dados'], true);

$session_initial = $dadosES['session'] ?? '';
$bearer = $dadosES['bearer'] ?? '';
$referer_base = $dadosES['referer'] ?? 'https://servicos.detrannet.es.gov.br/CentralVeiculo?Servico=EmitirDuaIpva';

if (empty($_GET['renavam']) || empty($_GET['placa'])) {
    echo json_encode(["IsStatus" => false, "error" => "Placa e Renavam obrigatorios"]);
    exit;
}

$placa = $_GET['placa'];
$renavam = $_GET['renavam'];

// Criar um arquivo temporário para os cookies desta sessão
$cookieFile = tempnam(sys_get_temp_dir(), 'cook_es_');

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

function solveCaptcha($key, $sitekey, $pageurl) {
    $ch = curl_init("https://2captcha.com/in.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=$key&method=turnstile&sitekey=$sitekey&pageurl=$pageurl");
    $res = curl_exec($ch);
    if (strpos($res, 'OK') !== false) {
        $id = explode('|', $res)[1];
        for ($i = 0; $i < 40; $i++) {
            $ch2 = curl_init("https://2captcha.com/res.php?key=$key&action=get&id=$id");
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $res2 = curl_exec($ch2);
            if (strpos($res2, 'OK') !== false) return explode('|', $res2)[1];
            sleep(3);
        }
    }
    return false;
}

// Cabeçalhos Base (Identicos ao Navegador Real do seu CURL)
$headers = [
    'Accept: application/json, text/plain, */*',
    'Content-Type: application/json',
    'Origin: https://servicos.detrannet.es.gov.br',
    'Referer: ' . $referer_base,
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36',
    'sec-ch-ua: "Chromium";v="148", "Google Chrome";v="148", "Not/A)Brand";v="99"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "macOS"',
    'sec-fetch-dest: empty',
    'sec-fetch-mode: cors',
    'sec-fetch-site: same-origin',
    'priority: u=1, i'
];

if (!empty($bearer)) $headers[] = "Authorization: Bearer $bearer";

// 1. Pegar CpfAcessoCidadao e Inicializar JAR
$ch = curl_init($referer_base);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Forçamos o envio da string de cookie inicial e a gravação no jar para as próximas etapas
curl_setopt($ch, CURLOPT_COOKIE, $session_initial);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
$res = curl_exec($ch);

if (stripos($res, 'Sua sessão expirou') !== false) {
    unlink($cookieFile);
    echo json_encode(["IsStatus" => false, "error" => "Sua sessão expirou no portal oficial. Pegue um novo CURL."]);
    exit;
}

$CpfAcessoCidadao = getStr($res, 'hdCpfAcessoCidadao" value="', '"');

// 2. Resolver Captcha
$token = solveCaptcha('4f16550cac01fcf36238f2e4007822e8', '0x4AAAAAAAy6XXSbwPTDYHHM', $referer_base);

// 3. POST ConsultarVeiculo
$ch = curl_init('https://servicos.detrannet.es.gov.br/CentralVeiculo/ConsultarVeiculo');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    "Servico" => "EmitirDuaIpva",
    "Placa" => $placa,
    "Renavam" => $renavam,
    "TurnstileToken" => $token,
    "VeiculoOutraUf" => false
]));
$resPost = curl_exec($ch);
$dadosPost = json_decode($resPost, true);

if (!isset($dadosPost['redirectUrl'])) {
    unlink($cookieFile);
    // Se não for JSON, pode ser um erro de Cloudflare ou Sessão Expirada (HTML)
    if (stripos($resPost, '<!DOCTYPE') !== false || stripos($resPost, '<html') !== false) {
        $error_msg = "Sessao expirada ou bloqueio de seguranca (Cloudflare). Atualize os cookies.";
        if (stripos($resPost, 'Turnstile') !== false) $error_msg = "Bloqueio de Captcha detectado.";
        
        echo json_encode([
            "IsStatus" => false, 
            "error" => $error_msg,
            "debug_snippet" => substr(strip_tags($resPost), 0, 100)
        ]);
    } else {
        // Se for JSON mas sem redirect, o governo retornou o erro real (ex: Veiculo nao encontrado)
        $msg = $dadosPost['errorMessage'] ?? $dadosPost['mensagem'] ?? "Veiculo nao encontrado ou erro na SEFAZ.";
        echo json_encode(["IsStatus" => false, "error" => $msg]);
    }
    exit;
}

// 4. GET Debitos (Usando os novos cookies do JAR)
$ch = curl_init('https://servicos.detrannet.es.gov.br' . $dadosPost['redirectUrl']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    'Referer: ' . $referer_base
]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
$html = curl_exec($ch);
unlink($cookieFile);

// 5. Scraping dos dados
$dom = new DOMDocument();
@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
$xpath = new DOMXPath($dom);
$resultado = [];

// Nome Proprietário
$nomeProprietario = "";
$nodesNome = $xpath->query("//div[contains(@class, 'es-nav-end')]//div[contains(@class, 'mx-2')]");
if ($nodesNome->length > 0) $nomeProprietario = trim($nodesNome->item(0)->textContent);

// Débitos
$inputs = $xpath->query("//input[@data-guid]");
foreach ($inputs as $input) {
    $linha = $input->parentNode;
    while ($linha && strpos($linha->getAttribute('class'), 'linha') === false) $linha = $linha->parentNode;
    
    $valorFinal = 0;
    if ($linha) {
        $colunas = $xpath->query(".//div[contains(text(), 'R$')]", $linha);
        if ($colunas->length > 0) $valorFinal = limparValor($colunas->item($colunas->length - 1)->textContent);
    }

    if ($valorFinal > 0) {
        $resultado[] = [
            "descricao" => preg_replace('/\s+/', ' ', trim(explode("Vencimento:", $linha->textContent)[0])),
            "data_vencimento" => $input->getAttribute("data-data-vencimento"),
            "situacao" => $input->getAttribute("data-situacao-exibicao"),
            "atual" => $valorFinal
        ];
    }
}

echo json_encode([
    "IsStatus" => true, 
    "proprietario" => $nomeProprietario,
    "dados" => $resultado
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
