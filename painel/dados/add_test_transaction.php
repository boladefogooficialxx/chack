<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../db.php';

try {
    $token = isset($_SESSION['token']) ? $_SESSION['token'] : null;

    if (!$token) {
        throw new Exception('Sessão não autenticada.');
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE token = :token LIMIT 1");
    $stmt->execute(array(':token' => $token));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('Usuário não encontrado para o token atual.');
    }

    $userId = isset($user['id']) ? (string)$user['id'] : '';
    $identity = isset($user['username']) ? $user['username'] : 'teste';

    if ($userId === '') {
        throw new Exception('ID do usuário está vazio.');
    }

    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
    $hora = date('Y-m-d H:i:s');
    $doc = (string)mt_rand(100000000, 999999999) . (string)mt_rand(10, 99);
    $ref = 'trx-test-' . substr(md5(uniqid((string)mt_rand(), true)), 0, 10);
    $cod = 'PIX-TESTE-' . strtoupper(substr(md5($ref), 0, 8));

    $insert = $pdo->prepare("
        INSERT INTO table_data (
            cpf_cnpj, nome, debito, valor_pago, ip, pais, identity, hora, status, id_usuario, ref, page, cod, ch
        ) VALUES (
            :cpf_cnpj, :nome, :debito, :valor_pago, :ip, :pais, :identity, :hora, :status, :id_usuario, :ref, :page, :cod, :ch
        )
    ");

    $ok = $insert->execute(array(
        ':cpf_cnpj' => $doc,
        ':nome' => 'Transacao Teste',
        ':debito' => 'Debito de teste',
        ':valor_pago' => 19.90,
        ':ip' => $ip,
        ':pais' => 'BR',
        ':identity' => $identity,
        ':hora' => $hora,
        ':status' => 'pendente',
        ':id_usuario' => $userId,
        ':ref' => $ref,
        ':page' => 'desktop',
        ':cod' => $cod,
        ':ch' => 'chave-teste'
    ));

    if (!$ok) {
        throw new Exception('PDO execute retornou false.');
    }

    header('Location: ../index.php?test_transaction=success');
    exit();
} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Erro ao inserir transação de teste:\n";
    echo $e->getMessage();
    exit();
}
