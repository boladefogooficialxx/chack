# Arquitetura do Sistema - Projeto CHAK

## Visão Geral
O projeto CHAK é uma plataforma SaaS multi-tenancy desenvolvida em PHP Puro, projetada para gerenciar múltiplas páginas de captura e processamento de pagamentos via Pix.

## Componentes Principais

### 1. Roteamento (Front Controller)
- **Arquivo**: `index.php` (Raiz)
- **Funcionamento**: Identifica o domínio através de `$_SERVER['HTTP_HOST']` e consulta a tabela `dominios` para determinar qual template em `pages/` deve ser carregado.

### 2. Camada de Segurança e Camuflagem
- **Tracker (`base/tracker.php`)**: Analisa o User-Agent e o IP do visitante.
- **Site Decoy (`websitee/`)**: Se um robô ou rede suspeita for detectada, o sistema exibe um site "fantoche" para ocultar a operação real.

### 3. Motor de Scraping (Integração com Órgãos Oficiais)
- **Localização**: `api/` (ex: `apiSP.php`, `apGO.php`)
- **Tabela `conf`**: Centraliza tokens de sessão (Bearer JWT) e IDs de sessão capturados.
- **Proxy de Dados**: O sistema simula requisições de navegadores reais para extrair débitos de veículos em tempo real nos sites da Fazenda e Detran.

### 4. Processamento de Pagamentos
- **Localização**: `data/pix.php` e `api/gate.php`
- **Gateways Suportados**: PodPay, Nuviapay, AmoraPay, BlackPay, entre outros.
- **Fallback**: Caso não haja gateway configurado, o sistema gera um BRCode (Pix Copia e Cola) estático via algoritmo matemático interno.

## Estrutura de Banco de Dados (Resumo)
- `users`: Gestão de operadores e administradores.
- `dominios`: Mapeamento de URLs para pastas físicas.
- `configuracoes`: Chaves de API e chaves Pix por usuário.
- `logins`: Histórico de dados capturados dos visitantes.
- `table_data`: Registro de todas as transações Pix geradas.
- `notifications`: Gatilhos para alertas sonoros no painel.
- `typing_status`: Monitoramento de atividade em tempo real.
