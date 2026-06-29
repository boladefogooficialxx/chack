# Log de Alterações (Desenvolvimento) - Projeto CHAK

## [2026-05-21] - Estabilização do Ambiente Local

### Adicionado
- Criada página de laboratório em `pages/teste/` para validação de fluxos sem depender de scraping oficial.
- Criado script `create_conf_table.php` para inicializar a tabela de configurações técnicas.
- Criado script `init_notifications.php` para garantir o funcionamento do sistema de alertas sonoros.

## [2026-06-28] - Configuração MS por cURL

### Adicionado
- Criado `atualizar_ms_por_curl.php` para salvar o cURL da API autenticada do Detran-MS.
- Criado `init_ms.php` para registrar a tela `ipms` na tabela `conf`.

### Ajustado
- `api/ms.php` passou a ler `token`, `cookie`, `referer` e `origin` salvos em `conf`.
- O painel administrativo ganhou atalho para configurar o MS junto das demais integrações.

### Corrigido
- **Banco de Dados**: Adicionado `AUTO_INCREMENT` no campo `id` da tabela `table_data`, que impedia o salvamento de transações.
- **Autenticação**: Corrigida a lógica de `user_id` na página de teste para evitar erro "Usuário não autenticado" no status de digitação.
- **Backend SP**: Ajustado `api/apiSP.php` para aceitar tokens Bearer colados manualmente (texto puro) além do formato JSON anterior.

### Infraestrutura
- Configuração e cadastro do domínio `localhost:8080` no banco de dados para permitir testes locais no ambiente Docker.
