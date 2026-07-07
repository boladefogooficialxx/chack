<?php
// update_proxy_country.php
// Atualiza o registro de proxy no banco para forçar sempre IP do Brasil (-country-br)
require_once "db.php";
header('Content-Type: text/plain; charset=utf-8');

try {
    // Lê config atual
    $stmt = $pdo->prepare("SELECT dados FROM conf WHERE tela = 'proxy' LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "❌ Nenhum registro de proxy encontrado no banco.\n";
        echo "Execute init_proxy.php primeiro.\n";
        exit;
    }

    $dados = json_decode($row['dados'], true);
    $userpwdAtual = $dados['userpwd'] ?? '';

    echo "Userpwd atual: " . $userpwdAtual . "\n";

    // Adiciona -country-br se ainda não tiver
    if (strpos($userpwdAtual, '-country-br') === false) {
        // Insere -country-br antes do : (antes da senha)
        $novoUserpwd = str_replace(':', '-country-br:', $userpwdAtual);
        $dados['userpwd'] = $novoUserpwd;

        $novoJson = json_encode($dados, JSON_UNESCAPED_UNICODE);
        $update = $pdo->prepare("UPDATE conf SET dados = ? WHERE tela = 'proxy'");
        $update->execute([$novoJson]);

        echo "✅ Userpwd atualizado: " . $novoUserpwd . "\n";
        echo "✅ Banco atualizado! Proxy agora sempre usa IP do Brasil.\n";
    } else {
        echo "ℹ️ Já contém -country-br, nenhuma alteração necessária.\n";
        echo "Userpwd: " . $userpwdAtual . "\n";
    }
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
}
?>
