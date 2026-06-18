<?php
echo "<!-- TRACKER START -->";
if($sucesso){ return;}

try {
    if (!isset($pdo) || !$pdo) {
        return;
    }

    $ip = getClientIp();
    $ipInfo = getFromIp($ip);

    if ($ipInfo) {
        $pais = $ipInfo->country ?? 'Desconhecido';
        $povedor = $ipInfo->isp ?? $ipInfo->org ?? $ipInfo->as ?? 'Desconhecido';
        $region = $ipInfo->region ?? $ipInfo->regionName ?? 'No';
        $city = $ipInfo->city ?? 'No';
    } else {
        $pais = 'Desconhecido';
        $povedor = 'Desconhecido';
        $region = 'No';
        $city = 'No';
    }

    $RedeBlocked = isBotNetwork($povedor, $rede_signatures_blocked);

    setcookie('ip', $ip, time() + (86400 * 30), "/");
    setcookie('pais', $pais, time() + (86400 * 30), "/");
    setcookie('povedor', $povedor, time() + (86400 * 30), "/");

    $id_usuario = $id_usuario ?? 1; 
    $page = $page ?? 'default_page';

    $info = detect_device();
    $device = $info['type'] ?? 'desktop';
    $is_bot = $info['is_bot'] ?? false;

    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id_usuario]);
    $user = $stmt->fetch();

    if ($user) {
        $username = $user['username'] ?? 'desconhecido';
        $horaCaptura = date('Y/m/d H:i:s');

        // Verifica se o IP já existe para este usuário e página
        $checkStmt = $pdo->prepare("SELECT cont FROM acessos WHERE ip = :ip AND id_usuario = :id_usuario AND page = :page LIMIT 1");
        $checkStmt->execute([
            ':ip' => $ip,
            ':id_usuario' => $id_usuario,
            ':page' => $page
        ]);

        $row = $checkStmt->fetch();
     
        if ($row) {
            // Atualiza o contador +1
            $novoCont = $row['cont'] + 1;
            $updateStmt = $pdo->prepare("UPDATE acessos SET cont = :cont, hora = :hora WHERE ip = :ip AND id_usuario = :id_usuario AND page = :page");
            $updateStmt->execute([
                ':cont' => $novoCont,
                ':hora' => $horaCaptura,
                ':ip' => $ip,
                ':id_usuario' => $id_usuario,
                ':page' => $page
            ]);
        } else {

            // Prevenir erro se a tabela notifications não estiver ok
            try {
                $updateStmt = $pdo->prepare("UPDATE notifications SET audio = :audio,  atual = :atual,  hora = :hora WHERE id = :id");
                $updateStmt->execute([
                    ':audio' => 1,
                    ':atual' => (string)rand(100000000, 999999999),
                    ':hora' => $horaCaptura,
                    ':id' => 1
                ]);
            } catch (Exception $e) {}

            // Insere novo registro
            $insertStmt = $pdo->prepare("
                INSERT INTO acessos (ip, povedor, pais, hora, cont, identity, page, id_usuario, device, RedeBlocked)
                VALUES (:ip, :povedor, :pais, :hora, :cont, :identity, :page, :id_usuario, :device, :RedeBlocked)
            ");

            $ISredeBot = ($RedeBlocked || $is_bot) ? 1 : 0;
            $localidade = $city . ' - ' . $region . ' - ' . $pais;

            $insertStmt->execute([
                ':ip' => $ip,
                ':povedor' => $povedor,
                ':pais' => $localidade,
                ':hora' => $horaCaptura,
                ':cont' => 1,
                ':identity' => $username,
                ':page' => $page,
                ':id_usuario' => (string)$id_usuario,
                ':device' => $device,
                ':RedeBlocked' => (string)$ISredeBot
            ]);
        }
    }

    if($is_bot || $RedeBlocked){
        if (file_exists(__DIR__ . "/../websitee/index.php")) {
            require_once __DIR__ . "/../websitee/index.php";
            exit();
        }
    }

    if (empty($_COOKIE['user_id'])) {
        $uniqueId = uniqid(mt_rand(), true);
        setcookie('user_id', $uniqueId, time() + (86400 * 30), "/");
    }

} catch (Exception $e) {
    error_log("Erro no Tracker: " . $e->getMessage());
}
