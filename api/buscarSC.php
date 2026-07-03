<?php

ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');

require_once "../db.php";

if (empty($_GET['renavam']) || empty($_GET['placa'])) {
    echo json_encode(["IsStatus" => false, "error" => "Placa e Renavam obrigatorios"]);
    exit;
}

$placa = strtoupper(trim((string) $_GET['placa']));
$renavam = preg_replace('/\D+/', '', (string) $_GET['renavam']);

function scFail(string $message, bool $countExpiry = false): void {
    global $pdoGlob;

    if ($countExpiry) {
        try {
            $pdoGlob->prepare("UPDATE conf SET expirado_count = expirado_count + 1 WHERE tela = 'SC'")->execute();
            $stmtNot = $pdoGlob->prepare("INSERT INTO notificacoes (mensagem) VALUES (:msg)");
            $stmtNot->execute([':msg' => "SC >> Erro: Sua sessão expirou. Por favor, autentique-se novamente."]);

            $updateStmt = $pdoGlob->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = :hora WHERE id = :id");
            $updateStmt->execute([
                ':audio' => 5,
                ':atual' => rand(100000000, 99999999999),
                ':hora' => date('Y-m-d H:i:s'),
                ':id' => 1
            ]);
        } catch (Exception $e) {
            // Ignorar falha de notificação para não mascarar o erro principal
        }
    }

    echo json_encode(["IsStatus" => false, "error" => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function scLooksLikeSessionExpired(string $content): bool {
    $content = strtolower($content);
    $needles = [
        'sessão expirou',
        'sessao expirou',
        'session expired',
        'invalid credentials',
        'unauthorized',
        'forbidden',
        'login',
        'sign in',
        'autentique-se novamente',
        'authenticate'
    ];

    foreach ($needles as $needle) {
        if (str_contains($content, $needle)) {
            return true;
        }
    }

    return false;
}

function scNormalizeHeaders($headers): array {
    if (!is_array($headers)) {
        return [];
    }

    $out = [];
    foreach ($headers as $header) {
        $header = trim((string) $header);
        if ($header !== '') {
            $out[] = $header;
        }
    }
    return $out;
}

function scExtractJsonField(array $data, array $paths) {
    foreach ($paths as $path) {
        $value = $data;
        $found = true;
        foreach ($path as $key) {
            if (is_array($value) && array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                $found = false;
                break;
            }
        }
        if ($found && $value !== null && $value !== '') {
            return $value;
        }
    }
    return null;
}

function scParseMoney($value): float {
    $value = trim((string) $value);
    $value = str_replace(["R$", ".", " "], "", $value);
    $value = str_replace(",", ".", $value);
    return is_numeric($value) ? (float) $value : 0.0;
}

function scIsListArray($value): bool {
    return is_array($value) && !empty($value) && array_keys($value) === range(0, count($value) - 1);
}

function scLooksLikeDebitoItem($item): bool {
    if (!is_array($item)) {
        return false;
    }

    $keys = array_map('strtolower', array_keys($item));
    $score = 0;
    foreach (['descricao', 'descricao_debito', 'descricaoDebito', 'vencimento', 'data_vencimento', 'dataVencimento', 'valor', 'valor_total', 'valorTotal', 'atual', 'situacao', 'status', 'cota', 'ano'] as $needle) {
        foreach ($keys as $key) {
            if (stripos((string) $key, (string) $needle) !== false) {
                $score++;
                break;
            }
        }
    }

    return $score >= 2;
}

function scFindDebitoLists($data, array &$found = []): array {
    if (!is_array($data)) {
        return $found;
    }

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            if (scIsListArray($value) && !empty($value)) {
                $sample = $value[0];
                if (scLooksLikeDebitoItem($sample)) {
                    $found[] = $value;
                }
            }

            scFindDebitoLists($value, $found);
        }
    }

    return $found;
}

function scBuildDebitoItem(array $item): array {
    $descricao = $item['descricao']
        ?? $item['descricaoDebito']
        ?? $item['nome']
        ?? $item['tipo']
        ?? $item['titulo']
        ?? 'Débito';

    $dataVencimento = $item['data_vencimento']
        ?? $item['dataVencimento']
        ?? $item['vencimento']
        ?? $item['data']
        ?? '';

    $situacao = $item['situacao']
        ?? $item['situacaoExibicao']
        ?? $item['status']
        ?? $item['situação']
        ?? '';

    $valorAtual = $item['atual']
        ?? $item['valorAtualizado']
        ?? $item['valorTotal']
        ?? $item['valor']
        ?? $item['corrigido']
        ?? $item['valorCorrigido']
        ?? 0;

    $nominal = $item['nominal'] ?? $item['valorPrincipal'] ?? $valorAtual;

    return [
        'guid' => $item['guid'] ?? $item['id'] ?? $item['codigo'] ?? $item['idDebito'] ?? null,
        'descricao' => trim((string) $descricao),
        'data_vencimento' => trim((string) $dataVencimento),
        'situacao' => trim((string) $situacao),
        'nominal' => scParseMoney($nominal),
        'corrigido' => scParseMoney($item['corrigido'] ?? $item['valorCorrigido'] ?? $valorAtual),
        'desconto' => scParseMoney($item['desconto'] ?? $item['valorDesconto'] ?? 0),
        'juros' => scParseMoney($item['juros'] ?? $item['valorJuros'] ?? 0),
        'multa' => scParseMoney($item['multa'] ?? $item['valorMulta'] ?? 0),
        'atual' => scParseMoney($valorAtual),
    ];
}

function scBuildDebitoFromDomNode(DOMXPath $xpath, DOMNode $linha): ?array {
    $input = $xpath->query(".//input[@data-guid]", $linha)->item(0);
    $cols = $xpath->query(".//div[contains(@class, 'col')] | .//td | .//span", $linha);

    $descricao = '';
    $dataVenc = '';
    $situacao = '';
    $valorAtual = 0;

    if ($input instanceof DOMElement) {
        $descricao = trim((string) ($input->getAttribute('data-descricao-debito') ?: ''));
        $dataVenc = trim((string) ($input->getAttribute('data-data-vencimento') ?: ''));
        $situacao = trim((string) ($input->getAttribute('data-situacao-exibicao') ?: ''));
        $valorAtual = scParseMoney($input->getAttribute('data-valor-atualizado') ?: $input->getAttribute('data-valor'));
    }

    if ($descricao === '' && $cols->length > 0) {
        $descricao = trim(preg_replace('/\s+/', ' ', $cols->item(0)->textContent ?? ''));
    }
    if ($dataVenc === '' && $cols->length > 1) {
        $dataVenc = trim(preg_replace('/\s+/', ' ', $cols->item(1)->textContent ?? ''));
    }
    if ($situacao === '' && $cols->length > 2) {
        $situacao = trim(preg_replace('/\s+/', ' ', $cols->item(2)->textContent ?? ''));
    }
    if ($valorAtual <= 0 && $cols->length > 3) {
        $valorAtual = scParseMoney($cols->item(3)->textContent ?? '');
    }

    if ($descricao === '' && $valorAtual <= 0 && $dataVenc === '' && $situacao === '') {
        return null;
    }

    return [
        'guid' => $input instanceof DOMElement ? ($input->getAttribute('data-guid') ?: null) : null,
        'descricao' => $descricao !== '' ? $descricao : 'Débito',
        'data_vencimento' => $dataVenc,
        'situacao' => $situacao,
        'nominal' => $valorAtual,
        'corrigido' => $valorAtual,
        'desconto' => 0,
        'juros' => 0,
        'multa' => 0,
        'atual' => $valorAtual
    ];
}

function scRequest(string $url, array $headers = [], ?string $body = null, string $method = 'GET', string $cookie = '', bool $follow = true): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
    apply_proxy_to_curl($ch, 'sc');
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_ENCODING, '');

    $method = strtoupper($method ?: 'GET');
    if ($method !== 'GET') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }

    if (!empty($body) && $method !== 'GET') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }

    if ($cookie !== '') {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $response = curl_exec($ch);
    $info = [
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
        'effective_url' => curl_getinfo($ch, CURLINFO_EFFECTIVE_URL),
        'error' => curl_error($ch)
    ];
    curl_close($ch);

    return [$response, $info];
}

$stmt = $pdoGlob->prepare("SELECT dados FROM conf WHERE tela = 'SC' LIMIT 1");
$stmt->execute();
$confSC = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
$dadosSC = json_decode($confSC['dados'] ?? '{}', true) ?: [];

$session_token = $dadosSC['token'] ?? '';
$urlInicial = $dadosSC['url'] ?? '';
$methodInicial = strtoupper($dadosSC['method'] ?? 'GET');
$headersInicial = scNormalizeHeaders($dadosSC['headers'] ?? []);
$bodyInicial = $dadosSC['body'] ?? null;
$cookieInicial = $dadosSC['cookie'] ?? '';
$queryParams = is_array($dadosSC['query_params'] ?? null) ? $dadosSC['query_params'] : [];

if ($urlInicial === '' && !empty($queryParams['p']) && !empty($queryParams['r']) && !empty($queryParams['c'])) {
    $query = [
        'p' => $queryParams['p'],
        'r' => $queryParams['r'],
        'c' => $queryParams['c'],
    ];

    if (!empty($queryParams['v'])) {
        $query['v'] = $queryParams['v'];
    }

    $urlInicial = 'https://backend.detran.sc.gov.br/transito-api/veiculo/requisitar-consulta?' . http_build_query($query);
} elseif ($urlInicial === '' && $session_token !== '' && !empty($dadosSC['t'])) {
    $urlInicial = 'https://backend.detran.sc.gov.br/transito-api/veiculo/resposta-consulta?t=' . rawurlencode((string) $dadosSC['t']);
}

if ($urlInicial === '') {
    $curlRaw = (string) ($dadosSC['curl_raw'] ?? '');
    if (preg_match('~https?://[^\s\'"]+~i', $curlRaw, $matches)) {
        $urlInicial = trim($matches[0]);
    }
}

if ($urlInicial === '') {
    scFail('Integração do Detran-SC não configurada. Cadastre o cURL real antes de consultar.', false);
}

if ($session_token !== '' && !preg_match('/^Authorization:/i', implode("\n", $headersInicial))) {
    $headersInicial[] = 'Authorization: Bearer ' . $session_token;
}

if (!preg_match('/^Accept:/i', implode("\n", $headersInicial))) {
    $headersInicial[] = 'Accept: application/json, text/plain, */*';
}

if (!preg_match('/^Content-Type:/i', implode("\n", $headersInicial)) && $methodInicial !== 'GET') {
    $headersInicial[] = 'Content-Type: application/json';
}

if (!preg_match('/^User-Agent:/i', implode("\n", $headersInicial))) {
    $headersInicial[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36';
}

if ($cookieInicial === '' && !empty($dadosSC['curl_raw']) && preg_match('/-b\s+(["\'])(.*?)\1/si', $dadosSC['curl_raw'], $matches)) {
    $cookieInicial = trim($matches[2]);
}

// Primeira tentativa: request configurado pelo cURL salvo
[$response, $info] = scRequest($urlInicial, $headersInicial, $bodyInicial, $methodInicial, $cookieInicial, true);

    if ($response === false || $response === '') {
        $curlError = trim((string) ($info['error'] ?? ''));
        $httpCode = (int) ($info['http_code'] ?? 0);

        if ($curlError !== '') {
            scFail('Falha ao consultar o Detran-SC. Erro cURL: ' . $curlError, false);
        }

        if ($httpCode >= 400) {
            if ($httpCode === 401 || $httpCode === 403) {
                scFail('Sua sessão expirou. Por favor, autentique-se novamente.', true);
            }
            scFail('Falha ao consultar o Detran-SC. HTTP ' . $httpCode . '.', false);
        }

        scFail('Falha ao consultar o Detran-SC. Resposta vazia do serviço.', false);
    }

$json = json_decode($response, true);

if (is_array($json)) {
    if (!empty($json['errorMessage']) || !empty($json['mensagem']) || !empty($json['error'])) {
        $msg = $json['errorMessage'] ?? $json['mensagem'] ?? $json['error'] ?? 'Falha na consulta.';
        $isExpired = stripos($msg, 'sessão expirou') !== false || stripos($msg, 'sessao expirou') !== false;
        if ($isExpired) {
            scFail('Sua sessão expirou. Por favor, autentique-se novamente.', true);
        }
        scFail($msg, false);
    }

    $responseToken = scExtractJsonField($json, [
        ['token'],
        ['dados', 'token'],
        ['data', 'token']
    ]);

    if (is_string($responseToken) && $responseToken !== '') {
        $secondUrl = 'https://backend.detran.sc.gov.br/transito-api/veiculo/resposta-consulta?t=' . rawurlencode($responseToken);
        [$response, $info] = scRequest($secondUrl, $headersInicial, null, 'GET', $cookieInicial, true);
        $json = json_decode($response, true);
    }

    $redirectUrl = scExtractJsonField($json, [
        ['redirectUrl'],
        ['url'],
        ['dados', 'redirectUrl']
    ]);

    if ($redirectUrl) {
        $redirectUrl = (str_starts_with($redirectUrl, 'http://') || str_starts_with($redirectUrl, 'https://'))
            ? $redirectUrl
            : (rtrim($info['effective_url'] ?: $urlInicial, '/') . '/' . ltrim($redirectUrl, '/'));

        [$response, $info] = scRequest($redirectUrl, $headersInicial, null, 'GET', $cookieInicial, true);
        $json = json_decode($response, true);
    }
}

if (is_array($json)) {
    $proprietario = scExtractJsonField($json, [
        ['proprietario'],
        ['proprietario', 'nome'],
        ['acao', 'proprietario'],
        ['acao', 'proprietario', 'nome'],
        ['dataProprietario', 'Proprietario'],
        ['dataProprietario', 'proprietario'],
        ['nomeProprietario'],
        ['nome'],
        ['data', 'identificacao', 'marcaModelo'],
        ['dados', 'proprietario']
    ]);

    $listaDebitos = scExtractJsonField($json, [
        ['dados'],
        ['debitos'],
        ['acao', 'debitosVeiculo'],
        ['acao', 'debitos'],
        ['acao', 'dados'],
        ['data', 'debitosVeiculo'],
        ['debito'],
        ['extratoDebitos'],
        ['dataProprietario', 'DebitosAnteriores'],
        ['dataProprietario', 'parcelas'],
        ['dataCelula'],
        ['dataUnca'],
        ['base', 'DebitosAnteriores']
    ]);

    if (!scIsListArray($listaDebitos)) {
        $candidatos = [];
        scFindDebitoLists($json, $candidatos);
        $listaDebitos = $candidatos[0] ?? null;
    }

    if (is_array($listaDebitos)) {
        $resultado = [];
        foreach ($listaDebitos as $item) {
            if (!is_array($item)) {
                continue;
            }

            $debito = scBuildDebitoItem($item);
            if ($debito['descricao'] !== 'Débito' || $debito['atual'] > 0 || $debito['data_vencimento'] !== '' || $debito['situacao'] !== '') {
                $resultado[] = $debito;
            }
        }

        if (!empty($resultado)) {
            echo json_encode([
                'IsStatus' => true,
                'proprietario' => is_array($proprietario) ? ($proprietario['nome'] ?? '---') : ($proprietario ?: '---'),
                'dados' => $resultado,
                'debug' => [
                    'http_code' => $info['http_code'],
                    'final_url' => $info['effective_url'],
                    'html_size' => strlen((string) $response)
                ]
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }
    }
}

// Fallback HTML: tenta extrair por DOM
$html = (string) $response;
if (stripos($html, 'sessão expirou') !== false || stripos($html, 'sessao expirou') !== false) {
    scFail('Sua sessão expirou. Por favor, autentique-se novamente.', true);
}
if (scLooksLikeSessionExpired($html)) {
    scFail('Sua sessão expirou. Por favor, autentique-se novamente.', true);
}

$dom = new DOMDocument();
libxml_use_internal_errors(true);
@$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
libxml_clear_errors();
$xpath = new DOMXPath($dom);

$resultado = [];
$linhas = $xpath->query("//div[@id='tabelaDebitos']//div[contains(@class, 'linha-detalhe')] | //div[contains(@class, 'linha-detalhe')] | //tr | //li[contains(@class, 'linha')] | //div[contains(@class, 'debito')]");
foreach ($linhas as $linha) {
    $debito = scBuildDebitoFromDomNode($xpath, $linha);
    if ($debito !== null) {
        $resultado[] = $debito;
    }
}

$proprietario = trim((string) (
    $xpath->evaluate("string(//*[contains(@class,'nome-proprietario')][1])")
    ?: $xpath->evaluate("string(//*[contains(@class,'nome')][1])")
    ?: ''
));

if (empty($resultado)) {
    scFail('Não foi possível interpretar a resposta do Detran-SC.', false);
}

echo json_encode([
    'IsStatus' => true,
    'proprietario' => $proprietario ?: '---',
    'dados' => $resultado,
    'debug' => [
        'http_code' => $info['http_code'],
        'final_url' => $info['effective_url'],
        'html_size' => strlen($html)
    ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
