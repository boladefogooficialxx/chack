<?php

class TestLoginCreator
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function create(array $user, string $ip, string $pais = 'Desconhecido'): array
    {
        $userId = (int)($user['id'] ?? 0);

        if ($userId <= 0) {
            return ['success' => false, 'message' => 'Usuário inválido para inserção'];
        }

        $identity = $user['username'] ?? 'teste';
        $hora = date('Y-m-d H:i:s');
        $reference = 'test-' . bin2hex(random_bytes(4));
        $loginInfo = json_encode([
            ['label' => 'Tipo', 'value' => 'Teste manual'],
            ['label' => 'Ref', 'value' => strtoupper($reference)]
        ], JSON_UNESCAPED_UNICODE);

        $stmt = $this->pdo->prepare("
            INSERT INTO logins (
                page, dados, debitos, ip, pais, identity, hora, login_info, id_usuario, resposta, reference
            ) VALUES (
                :page, :dados, :debitos, :ip, :pais, :identity, :hora, :login_info, :id_usuario, :resposta, :reference
            )
        ");

        $ok = $stmt->execute([
            ':page' => 'desktop',
            ':dados' => 'Registro de teste',
            ':debitos' => '1 / 0.00',
            ':ip' => $ip,
            ':pais' => $pais,
            ':identity' => $identity,
            ':hora' => $hora,
            ':login_info' => $loginInfo,
            ':id_usuario' => $userId,
            ':resposta' => '',
            ':reference' => $reference
        ]);

        if (!$ok) {
            return ['success' => false, 'message' => 'Falha ao inserir item de teste'];
        }

        return ['success' => true, 'message' => 'Item de teste adicionado com sucesso'];
    }
}
