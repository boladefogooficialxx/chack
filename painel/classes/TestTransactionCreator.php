<?php

class TestTransactionCreator
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($user, $ip, $pais = 'Desconhecido')
    {
        $userId = isset($user['id']) ? (string)$user['id'] : '';

        if ($userId === '') {
            return array('success' => false, 'message' => 'Usuário inválido para inserção');
        }

        $identity = isset($user['username']) ? $user['username'] : 'teste';
        $hora = date('Y-m-d H:i:s');
        $randomBytes = function_exists('openssl_random_pseudo_bytes')
            ? openssl_random_pseudo_bytes(4)
            : substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $ref = 'trx-test-' . (function_exists('bin2hex') && strlen($randomBytes) === 4 ? bin2hex($randomBytes) : $randomBytes);
        $doc = (string)mt_rand(100000000, 999999999) . (string)mt_rand(10, 99);

        $stmt = $this->pdo->prepare("
            INSERT INTO table_data (
                cpf_cnpj, nome, debito, valor_pago, ip, pais, identity, hora, status, id_usuario, ref, page, cod, ch
            ) VALUES (
                :cpf_cnpj, :nome, :debito, :valor_pago, :ip, :pais, :identity, :hora, :status, :id_usuario, :ref, :page, :cod, :ch
            )
        ");

        $ok = $stmt->execute([
            ':cpf_cnpj' => $doc,
            ':nome' => 'Transacao Teste',
            ':debito' => 'Debito de teste',
            ':valor_pago' => 19.90,
            ':ip' => $ip,
            ':pais' => $pais,
            ':identity' => $identity,
            ':hora' => $hora,
            ':status' => 'pendente',
            ':id_usuario' => $userId,
            ':ref' => $ref,
            ':page' => 'desktop',
            ':cod' => 'PIX-TESTE-' . strtoupper(substr($ref, -8)),
            ':ch' => 'chave-teste'
        ]);

        if (!$ok) {
            return array('success' => false, 'message' => 'Falha ao inserir transação de teste');
        }

        return array('success' => true, 'message' => 'Transação de teste adicionada com sucesso');
    }
}
