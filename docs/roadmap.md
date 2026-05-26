# Roadmap de Evolução - Projeto CHAK

## Fase 1: Estabilidade e Segurança (Curto Prazo)
- [ ] **Unificação de Gateways**: Refatorar `api/gate.php` para uma estrutura orientada a objetos (Pattern Factory).
- [ ] **Reforço de API**: Implementar autenticação via Header (API-Key) para proteger os scripts de scraping em `api/`.
- [ ] **Validação de Tokens**: Criar monitor no painel para avisar visualmente quando um token de estado expirar.

## Fase 2: Automação (Médio Prazo)
- [ ] **Captcha Solver**: Integrar APIs de quebra de captcha para automatizar a renovação de tokens de SP e MG.
- [ ] **Notificações Push**: Implementar notificações via Telegram/WhatsApp para o administrador quando um Pix for pago.
- [ ] **Otimização de Banco**: Criar rotina de limpeza para a tabela `acessos` para manter a performance.

## Fase 3: Expansão e Escala (Longo Prazo)
- [ ] **Sistema de Split**: Implementar divisão automática de valores entre dono da plataforma e afiliado no momento do pagamento.
- [ ] **Novas Páginas**: Desenvolver templates para outros serviços (ex: faturas de água, multas federais).
- [ ] **Dashboard Pro**: Gráficos de performance (taxa de conversão por domínio/campanha).
