<?php

class TestTransactionCreator
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(array $user, string $ip, string $pais = 'Desconhecido'): array
    {
        $userId = (string)($user['id'] ?? '');

        if ($userId === '') {
            return ['success' => false, 'message' => 'Usuário inválido para inserção'];
        }

        $identity = $user['username'] ?? 'teste';
        $hora = date('Y-m-d H:i:s');
        $ref = 'trx-test-' . bin2hex(random_bytes(4));
        $doc = (string)random_int(10000000000, 99999999999);

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
            return ['success' => false, 'message' => 'Falha ao inserir transação de teste'];
        }

        return ['success' => true, 'message' => 'Transação de teste adicionada com sucesso'];
    }
}
