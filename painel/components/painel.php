<script>

    // Estado do painel
let painelData = {
    dashboard: {},
    configuracoes: {},
    acessos: { data: [], page: 1, limit: 100, total_pages: 1 },
    logins: { data: [], page: 1, limit: 100, total_pages: 1 },
    tableData: { data: [], page: 1, limit: 100, total_pages: 1 }
};
 
// Seletores DOM - inicializar com delay para garantir que existem
let totalPaid, invoicesPrinted, totalLogins, totalAcessos;

function initializeSelectors() {
    totalPaid = document.getElementById('totalPaid');
    invoicesPrinted = document.getElementById('invoicesPrinted');
    totalLogins = document.getElementById('totalLogins');
    totalAcessos = document.getElementById('totalAcessos');
    
    if (!totalPaid || !invoicesPrinted || !totalLogins || !totalAcessos) {
        console.warn('Alguns seletores DOM não foram encontrados');
    }
}

// Função para buscar dados do painel
async function fetchPainelData(audio) {
    try {
        const params = new URLSearchParams({
            action: 'getPainel',
            pageAcessos: painelData.acessos.page,
            limitAcessos: painelData.acessos.limit,
            pageLogins: painelData.logins.page,
            limitLogins: painelData.logins.limit,
            pageTable: painelData.tableData.page,
            limitTable: painelData.tableData.limit
        });

        const res = await fetch(`./painel_functions.php?${params}`);
        const data = await res.json();

        painelData = data;

        // Comparação segura de números - com melhor logging
        if (painelData.dashboard && invoicesPrinted && totalAcessos && totalLogins) {
            
            const currentInvoices = parseInt(invoicesPrinted.textContent) || 0;
            const currentAcessos = parseInt(totalAcessos.textContent) || 0;
            const currentLogins = parseInt(totalLogins.textContent) || 0;
            
            // Verificar cada comparação individualmente
            const invoicesUpdated = data.dashboard.invoices_printed > currentInvoices;
            const acessosUpdated = data.dashboard.total_acessos > currentAcessos;
            const loginsUpdated = data.dashboard.total_logins > currentLogins;
    
            
            if (invoicesUpdated || acessosUpdated || loginsUpdated) {
                
                if (audio && typeof Notifications === 'function') {
                    try {
                        Notifications(audio);
                    } catch (err) {
                        console.error('Erro ao executar Notifications:', err);
                    }
                } else {
                    console.warn('Audio ou Notifications não disponível:', { 
                        audio: !!audio, 
                        isFunction: typeof Notifications === 'function' 
                    });
                }
            } else {
                console.log('Sem mudanças nos valores do dashboard');
            }

        } else {
            console.warn('Elementos DOM não inicializados:', {
                painelData: !!painelData.dashboard,
                invoicesPrinted: !!invoicesPrinted,
                totalAcessos: !!totalAcessos,
                totalLogins: !!totalLogins
            });
        }

        config = data.configuracoes;

        if (typeof loadConfiguration === 'function') {
            loadConfiguration(painelData.configuracoes);
        }

        renderPainel();
    } catch (err) {
        console.error('Erro ao buscar dados do painel:', err);
    }
}

// Renderiza todo o painel
function renderPainel() {
    try {
        
        // Dashboard stats - com verificação de null
        if (totalPaid && painelData.dashboard) {
            totalPaid.textContent = typeof formatCurrency === 'function' 
                ? formatCurrency(painelData.dashboard.total_paid) 
                : painelData.dashboard.total_paid;
        }
        if (invoicesPrinted && painelData.dashboard) invoicesPrinted.textContent = painelData.dashboard.invoices_printed || 0;
        if (totalLogins && painelData.dashboard) totalLogins.textContent = painelData.dashboard.total_logins || 0;
        if (totalAcessos && painelData.dashboard) totalAcessos.textContent = painelData.dashboard.total_acessos || 0;

        // Tabelas
        renderTableAcessos();
        renderTableLogins();
        renderTableData();
        renderApiStatus();
        notificacoesData();

        // Paginação
        updatePagination(painelData.acessos, 'acessos');
        updatePagination(painelData.logins, 'logins');
        updatePagination(painelData.tableData, 'tableData');
        
    } catch (err) {
        console.error('Erro ao renderizar painel:', err);
    }
}

function renderApiStatus() {
    const tbody = document.getElementById('tableBodyApiStatus');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (!painelData.confData || painelData.confData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 3rem; color: #9ca3af; font-style: italic;">' +
                          '<i data-lucide="info" style="width: 20px; vertical-align: middle; margin-right: 8px;"></i>' +
                          'Nenhuma informação de status disponível no momento. As APIs serão listadas assim que forem configuradas.' +
                          '</td></tr>';
        if (typeof lucide !== 'undefined') lucide.createIcons();
        return;
    }

    painelData.confData.forEach(item => {
        const row = document.createElement('tr');
        const expiraLabel = `${item.expirado_count || 0}`;
        const statusBadge = item.status_class === 'warning'
            ? `<span class="status-badge warning">${item.status_label || 'Sessão Expirada'} (${expiraLabel})</span>`
            : item.status_class === 'danger'
                ? `<span class="status-badge danger">${item.status_label || 'Sem Sessão'}</span>`
                : `<span class="status-badge success">${item.status_label || 'Ativa'}</span>`;

        // Definir link de cadastro baseado na tela (Busca mais flexível)
        let configLink = '#';
        const telaId = item.tela.toUpperCase();
        
        if (telaId.includes('ES')) configLink = '../atualizar_es_por_curl.php';
        else if (telaId.includes('SC')) configLink = '../cadastrar_curl_sc.php';
        else if (telaId.includes('PGMEI')) configLink = '../atualizar_pgmei_por_curl.php';
        else if (telaId.includes('MS')) configLink = '../atualizar_ms_por_curl.php';

        row.innerHTML = `
            <td style="font-weight: 600; color: #8bc34a; display: flex; align-items: center; gap: 10px;">
                ${item.tela}
                <button onclick="openTool('${configLink}')" title="Configurar Sessão" style="background: none; border: none; padding: 0; cursor: pointer; color: #94a3b8; display: flex; align-items: center;">
                    <i data-lucide="external-link" style="width: 14px;"></i>
                </button>
            </td>
            <td style="text-align: center;">${item.expirado_count}</td>
            <td>${item.atualizado_em || 'N/A'}</td>
            <td>${statusBadge}</td>
        `;
        tbody.appendChild(row);
    });
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

// Funções para Modal de Ferramentas (Iframe)
function openTool(url) {
    const modal = document.getElementById('toolModal');
    const iframe = document.getElementById('toolIframe');
    if (modal && iframe) {
        iframe.src = url;
        modal.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const closeToolModal = document.getElementById('closeToolModal');
    const toolModal = document.getElementById('toolModal');
    const toolIframe = document.getElementById('toolIframe');

    if (closeToolModal && toolModal) {
        closeToolModal.addEventListener('click', () => {
            toolModal.classList.remove('active');
            if (toolIframe) toolIframe.src = ''; // Limpar iframe ao fechar
        });
    }

    if (toolModal) {
        toolModal.addEventListener('click', (e) => {
            if (e.target === toolModal) {
                toolModal.classList.remove('active');
                if (toolIframe) toolIframe.src = '';
            }
        });
    }
});

// Funções para renderizar tabelas
function renderTableAcessos() {
    const tbody = document.getElementById('tableBodyAcessos');
    
    if (!tbody) {
        console.warn('Elemento tableBodyAcessos não encontrado');
        return;
    }
    
    tbody.innerHTML = '';
    
    // Verificar se dados existem
    if (!painelData.acessos || !painelData.acessos.data || painelData.acessos.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 2rem; color: #9ca3af;">Nenhum acesso registrado</td></tr>';
        return;
    }
    
    var contAcessos = painelData.acessos.total || painelData.acessos.data.length;
    painelData.acessos.data.forEach(item => {
        const row = document.createElement('tr');

        const device = item.device || 'no';

        row.innerHTML = `
            <td>${contAcessos}</td>
            <td><div class="page"><img title="${item.page}" src="../imagens/${item.page}.ico" onerror="this.src='../imagens/default.ico'"></div></td>
            <td>${item.povedor || 'N/A'}</td>
            <td title="${item.ip}">${item.ip && item.ip.length > 17 ? 'IPV6' : (item.ip || 'N/A')}</td>
            <td>${item.pais || 'N/A'}</td>
            <td style="white-space: nowrap;">${item.hora || 'N/A'}</td>
            <td>${item.cont || 0}</td>
            <td><div class="page"><img title="${device}" src="../imagens/${device}.ico" onerror="this.src='../imagens/default.ico'"></div></td>
            <td>${item.identity || 'N/A'}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon danger" onclick="deleteItem(${item.id}, 'acessos')" title="Excluir">
                        <i data-lucide="trash-2"></i>
                    </button>
                </div>
            </td>
        `;
        contAcessos--;
        tbody.appendChild(row);
    });
}

function renderTableLogins() {
    const tbody = document.getElementById('tableBodylogins');
    
    if (!tbody) {
        console.warn('Elemento tableBodylogins não encontrado');
        return;
    }
    
    tbody.innerHTML = '';

    // Verificar se dados existem
    if (!painelData.logins || !painelData.logins.data || painelData.logins.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="10" style="text-align: center; padding: 2rem; color: #9ca3af;">Nenhum login registrado</td></tr>';
        return;
    }

    tableData = painelData.tableData.data || [];

    var contLog = painelData.logins.total || painelData.logins.data.length;

    painelData.logins.data.forEach(item => {

        var loginDados = '';

        if (item.login_info && Array.isArray(item.login_info)) {
            item.login_info.forEach(dados => {
                loginDados += `<div class="logbox"><label>${dados.label || ''}</label><div>${dados.value || ''}</div></div>`;
            });
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${contLog}</td>
            <td><div class="page"><img title="${item.page || 'N/A'}" src="../imagens/${item.page || 'default'}.ico" onerror="this.src='../imagens/default.ico'"></div></td>
            <td class="center" style="gap: 12px;">${loginDados || 'N/A'}</td>
            <td>${item.dados || 'N/A'}</td>
            <td style="white-space: nowrap;">${item.debitos || 'N/A'}</td>
            <td title="${item.ip}">${item.ip && item.ip.length > 17 ? 'IPV6' : (item.ip || 'N/A')}</td>
            <td>${item.pais || 'N/A'}</td>
            <td>${item.identity || 'N/A'}</td>
            <td style="white-space: nowrap;">${item.hora || 'N/A'}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon danger" onclick="deleteItem(${item.id}, 'logins')" title="Excluir">
                        <i data-lucide="trash-2"></i>
                    </button>
                </div>
            </td>
        `;
        contLog--;
        tbody.appendChild(row);
    });
    
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

function notificacoesData() {
    const list = document.getElementById('notificationList');
    
    // Verificar se elemento existe
    if (!list) {
        console.warn('Elemento notificationList não encontrado no DOM');
        return;
    }
    
    list.innerHTML = '';

    // Verificar se notificacoes existe e é um array
    if (painelData.notificacoes && Array.isArray(painelData.notificacoes)) {
        painelData.notificacoes.forEach(item => {
            const li = document.createElement('li');
            li.className = 'notification-item';
            li.innerHTML = `${item.mensagem}<button data-id="${item.id}" class="delete-btn" aria-label="Deletar">🗑️</button>`;
            list.appendChild(li);
        });
    }

    const icon = document.getElementById('notificationButton'); 
    
    // Verificar se icon existe antes de manipular classes
    if (icon) {
        if (painelData.notificacoes && painelData.notificacoes.length > 0) {
            icon.classList.remove('hidden');
        } else {
            icon.classList.add('hidden');
        }
    }

}

function renderTableData() {
    const tbody = document.getElementById('tableBody');
    
    if (!tbody) {
        console.warn('Elemento tableBody não encontrado');
        return;
    }
    
    tbody.innerHTML = '';
    
    // Verificar se dados existem
    if (!painelData.tableData || !painelData.tableData.data || painelData.tableData.data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="11" style="text-align: center; padding: 2rem; color: #9ca3af;">Nenhuma transação registrada</td></tr>';
        return;
    }
    
    var contTableData = painelData.tableData.total || painelData.tableData.data.length;
    painelData.tableData.data.forEach(item => {
        const row = document.createElement('tr');
        const statusColor = typeof getStatusColor === 'function' ? getStatusColor(item.status) : 'default';
        
        var docCH = `<div>${item.nome || 'N/A'}</div><div style="font-size: 10px;">${item.ch || 'N/A'}</div>`;
 
        row.innerHTML = `
            <td>${contTableData}</td>
            <td><div class="page"><img title="${item.page}" src="../imagens/${item.page}.ico" onerror="this.src='../imagens/default.ico'"></div></td>
            <td>${item.cpf_cnpj || 'N/A'}</td>
            <td>${docCH}</td>
            <td>${item.debito || 'N/A'}</td>
            <td>${typeof formatCurrency === 'function' ? formatCurrency(item.valor_pago) : item.valor_pago}</td>
            <td title="${item.ip}">${item.ip && item.ip.length > 17 ? 'IPV6' : (item.ip || 'N/A')}</td>
            <td>${item.pais || 'N/A'}</td>
            <td>${item.identity || 'N/A'}</td>
            <td>${item.hora || 'N/A'}</td>
             <td>
                <div class="action-buttons">
                    <span class="status-badge ${statusColor}">
                        ${(item.status || 'desconhecido').charAt(0).toUpperCase() + (item.status || 'desconhecido').slice(1)}
                    </span>
                    <button class="btn-icon" onclick="editItem(${item.id})" title="Editar">
                        <i data-lucide="eye"></i>
                    </button>
                    <button class="btn-icon danger" onclick="deleteItem(${item.id}, 'table_data')" title="Excluir">
                        <i data-lucide="trash-2"></i>
                    </button>
                </div>
            </td>
        `;
        contTableData--;
        tbody.appendChild(row);
    });
    
    if (typeof lucide !== 'undefined') lucide.createIcons();
}

// Atualiza paginação
function updatePagination(paginData, key) {
    let prevBtn, nextBtn;
    
    if (key === 'acessos') {
        prevBtn = document.getElementById('prevAcessos');
        nextBtn = document.getElementById('nextAcessos');
    } else if (key === 'logins') {
        prevBtn = document.getElementById('prevLogins');
        nextBtn = document.getElementById('nextLogins');
    } else if (key === 'tableData') {
        prevBtn = document.getElementById('prevTable');
        nextBtn = document.getElementById('nextTable');
    }
    
    if (!prevBtn || !nextBtn) return;

    prevBtn.disabled = paginData.page <= 1;
    nextBtn.disabled = paginData.page >= paginData.total_pages;

    prevBtn.onclick = () => { paginData.page--; fetchPainelData(); };
    nextBtn.onclick = () => { paginData.page++; fetchPainelData(); };
}


// Loading Screen Controller
class LoadingController {
    constructor() {
        this.loadingScreen = document.getElementById('loading-screen');
        this.dashboard = document.getElementById('dashboard');
        this.progressFill = document.getElementById('progress-fill');
        this.progressPercent = document.getElementById('progress-percent');
        
        this.progress = 0;
        this.isComplete = false;
        
        this.init();
    }
    
    init() {
        // Start loading simulation
        this.simulateLoading();
    }
    
    simulateLoading() {
        const interval = setInterval(() => {
            if (this.progress >= 100) {
                clearInterval(interval);
                this.completeLoading();
                return;
            }
            
            // Increment progress with random values for realistic feel
            const increment = Math.random() * 15 + 5; // Between 5-20
            this.progress = Math.min(this.progress + increment, 100);
            
            this.updateProgress();
        }, 150); // Update every 150ms
    }
    
    updateProgress() {
        const roundedProgress = Math.round(this.progress);
        
        // Update progress bar
        this.progressFill.style.width = `${this.progress}%`;
        
        // Update percentage text
        this.progressPercent.textContent = `${roundedProgress}%`;
        
        // Update status message based on progress
        this.updateStatusMessage(roundedProgress);
    }
    
    updateStatusMessage(progress) {
        const statusElement = document.querySelector('.progress-status');
        
        if (progress < 30) {
            statusElement.textContent = 'Inicializando sistema...';
        } else if (progress < 60) {
            statusElement.textContent = 'Carregando componentes...';
        } else if (progress < 90) {
            statusElement.textContent = 'Preparando interface...';
        } else {
            statusElement.textContent = 'Finalizando...';
        }
    }
    
    completeLoading() {
        if (this.isComplete) return;
        this.isComplete = true;
        
        // Ensure 100% is shown
        this.progressFill.style.width = '100%';
        this.progressPercent.textContent = '100%';
        
        // Wait a moment then start fade out
        setTimeout(() => {
            this.loadingScreen.classList.add('fade-out');
            
            // Remove loading screen and show dashboard after fade out
            setTimeout(() => {
                this.loadingScreen.style.display = 'none';
                this.dashboard.classList.remove('hidden');
                
                // Add entrance animation to dashboard
                this.animateDashboardEntrance();
            }, 100);
        }, 600);
    }
    
    animateDashboardEntrance() {
        // Add subtle entrance animation to dashboard elements
        const elements = [
            '.welcome-section',
            '.stats-grid',
            '.charts-grid',
            '.actions-card'
        ];
        
        elements.forEach((selector, index) => {
            const element = document.querySelector(selector);
            if (element) {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 150);
            }
        });
    }
}


function DeletarNot(id) {
    fetch('./dados/deletar_notificacao.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    }).then(response => response.json()).then(data => {
        if (data.success) {
            const btn = document.querySelector(`.delete-btn[data-id="${id}"]`);
            const li = btn.closest('.notification-item');
            
            if (li) li.remove();

            const list = document.getElementById('notificationList');
            const itemsRestantes = list.querySelectorAll('.notification-item');

            if (itemsRestantes.length === 0) {

                list.parentElement.classList.add('hidden'); 
                const icon = document.getElementById('notificationButton');
                if (icon) { icon.classList.add('hidden'); }
            }

        } else {
            console.error('Erro ao deletar:', data.error);
        }
    }).catch(error => {
        console.error('Erro na requisição:', error);
    });
}

// Dashboard Interactions
class DashboardController {
    constructor() {
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.addHoverEffects();
    }
    
    setupEventListeners() {
        // Header buttons
        const headerButtons = document.querySelectorAll('.header-btn');
        headerButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const title = e.target.getAttribute('title');
                this.showTooltip(`${title} clicado!`);
            });
        });
        
        // Action buttons
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const label = e.target.querySelector('.action-label')?.textContent || 'Ação';
                this.showTooltip(`${label} selecionado!`);
            });
        });
    }
    
    addHoverEffects() {
        // Add subtle hover effects to cards
        const cards = document.querySelectorAll('.stat-card, .chart-card, .actions-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.boxShadow = '0 10px 25px -5px rgba(0, 0, 0, 0.3)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = 'none';
            });
        });
    }
    
    showTooltip(message) {
        // Create and show a simple tooltip
        const existing = document.querySelector('.custom-tooltip');
        if (existing) existing.remove();
        
        const tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = message;
        tooltip.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(39, 39, 42, 0.95);
            color: #fafafa;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #52525b;
            font-size: 14px;
            z-index: 1000;
            backdrop-filter: blur(12px);
            animation: slideInRight 0.3s ease;
        `;
        
        // Add slide-in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(tooltip);
        
        // Remove after 3 seconds
        setTimeout(() => {
            tooltip.style.animation = 'slideInRight 0.3s ease reverse';
            setTimeout(() => {
                tooltip.remove();
                style.remove();
            }, 300);
        }, 3000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
 
    // Start loading screen
    const loadingController = new LoadingController();
    
    // Initialize dashboard (will be hidden initially)
    const dashboardController = new DashboardController();
    
    // Inicializar seletores DOM
    initializeSelectors();
    
    // Fetch data após DOM estar pronto com delay maior
    setTimeout(() => {

        fetchPainelData();
        
        // Chamar apenas se existirem
        if (typeof initializeApp === 'function') {
            initializeApp();
        }
        if (typeof setupEventListeners === 'function') {
            setupEventListeners();
        }
        if (typeof loadConfiguration === 'function') {
            loadConfiguration();
        }
        if (typeof updateLastUpdateTime === 'function') {
            updateLastUpdateTime();
        }
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }, 200);
});


</script>
