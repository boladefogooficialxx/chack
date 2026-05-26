<?php
require_once "../../db.php";

header('Content-Type: application/json');

$response = [
    'db_connection' => false,
    'tables' => [],
    'errors' => []
];

try {
    if ($pdo) {
        $response['db_connection'] = true;
        
        $tables = ['acessos', 'configuracoes', 'dominios', 'logins', 'notificacoes', 'notifications', 'table_data', 'typing_status', 'users', 'conf'];
        
        foreach ($tables as $table) {
            try {
                $stmt = $pdo->query("SELECT COUNT(*) FROM `$table` LIMIT 1");
                $response['tables'][$table] = 'Exists';
            } catch (Exception $e) {
                $response['tables'][$table] = 'Missing';
            }
        }
    }
} catch (Exception $e) {
    $response['errors'][] = $e->getMessage();
}

echo json_encode($response, JSON_PRETTY_PRINT);
