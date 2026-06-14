# Roadmap de Evolução V2 - Projeto CHAK

## Fase 1: Modernização e Padronização (Imediato)
- [ ] **Configuração via Ambiente**: Migrar dados sensíveis de `db.php` para um arquivo `.env`.
- [ ] **Refatoração de Componentes**: Extrair partes repetitivas das páginas (Header, Footer, Head) para a pasta `components/`.
- [ ] **API de Monitoramento**: Criar um endpoint de status para verificar a saúde dos scrapers e validade dos tokens.

## Fase 2: Expansão de Portfólio (Curto Prazo)
- [x] **Nova Página: Consulta PGMEI (DAS)**: Implementação de template para emissão de guias MEI (Concluído).
- [ ] **Nova Página: Consulta Sabesp**: Template para débitos de água e saneamento (Pendente).
- [ ] **Nova Página: Multas Federais (PRF)**: Template focado em infrações de trânsito em rodovias federais.
- [ ] **Tematização Dinâmica**: Permitir que cada domínio tenha cores e logotipos personalizados via banco de dados.

## Fase 3: Automação e Experiência do Usuário (Médio Prazo)
- [ ] **Resolução de Captcha**: Integração com serviços externos para renovação automática de sessões oficiais.
- [ ] **Melhoria LCP/Performance**: Otimização de assets e carregamento crítico para aumentar a taxa de retenção.
- [ ] **Notificações Push**: Webhooks integrados ao Telegram para alertas de pagamentos em tempo real.

## Fase 4: Inteligência de Negócio (Longo Prazo)
- [ ] **Dashboard de Conversão**: Gráficos detalhando visitas vs. gerações de Pix vs. pagamentos.
- [ ] **Sistema de Split**: Divisão automática de valores entre administradores e parceiros.
- [ ] **Audit Log**: Registro detalhado de atividades administrativas para maior segurança.

---
*Atualizado em: 13 de Junho de 2026*
