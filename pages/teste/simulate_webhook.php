<?php
require_once "../../db.php";

header('Content-Type: application/json');

$ref = $_GET['ref'] ?? null;

if ($ref === null || $ref === '') {
    echo json_encode(['status' => 'error', 'message' => 'Referência não informada']);
    exit;
}

try {
    // LOG DE DEBUG para o desenvolvedor ver o que está chegando
    // file_put_contents('debug.log', "Ref: $ref\n", FILE_APPEND);

    // Se for um número pequeno, é um ID do banco. Buscamos APENAS pelo ID para ser cirúrgico.
    if (is_numeric($ref) && strlen($ref) < 10) {
        $updateStmt = $pdo->prepare("UPDATE table_data SET status = 'pago' WHERE id = ? AND status = 'pendente'");
        $updateStmt->execute([$ref]);
    } else {
        // Se for o código PIX completo ou uma ref de gateway, buscamos por elas
        $updateStmt = $pdo->prepare("UPDATE table_data SET status = 'pago' WHERE (ref = ? OR cod = ?) AND status = 'pendente'");
        $updateStmt->execute([$ref, $ref]);
    }
    $count = $updateStmt->rowCount();
    
    if ($count > 0) {
        // ... (restante do código igual)
        // Dispara alerta sonoro de sucesso (ID 4)
        $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio, atual = :atual, hora = NOW() WHERE id = :id");
        $updateStmt->execute([
            ':audio' => 4,
            ':atual' => rand(100000000, 99999999999),
            ':id' => 1
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Pagamento simulado com sucesso!', 'affected' => $count, 'ref_used' => $ref]);
    } else {
        // Se não afetou nada, vamos tentar ver se a transação já estava paga ou se não existe
        $check = $pdo->prepare("SELECT status FROM table_data WHERE id = ? OR ref = ? OR cod = ? LIMIT 1");
        if (is_numeric($ref) && strlen($ref) < 10) {
            $check->execute([$ref, '---', '---']);
        } else {
            $check->execute([0, $ref, $ref]);
        }
        $actualStatus = $check->fetchColumn();
        
        if ($actualStatus === 'pago') {
            echo json_encode(['status' => 'warning', 'message' => 'Esta transação já consta como PAGA no banco.', 'affected' => 0, 'ref_used' => $ref]);
        } else if ($actualStatus === 'pendente') {
            echo json_encode(['status' => 'error', 'message' => 'Erro interno: Transação encontrada como PENDENTE mas o UPDATE falhou.', 'affected' => 0, 'ref_used' => $ref]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Transação não encontrada no banco com esta referência.', 'affected' => 0, 'ref_used' => $ref]);
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
