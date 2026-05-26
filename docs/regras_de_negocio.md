# Regras de Negócio e Fluxos - Projeto CHAK

## 1. Fluxo de Captura de Dados

### 1.1. Antecipação (Typing Status)
- Assim que o usuário foca e digita em um campo de entrada (ex: Renavam), o frontend inicia um ping para `api/typing_start.php`.
- O painel administrativo exibe um status de "Digitando..." para o operador.

### 1.2. Consulta de Débitos
- Ao submeter o formulário, o sistema faz uma requisição para o script de API correspondente ao estado.
- O sistema busca o token ativo na tabela `conf`.
- Se o token for válido, o sistema retorna o JSON original do governo mapeado para o visual da página de captura.

## 2. Fluxo de Pagamento Pix

### 2.1. Geração do Código
- O usuário seleciona os débitos e clica em gerar pagamento.
- O sistema registra a intenção em `table_data` com status `pendente`.
- Um alerta sonoro (Audio ID 3) é disparado para o administrador.

### 2.2. Confirmação (Baixa Automática)
- O gateway de pagamento envia um POST para a pasta `webhooks/`.
- O sistema valida a assinatura do webhook, localiza a transação e altera o status para `pago`.
- Um alerta sonoro de sucesso (Audio ID 4) é disparado no painel.

## 3. Gestão de Afiliados/Usuários
- Cada domínio é vinculado a um `id_usuario`.
- O sistema garante que um operador não veja os dados capturados nos domínios de outro operador (exceto o usuário `master`).
