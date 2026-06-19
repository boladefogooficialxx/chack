 <script>

    var id_user = "<?=$id_user?>";
    var online = "<?=$online?>";
    var notificationsAtual = null;

    var sounds = ['./arquivos/when-604.mp3', './arquivos/just-saying-593.mp3', './arquivos/blip-131856.mp3', './arquivos/cashier.mp3', './arquivos/level-up-07-383747.mp3'];
    var Efe = [3, 2, 1, 0];

    function Notifications(e) {

        if (Efe[e - 1]) {
            // Verifica se a função exists antes de chamar
            if (typeof updateRandomStat === 'function') {
                updateRandomStat(Efe[e - 1]);
            } else {
                console.warn('updateRandomStat function not yet loaded');
            }
        }

        const notificationSound = new Audio(sounds[e - 1]);
        notificationSound.preload = 'auto';

        notificationSound.currentTime = 0;
        notificationSound.play().catch(error => {
            console.log('Erro ao tocar som:', error);
        });
    }

    function typing(inputValue) {
        const typingIndicator = document.querySelector('#typingIndicator');
        const typingText = typingIndicator.querySelector('.typing-text');

        const length = inputValue.length;
        const current = parseInt(typingText.textContent) || 0;

        if (current !== length) {
            typingIndicator.classList.toggle('hidden', length === 0);
            typingText.textContent = length;
        }
    }

    function AdOn(a) {
        if (online) {

            var co = document.querySelector('.admins-online');

            if (a && co?.textContent) {
                if (parseInt(co.textContent)!=a.length) {
                    var h ='';
                    co.innerHTML = a.length;
                    a?.forEach(dados => {
                        h += '<div><span class="status-dot online"></span>'+dados.username+'</div>';
                    });
                    document.querySelector('.tooltip-admins').innerHTML = h;
                }
            }
        }
    }

    function updateRandomStat(e) {
        const statValues = document.querySelectorAll('.stat-value');
        const statValue = statValues[e];

        if (!statValue) return;

        const statCard = statValue.closest('.stat-card');

        statValue.classList.add('stat-value-highlight');

        if (statCard) {
            statCard.classList.add('stat-card-highlight');
        }
    }

    async function verificarUrl() {

        try {
            const response = await fetch('./dados/notifications.php?id='+id_user);
            const data = await response.json();

            if (notificationsAtual !== data.atual) {
                if (notificationsAtual !== null) {
                    fetchPainelData(data.audio);
                }
                notificationsAtual = data.atual;
            }

            typing(data.typing);

            if(domains.length!=data.dominios.length){
              renderDomains(data.dominios);
            }

           if(data?.AdOn){ AdOn(data.AdOn); }
            
        } catch (error) {
            console.error('Erro na requisição:', error);
        } finally {
            setTimeout(verificarUrl, 5000);
        }
    }

    // Inicia o processo
    verificarUrl();

      // Dados demonstrativos dos domínios
        var domains = [];

        // Elementos do DOM
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalOverlay = document.getElementById('modalOverlay');
        const domainsGrid = document.getElementById('domainsGrid');
        const notification = document.getElementById('notification');
        const notificationText = document.getElementById('notificationText');

        // Função para renderizar os cards de domínios
        function renderDomains(dom) {

            openModalBtn.classList.remove('hidden');

            domains = dom;

            domainsGrid.innerHTML = '';
            
            domains.forEach(domain => {
                const card = document.createElement('div');
                card.className = 'domain-card';
                card.innerHTML = `
                    <div class="domain-card-header">
                        <div class="domain-info">
                            <div class="domain-name">${domain.nome_dominio}</div>
                            <div class="domain-user">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                ${domain.nome_usuario}
                            </div>
                            
                        </div>
                        <div class="domain-actions">
                            <div class="switch ${domain.status=='ativo' ? 'active' : ''}" data-id="${domain.id}">
                                <div class="switch-slider"></div>
                            </div>
                        </div>
                    </div>
                     <div style="display: flex;gap: 8px;">
                          <div class="status-badge ${domain.status=='ativo' ? 'active' : 'inactive'}">
                                <span class="status-dot"></span>
                                ${domain.status=='ativo' ? 'Ativo' : 'Inativo'}
                            </div>
                         <button class="copy-button" data-domain="${domain.nome_dominio}">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Copiar Domínio
                        </button>
                          <div style="width: 100%;display: flex;justify-content: end;">
                              <button class="ver-button" data-domain="${domain.nome_dominio}">
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="eye" class="lucide lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button> </div>
                        </div>
                 `;
                domainsGrid.appendChild(card);
            });

            // Adicionar event listeners aos switches
            document.querySelectorAll('.switch').forEach(switchEl => {
                switchEl.addEventListener('click', handleSwitchToggle);
            });

            // Adicionar event listeners aos botões de copiar
            document.querySelectorAll('.copy-button').forEach(btn => {
                btn.addEventListener('click', handleCopy);
            });

            document.querySelectorAll('.ver-button').forEach(btn => {
                btn.addEventListener('click', handleVer);
            });
        }

        // Função para alternar o switch
        async function handleSwitchToggle(e) {
            const switchEl = e.currentTarget;
            const domainId = parseInt(switchEl.dataset.id);
            const domain = domains.find(d => d.id === domainId);
            if (domain) {
                domain.status = domain.status === 'ativo' ? 'inativo' : 'ativo';

                const response = await fetch('./dados/dominio.php?status='+domain.status+'&id='+domain.id);
                const data = await response.json();

                showNotification(domain.status==='ativo' ? 'Domínio Ativado!' : 'Domínio Desativado!');
            }
          renderDomains(domains)
        }

        function handleVer(e) {
            const button = e.currentTarget;
            const domainName = button.dataset.domain;
            window.open("https://"+domainName, "_blank");
        }

        // Função para copiar o domínio
        function handleCopy(e) {
            const button = e.currentTarget;
            const domainName = button.dataset.domain;
            
            // Criar um elemento temporário para copiar
            const tempInput = document.createElement('input');
            tempInput.value = domainName;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            
            // Feedback visual no botão
            const originalHTML = button.innerHTML;
            button.classList.add('copied');
            button.innerHTML = `
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Copiado!
            `;
            
            setTimeout(() => {
                button.classList.remove('copied');
                button.innerHTML = originalHTML;
            }, 2000);
            
            showNotification(`${domainName} copiado!`);
        }

        // Função para mostrar notificação
        function showNotification(message) {
            notificationText.textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Abrir modal
        openModalBtn.addEventListener('click', () => {
            modalOverlay.classList.add('active');
        });

        // Fechar modal ao clicar no botão X
        closeModalBtn.addEventListener('click', () => {
            modalOverlay.classList.remove('active');
        });

        // Fechar modal ao clicar fora dele
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('active');
            }
        });

        // Fechar modal com tecla ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
                modalOverlay.classList.remove('active');
            }
        });
        
    </script>
