<?php

session_start();

error_reporting(0);

require '../db.php'; // arquivo de conexão PDO

// Pega token da sessão ou do cookie
$token = $_SESSION['token'] ?? null;

if ($token) {

    $sql = "SELECT * FROM users WHERE token = :token LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch();

    if (!$user) {
             echo json_encode(["status" => "error", "message" => "Usuário não tem acesso!"]);
        exit();
    }

    $role = $user['role'];

    $userId = ($role=='master') ? null : $_SESSION['user_id'];

  } else {
        echo json_encode(["status" => "error", "message" => "Usuário não tem acesso!"]);
    exit();
}

function getPaginatedData($pdo, $table, $page = 1, $limit = 10, $userId = null) {
    $offset = ($page - 1) * $limit;

    // Monta filtro condicional
    $where = "";
    $params = [];
    if ($userId !== null) {
        $where = "WHERE id_usuario = :userId";
        $params[':userId'] = (int)$userId;
    }

    // Total de registros
    $countSql = "SELECT COUNT(*) as total FROM `$table` $where";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($params);
    $total = (int)$countStmt->fetch()['total'];

    // Buscar dados paginados
    $sql = "SELECT * FROM `$table` $where ORDER BY id DESC LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    if ($userId !== null) {
        $stmt->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se for a tabela logins, decodificar login_info
    if ($table === 'logins') {
        foreach ($data as &$item) {
            $decoded = json_decode($item['login_info'] ?? '[]', true);
            $item['login_info'] = $decoded ?: [];
        }
    }
    

    return [
        'page' => (int)$page,
        'limit' => (int)$limit,
        'total' => (int)$total,
        'total_pages' => ceil($total / $limit),
        'data' => $data
    ];
}

function buildDashboard($pdo, $userId = null) {
    $params = [];
    $whereUser = "";

    if ($userId !== null) {
        $whereUser = "WHERE id_usuario = :id_usuario";
        $params[':id_usuario'] = $userId;
    }

    // Total pago (somando só os pagos)
    if ($userId !== null) {
        $sql = "SELECT COALESCE(SUM(valor_pago),0) FROM table_data WHERE id_usuario = :id_usuario AND status = 'pago'";
    } else {
        $sql = "SELECT COALESCE(SUM(valor_pago),0) FROM table_data WHERE status = 'pago'";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $totalPaid = number_format($stmt->fetchColumn(), 2, '.', '');

    // Faturas impressas (total de registros)
    $sql = "SELECT COUNT(*) FROM table_data " . ($whereUser ? $whereUser : "");
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $invoicesPrinted = (int)$stmt->fetchColumn();

    // Total de logins
    $sql = "SELECT COUNT(*) FROM logins " . ($whereUser ? $whereUser : "");
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $totalLogins = (int)$stmt->fetchColumn();

    // Total de acessos
    $sql = "SELECT COUNT(*) FROM acessos " . ($whereUser ? $whereUser : "");
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $totalAcessos = (int)$stmt->fetchColumn();

    return [
        'id' => $userId ?? 0,
        'total_paid' => $totalPaid,
        'invoices_printed' => $invoicesPrinted,
        'total_logins' => $totalLogins,
        'total_acessos' => $totalAcessos
    ];
}


function notificacoes($pdo, $userId = null) {

    $stmt = $pdo->query("SELECT id, mensagem, criado_em FROM notificacoes ORDER BY criado_em DESC");
    $notificacoes = $stmt->fetchAll();
 
    return $notificacoes;
}


function Configuracoes($pdo, $userId = null) {

    $userId =  $_SESSION['user_id'] ?? null;

    $countStmt = $pdo->prepare("SELECT * FROM configuracoes WHERE id_usuario = :userId");
    $countStmt->execute([':userId' => $userId]);
    $dados = $countStmt->fetch();

    if (!$dados) {
        return [
            'id_usuario' => $userId ?? null,
            'secretKey' => null,
            'publicKey' => null,
            'webRouterUrl' => null,
            'apiEndpoint' => null,
            'plataforma' => null,
            'chavepixnome' => null,
            'chavepixCidade' => null,
            'chavepix' => null,
            'webhookUrl' => null
        ];
    }
 
    return [
        'id_usuario' => $userId ?? null,
        'secretKey' => $dados['secret_key'] ?? null,
        'publicKey' => $dados['public_key'] ?? null,
        'webRouterUrl' => $dados['web_router_url'] ?? null,
        'apiEndpoint' => $dados['api_endpoint'] ?? null,
        'plataforma' => $dados['Plataforma'] ?? null,
        'chavepixnome' => $dados['nome'] ?? null,
        'chavepixCidade' => $dados['cidade'] ?? null,
        'chavepix' => $dados['chave'] ?? null,
        'webhookUrl' => $dados['webhook_url'] ?? null
    ];
}

function getConfData($pdo) {
    try {
        $stmt = $pdo->query("SELECT tela, dados, expirado_count, atualizado_em FROM conf");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($row) {
            $dados = json_decode($row['dados'] ?? '{}', true);
            if (!is_array($dados)) {
                $dados = [];
            }

            $hasToken = !empty($dados['token']);
            $hasCookie = !empty($dados['cookie']) || !empty($dados['cookies']) || !empty($dados['session']);
            $hasUrl = !empty($dados['url']);
            $expiracoes = (int) ($row['expirado_count'] ?? 0);

            if (($row['tela'] ?? '') === 'proxy') {
                $hasActive = !empty($dados['active_ms']) || !empty($dados['active_es']) || !empty($dados['active_sc']) || !empty($dados['active_pgmei']);
                $statusLabel = $hasActive ? 'Ativo' : 'Inativo';
                $statusClass = $hasActive ? 'success' : 'danger';
            } elseif ($expiracoes > 0) {
                $statusLabel = 'Sessão Expirada';
                $statusClass = 'warning';
            } elseif ($hasToken || $hasCookie || $hasUrl) {
                $statusLabel = 'Ativa';
                $statusClass = 'success';
            } else {
                $statusLabel = 'Sem Sessão';
                $statusClass = 'danger';
            }


            return [
                'tela' => $row['tela'] ?? '--',
                'expirado_count' => $expiracoes,
                'atualizado_em' => $row['atualizado_em'] ?? null,
                'status_label' => $statusLabel,
                'status_class' => $statusClass,
                'has_token' => $hasToken,
                'has_cookie' => $hasCookie,
                'has_url' => $hasUrl,
            ];
        }, $rows);
    } catch (Exception $e) {
        return [];
    }
}

function getPainelData($pdo, $params = []) { 
    $userId = $params['userId'] ?? null;

    $pageAcessos = $params['pageAcessos'] ?? 1;
    $limitAcessos = $params['limitAcessos'] ?? 10;

    $pageLogins = $params['pageLogins'] ?? 1;
    $limitLogins = $params['limitLogins'] ?? 10;

    $pageTable = $params['pageTable'] ?? 1;
    $limitTable = $params['limitTable'] ?? 10;

    // Dashboard stats só do usuário

    $dashboard = buildDashboard($pdo, $userId);

    $configuracoes = Configuracoes($pdo, $userId);
    $notificacoes = notificacoes($pdo, $userId);
    $confData = getConfData($pdo);

   if (!$dashboard) {
        $dashboard = [
            'id' => 0,
            'total_paid' => "0.00",
            'invoices_printed' => 0,
            'total_logins' => 0,
            'total_acessos' => 0
        ];
    }

    return [
        'dashboard' => $dashboard,
        'configuracoes' => $configuracoes,
        'acessos' => getPaginatedData($pdo, 'acessos', $pageAcessos, $limitAcessos, $userId),
        'logins' => getPaginatedData($pdo, 'logins', $pageLogins, $limitLogins, $userId),
        'tableData' => getPaginatedData($pdo, 'table_data', $pageTable, $limitTable, $userId),
        'notificacoes' => $notificacoes,
        'confData' => $confData
    ];
}


// Para uso direto: imprime JSON
if (isset($_GET['action']) && $_GET['action'] === 'getPainel') {
    $params = [
        'pageAcessos' => $_GET['pageAcessos'] ?? 1,
        'userId' => $userId ?? null,
        'limitAcessos' => $_GET['limitAcessos'] ?? 10,
        'pageLogins' => $_GET['pageLogins'] ?? 1,
        'limitLogins' => $_GET['limitLogins'] ?? 10,
        'pageTable' => $_GET['pageTable'] ?? 1,
        'limitTable' => $_GET['limitTable'] ?? 10,
    ];

    header('Content-Type: application/json');
    echo json_encode(getPainelData($pdo, $params), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
?>
