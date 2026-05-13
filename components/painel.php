<script>

    // Estado do painel
let painelData = {
    dashboard: {},
    configuracoes: {},
    acessos: { data: [], page: 1, limit: 100, total_pages: 1 },
    logins: { data: [], page: 1, limit: 100, total_pages: 1 },
    tableData: { data: [], page: 1, limit: 100, total_pages: 1 }
};
 
// Seletores DOM
const totalPaid = document.getElementById('totalPaid');
const invoicesPrinted = document.getElementById('invoicesPrinted');
const totalLogins = document.getElementById('totalLogins');
const totalAcessos = document.getElementById('totalAcessos');

const tableBodyAcessos = document.getElementById('tableBodyAcessos');
const tableBodyLogins = document.getElementById('tableBodylogins');
const tableBodyData = document.getElementById('tableBody');

const paginationAcessos = { prev: document.getElementById('prevAcessos'), next: document.getElementById('nextAcessos') };
const paginationLogins = { prev: document.getElementById('prevLogins'), next: document.getElementById('nextLogins') };
const paginationTable = { prev: document.getElementById('prevTable'), next: document.getElementById('nextTable') };
const addTestTransactionBtn = document.getElementById('addTestTransactionBtn');

// Função para buscar dados do painel
async function fetchPainelData() {
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

        const res = await fetch(`painel_functions.php?${params}`);
        const data = await res.json();

        painelData = data;

        config = data.configuracoes;

        loadConfiguration(painelData.configuracoes);

        renderPainel();
    } catch (err) {
        console.error('Erro ao buscar dados do painel:', err);
    }
}

async function addTestTransaction() {
    if (!addTestTransactionBtn) return;

    const originalHtml = addTestTransactionBtn.innerHTML;
    addTestTransactionBtn.disabled = true;
    addTestTransactionBtn.innerHTML = '<i data-lucide="loader-circle"></i> Adicionando...';

    try {
        const res = await fetch('./dados/add_test_transaction.php', {
            method: 'POST'
        });
        const data = await res.json();

        if (!data.success) {
            throw new Error(data.message || 'Falha ao adicionar item de teste');
        }

        painelData.tableData.page = 1;
        await fetchPainelData();

        if (typeof showToast === 'function') {
            showToast(data.message || 'Item de teste adicionado', 'success');
        }
    } catch (err) {
        console.error('Erro ao adicionar item de teste:', err);
        if (typeof showToast === 'function') {
            showToast(err.message || 'Erro ao adicionar item de teste', 'error');
        }
    } finally {
        addTestTransactionBtn.disabled = false;
        addTestTransactionBtn.innerHTML = originalHtml;
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
}

window.addTestTransaction = addTestTransaction;

// Renderiza todo o painel
function renderPainel() {
    // Dashboard stats
    totalPaid.textContent = formatCurrency(painelData.dashboard.total_paid);
    invoicesPrinted.textContent = painelData.dashboard.invoices_printed;
    totalLogins.textContent = painelData.dashboard.total_logins;
    totalAcessos.textContent = painelData.dashboard.total_acessos;

    // Tabelas
    renderTableAcessos();
    renderTableLogins();
    renderTableData();
    notificacoesData();

    // Paginação
    updatePagination(painelData.acessos, paginationAcessos, 'acessos');
    updatePagination(painelData.logins, paginationLogins, 'logins');
    updatePagination(painelData.tableData, paginationTable, 'tableData');
}

// Funções para renderizar tabelas
function renderTableAcessos() {
    tableBodyAcessos.innerHTML = '';
    var contAcessos = painelData.acessos.total;
    painelData.acessos.data.forEach(item => {
        const row = document.createElement('tr');

        row.className = item.RedeBlocked ? 'riscado' : '';

        const device = item.device || 'no';

        row.innerHTML = `
            <td>${contAcessos}</td>
            <td><div class="page"><img title="${item.page}" src="../imagens/${item.page}.ico"></div></td>
            <td>${item.povedor}</td>
            <td title="${item.ip}">${item.ip.length>17 ? 'IPV6' : item.ip}</td>
            <td>${item.pais}</td>
            <td style="white-space: nowrap;">${item.hora}</td>
            <td>${item.cont}</td>
            <td><div class="page"><img title="${device}" src="../imagens/${device}.ico"></div></td>
            <td>${item.identity}</td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon danger" onclick="deleteItem(${item.id}, 'acessos')" title="Excluir">
                        <i data-lucide="trash-2"></i>
                    </button>
                </div>
            </td>
        `;
        contAcessos--;
        tableBodyAcessos.appendChild(row);
    });
}

function renderTableLogins() {
    const tbody = document.getElementById('tableBodylogins');
    tbody.innerHTML = '';

    tableData = painelData.tableData.data;

    var contLog = painelData.logins.total;

    painelData.logins.data.forEach(item => {

         var loginDados = '';

        item.login_info?.forEach(dados => {
           loginDados +=  `<div class="logbox"><label>${dados.label}</label><div>${dados.value}</div></div>`;
       });

        row = document.createElement('tr');
        row.innerHTML = `
            <td>${contLog}</td>
            <td><div class="page"><img title="${item.page}" src="../imagens/${item.page}.ico"></div></td>
            <td class="center" style="gap: 12px;">${loginDados}</td>
            <td>${item.dados}</td>
            <td style="white-space: nowrap;">${item.debitos}</td>
            <td title="${item.ip}">${item.ip.length>17 ? 'IPV6' : item.ip}</td>
            <td>${item.pais}</td>
            <td>${item.identity}</td>
            <td style="white-space: nowrap;">${item.hora}</td>
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
}

function notificacoesData() {
    const list = document.getElementById('notificationList');
    list.innerHTML = '';

    painelData.notificacoes.forEach(item => {
        const li = document.createElement('li');
        li.className = 'notification-item';
        li.innerHTML = `${item.mensagem}<button data-id="${item.id}" class="delete-btn" aria-label="Deletar">🗑️</button>`;
        list.appendChild(li);
    });

    const icon = document.getElementById('notificationButton'); 

    if (painelData.notificacoes && painelData.notificacoes?.length > 0) {
        icon.classList.remove('hidden');
    } else {
        icon.classList.add('hidden');
    }

}

function renderTableData() {
    tableBodyData.innerHTML = '';
    var contTableData = painelData.tableData.total;
    painelData.tableData.data.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${contTableData}</td>
            <td><div class="page"><img title="${item.page}" src="../imagens/${item.page}.ico"></div></td>
            <td>${item.cpf_cnpj}</td>
            <td>${item.nome}</td>
            <td>${item.debito}</td>
            <td>${formatCurrency(item.valor_pago)}</td>
            <td title="${item.ip}">${item.ip.length>17 ? 'IPV6' : item.ip}</td>
            <td>${item.pais}</td>
            <td>${item.identity}</td>
            <td>${item.hora}</td>
             <td>
                <div class="action-buttons">
                    <span class="status-badge ${getStatusColor(item.status)}">
                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
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
        tableBodyData.appendChild(row);
    });
    lucide.createIcons();
}

// Atualiza paginação
function updatePagination(paginData, buttons, key) {
    if (!buttons || !buttons.prev || !buttons.next) return;

    buttons.prev.disabled = paginData.page <= 1;
    buttons.next.disabled = paginData.page >= paginData.total_pages;

    buttons.prev.onclick = () => { paginData.page--; fetchPainelData(); };
    buttons.next.onclick = () => { paginData.page++; fetchPainelData(); };
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
    
});

// Utility function to simulate stat updates
function updateRandomStat(e) {
    const statValues = document.querySelectorAll('.stat-value');
    if (statValues.length === 0) return;
    
    const randomStat = statValues[e];
    const currentValue = randomStat.textContent;
    
    // Add a subtle flash effect
    randomStat.style.transition = 'color 0.3s ease';
    randomStat.style.color = '#4ade80';
    
    setTimeout(() => {
        randomStat.style.color = '#fafafa';
    }, 1000);
}

function ConfigModel(e) {
     if(e=='chavepix'){
      document.querySelectorAll('.apigate').forEach(item => {
        item.style.display = 'none';
      });
       document.querySelectorAll('.chavepix').forEach(item => {
        item.style.display = '';
      });
    }else{
      document.querySelectorAll('.chavepix').forEach(item => {
        item.style.display = 'none';
      });
      document.querySelectorAll('.apigate').forEach(item => {
        item.style.display = '';
      });

      webhookUrlInput.value = window.location.origin+'/webhooks/'+e+'.php?id='+config.id_usuario;
    }
}

document.getElementById("gatewayPlatform").addEventListener("change", function() {
   ConfigModel(this.value);
});

// Inicializa
document.addEventListener('DOMContentLoaded', () => {
    fetchPainelData();
    initializeApp();
    setupEventListeners();
    loadConfiguration();
    updateLastUpdateTime();
    lucide.createIcons();
});


</script>
