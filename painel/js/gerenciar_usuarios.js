// Gerenciamento de Usuários - Apenas para Master

// Abrir modal de usuários
const manageUsersBtn = document.getElementById('manageUsersBtn');
const usersModal = document.getElementById('usersModal');
const closeUsersModal = document.getElementById('closeUsersModal');

if (manageUsersBtn) {
    manageUsersBtn.addEventListener('click', () => {
        usersModal.classList.add('active');
        carregarUsuarios();
    });
}

if (closeUsersModal) {
    closeUsersModal.addEventListener('click', () => {
        usersModal.classList.remove('active');
    });
}

// Fechar modal ao clicar fora
if (usersModal) {
    usersModal.addEventListener('click', (e) => {
        if (e.target === usersModal) {
            usersModal.classList.remove('active');
        }
    });
}

// Modal de edição de usuário
const editUserModal = document.getElementById('editUserModal');
const closeEditUserModal = document.getElementById('closeEditUserModal');
const cancelEditUser = document.getElementById('cancelEditUser');
const saveEditUser = document.getElementById('saveEditUser');

if (closeEditUserModal) {
    closeEditUserModal.addEventListener('click', () => {
        editUserModal.classList.remove('active');
    });
}

if (cancelEditUser) {
    cancelEditUser.addEventListener('click', () => {
        editUserModal.classList.remove('active');
    });
}

if (editUserModal) {
    editUserModal.addEventListener('click', (e) => {
        if (e.target === editUserModal) {
            editUserModal.classList.remove('active');
        }
    });
}

// Carregar usuários
async function carregarUsuarios() {
    const usersList = document.getElementById('usersList');
    usersList.innerHTML = `
        <div class="loading-users" style="text-align: center; padding: 2rem;">
            <div class="spinner-container">
                <div class="spinner-main"></div>
            </div>
            <p style="margin-top: 1rem; color: #9ca3af;">Carregando usuários...</p>
        </div>
    `;

    try {
        const response = await fetch('./dados/listar_usuarios.php');
        const data = await response.json();

        if (data.success && data.users) {
            renderizarUsuarios(data.users);
        } else {
            usersList.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: #ef4444;">
                    <i data-lucide="alert-circle" style="width: 48px; height: 48px;"></i>
                    <p style="margin-top: 1rem;">${data.error || 'Erro ao carregar usuários'}</p>
                </div>
            `;
            lucide.createIcons();
        }
    } catch (error) {
        console.error('Erro ao carregar usuários:', error);
        usersList.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #ef4444;">
                <i data-lucide="alert-circle" style="width: 48px; height: 48px;"></i>
                <p style="margin-top: 1rem;">Erro ao carregar usuários</p>
            </div>
        `;
        lucide.createIcons();
    }
}

// Renderizar lista de usuários
function renderizarUsuarios(users) {
    const usersList = document.getElementById('usersList');
    
    if (users.length === 0) {
        usersList.innerHTML = `
            <div style="text-align: center; padding: 2rem; color: #9ca3af;">
                <i data-lucide="users" style="width: 48px; height: 48px;"></i>
                <p style="margin-top: 1rem;">Nenhum usuário encontrado</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }

    let html = '';
    users.forEach(user => {
        const inicial = user.username.charAt(0).toUpperCase();
        const roleBadge = user.role === 'master' ? 'badge-master' : 'badge-comum';
        const roleText = user.role === 'master' ? 'Master' : 'Comum';
        
        let paymentType = 'Nenhuma';
        let paymentClass = 'payment-none';
        let paymentInfo = '';
        
        if (user.config) {
            if (user.config.Plataforma === 'chavepix') {
                paymentType = 'Chave PIX';
                paymentClass = 'payment-pix';
                paymentInfo = `
                    <div class="user-field">
                        <label>Chave PIX</label>
                        <span>${user.config.chave || 'Não configurada'}</span>
                    </div>
                    <div class="user-field">
                        <label>Nome</label>
                        <span>${user.config.nome || 'N/A'}</span>
                    </div>
                    <div class="user-field">
                        <label>Cidade</label>
                        <span>${user.config.cidade || 'N/A'}</span>
                    </div>
                `;
            } else if (user.config.Plataforma) {
                paymentType = user.config.Plataforma.toUpperCase();
                paymentClass = 'payment-gate';
                paymentInfo = `
                    <div class="user-field">
                        <label>Secret Key</label>
                        <span>${user.config.secret_key ? '****' + user.config.secret_key.slice(-8) : 'N/A'}</span>
                    </div>
                    <div class="user-field">
                        <label>Public Key</label>
                        <span>${user.config.public_key ? '****' + user.config.public_key.slice(-8) : 'N/A'}</span>
                    </div>
                `;
            }
        }

        const dominiosCount = user.dominios.length;
        const dominiosText = dominiosCount === 0 ? 'Nenhum domínio' : 
                           dominiosCount === 1 ? '1 domínio' : 
                           `${dominiosCount} domínios`;

        html += `
            <div class="user-card">
                <div class="user-card-header">
                    <div class="user-info">
                        <div class="user-avatar">${inicial}</div>
                        <div class="user-details">
                            <h4>${user.username}</h4>
                            <p>${user.email}</p>
                        </div>
                    </div>
                    <span class="user-badge ${roleBadge}">${roleText}</span>
                </div>
                <div class="user-card-body">
                    <div class="user-field">
                        <label>Plataforma de Pagamento</label>
                        <span class="payment-type ${paymentClass}">${paymentType}</span>
                    </div>
                    ${paymentInfo}
                    <div class="user-field">
                        <label>Domínios</label>
                        <span>${dominiosText}</span>
                    </div>
                    <div class="user-field">
                        <label>Último Login</label>
                        <span>${user.last_login ? formatarData(user.last_login) : 'Nunca'}</span>
                    </div>
                </div>
                <div class="user-card-footer">
                    <button class="btn btn-outline btn-small" onclick="editarUsuario(${user.id})">
                        <i data-lucide="edit"></i>
                        Editar
                    </button>
                </div>
            </div>
        `;
    });

    usersList.innerHTML = html;
    lucide.createIcons();
}

// Editar usuário
async function editarUsuario(userId) {
    try {
        const response = await fetch('./dados/listar_usuarios.php');
        const data = await response.json();

        if (data.success && data.users) {
            const user = data.users.find(u => u.id === userId);
            if (user) {
                preencherFormularioEdicao(user);
                editUserModal.classList.add('active');
            }
        }
    } catch (error) {
        console.error('Erro ao carregar dados do usuário:', error);
        showToast('Erro ao carregar dados do usuário', 'error');
    }
}

// Preencher formulário de edição
function preencherFormularioEdicao(user) {
    const setValue = (id, val, prop = 'value') => {
        const el = document.getElementById(id);
        if (el) {
            el[prop] = val;
        }
    };

    setValue('editUserId', user.id);
    setValue('editUserName', user.username, 'textContent');

    const nameLabel = document.getElementById('editUsernameLabel');
    const roleBadge = document.getElementById('editRoleBadge');
    const avatar = document.getElementById('editUserAvatar');
    if (nameLabel) nameLabel.textContent = user.username;
    if (avatar) avatar.textContent = user.username.charAt(0).toUpperCase();
    if (roleBadge) {
        const isMaster = user.role === 'master';
        roleBadge.textContent = isMaster ? 'Master' : 'Comum';
        roleBadge.className = `user-badge ${isMaster ? 'badge-master' : 'badge-comum'}`;
    }

    // Preencher configurações
    if (user.config) {
        setValue('editPlataforma', user.config.Plataforma || '');
        setValue('editSecretKey', user.config.secret_key || '');
        setValue('editPublicKey', user.config.public_key || '');
        setValue('editWebhookUrl', user.config.webhook_url || '');
        setValue('editPixNome', user.config.nome || '');
        setValue('editPixCidade', user.config.cidade || '');
        setValue('editPixChave', user.config.chave || '');
    } else {
        setValue('editPlataforma', '');
        setValue('editSecretKey', '');
        setValue('editPublicKey', '');
        setValue('editWebhookUrl', '');
        setValue('editPixNome', '');
        setValue('editPixCidade', '');
        setValue('editPixChave', '');
    }

    // Flag de configuração ativa vem do usuário (tabela users.configuracoes)
    const configuracoesFlag = Number(user.configuracoes || 0) === 1;
    setValue('editConfigAtivo', configuracoesFlag, 'checked');

    // Mostrar/ocultar campos baseado na plataforma
    toggleEditPaymentFields();

    // Renderizar domínios
    renderizarDominiosUsuario(user.dominios);
}

// Toggle campos de pagamento na edição
const editPlataforma = document.getElementById('editPlataforma');
if (editPlataforma) {
    editPlataforma.addEventListener('change', toggleEditPaymentFields);
}

function toggleEditPaymentFields() {
    const plataformaSelect = document.getElementById('editPlataforma');
    const gateFields = document.getElementById('editGateFields');
    const gateFields2 = document.getElementById('editGateFields2');
    const pixFields = document.getElementById('editPixFields');
    const pixFields2 = document.getElementById('editPixFields2');
    const pixFields3 = document.getElementById('editPixFields3');
    const webhookGroup = document.getElementById('editWebhookGroup');

    // Se algum campo não existir (HTML não carregado), sai silenciosamente para evitar erro
    if (!plataformaSelect || !gateFields || !gateFields2 || !pixFields || !pixFields2 || !pixFields3 || !webhookGroup) {
        return;
    }

    const plataforma = plataformaSelect.value;

    if (plataforma === 'chavepix') {
        gateFields.style.display = 'none';
        gateFields2.style.display = 'none';
        pixFields.style.display = 'block';
        pixFields2.style.display = 'block';
        pixFields3.style.display = 'block';
        webhookGroup.style.display = 'none';
    } else if (plataforma === '') {
        gateFields.style.display = 'none';
        gateFields2.style.display = 'none';
        pixFields.style.display = 'none';
        pixFields2.style.display = 'none';
        pixFields3.style.display = 'none';
        webhookGroup.style.display = 'block';
    } else {
        gateFields.style.display = 'block';
        gateFields2.style.display = 'block';
        pixFields.style.display = 'none';
        pixFields2.style.display = 'none';
        pixFields3.style.display = 'none';
        webhookGroup.style.display = 'block';
    }
}

// Renderizar domínios do usuário
function renderizarDominiosUsuario(dominios) {
    const userDomains = document.getElementById('userDomains');
    
    if (dominios.length === 0) {
        userDomains.innerHTML = `
            <p style="color: #9ca3af; text-align: center; padding: 1rem;">
                Este usuário não possui domínios associados
            </p>
        `;
        return;
    }

    let html = '<div class="domain-list">';
    dominios.forEach(dominio => {
        const statusClass = dominio.status === 'ativo' ? 'ativo' : 'inativo';
        html += `
            <div class="domain-item">
                <div class="domain-item-info">
                    <div class="domain-name">${dominio.nome_dominio}</div>
                    <div class="domain-path">${dominio.diretorio_raiz}</div>
                    ${dominio.page ? `<div class="domain-path">Page: ${dominio.page}</div>` : ''}
                </div>
                <span class="domain-status ${statusClass}">${dominio.status}</span>
            </div>
        `;
    });
    html += '</div>';
    
    userDomains.innerHTML = html;
}

// Salvar edição de usuário
if (saveEditUser) {
    saveEditUser.addEventListener('click', async () => {
        const userId = document.getElementById('editUserId').value;
        const plataforma = document.getElementById('editPlataforma').value;
        const ativoCheckbox = document.getElementById('editConfigAtivo');
        
        const dados = {
            id_usuario: userId,
            plataforma: plataforma,
            webhook_url: document.getElementById('editWebhookUrl').value,
            configuracoes: ativoCheckbox && ativoCheckbox.checked ? 1 : 0
        };

        if (plataforma === 'chavepix') {
            dados.nome = document.getElementById('editPixNome').value;
            dados.cidade = document.getElementById('editPixCidade').value;
            dados.chave = document.getElementById('editPixChave').value;
            dados.secret_key = '';
            dados.public_key = '';
        } else if (plataforma) {
            dados.secret_key = document.getElementById('editSecretKey').value;
            dados.public_key = document.getElementById('editPublicKey').value;
            dados.nome = '';
            dados.cidade = '';
            dados.chave = '';
        }

        try {
            const response = await fetch('./dados/atualizar_usuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dados)
            });

            const result = await response.json();

            if (result.success) {
                showToast('Configurações atualizadas com sucesso!', 'success');
                editUserModal.classList.remove('active');
                carregarUsuarios(); // Recarregar lista de usuários
            } else {
                showToast(result.error || 'Erro ao atualizar configurações', 'error');
            }
        } catch (error) {
            console.error('Erro ao salvar:', error);
            showToast('Erro ao salvar configurações', 'error');
        }
    });
}

// Função auxiliar para formatar data
function formatarData(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
