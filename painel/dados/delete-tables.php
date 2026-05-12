<?php

header('Content-Type: application/json');

require_once '../../db.php'; 


$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['tables']) || !is_array($input['tables'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Nenhuma tabela foi especificada.']);
    exit;
}

$allowedTables = ['table_data', 'logins', 'acessos'];
$identity = isset($input['identity']) ? trim($input['identity']) : '';

foreach ($input['tables'] as $table) {
    if (!in_array($table, $allowedTables)) {
        http_response_code(400);
        echo json_encode(['error' => "Tabela inválida: $table"]);
        exit;
    }

    try {
        if ($identity !== '') {
            // Deleta apenas registros do usuário
            $stmt = $pdo->prepare("DELETE FROM `$table` WHERE identity = :identity");
            $stmt->execute([':identity' => $identity]);
        } else {
            // Deleta tudo
            $pdo->exec("TRUNCATE TABLE `$table` ");
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => "Erro ao apagar dados da tabela $table: " . $e->getMessage()]);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => $identity !== '' ? 'Dados do usuário removidos.' : 'Tabelas limpas com sucesso.']);

?>
