# ADR-005 — Resend para e-mail transacional

**Status:** Aceita
**Data:** 2026-10-09

## Contexto

O MVP precisa enviar confirmação de cadastro, recuperação de senha, notificações de novas avaliações e avisos que exijam ação. O serviço deve ser simples de integrar ao Laravel, oferecer ambiente inicial de baixo custo e informar eventos de entrega e rejeição.

## Decisão

Usar Resend como provedor de e-mail transacional em produção. O backend envia mensagens pela abstração do Laravel, mantendo o provedor atrás de um adaptador de infraestrutura.

Usar Mailpit no desenvolvimento e o transporte falso do Laravel nos testes automatizados. Templates serão versionados no backend.

Autenticar um domínio técnico de envio com SPF, DKIM e DMARC. Usar inicialmente remetentes separados para acesso e notificações.

Processar webhooks assinados e idempotentes para acompanhar entrega, atraso, rejeição, bounce e reclamação. Não habilitar rastreamento de abertura ou clique no MVP.

## Alternativas consideradas

### Amazon SES

Possui custo por mensagem inferior, mas exige mais configuração e operação na fase inicial. Permanece como opção quando volume e custo justificarem a migração.

### Postmark

Atende bem ao envio transacional, mas o plano inicial oferece menos margem gratuita para o MVP.

### Servidor SMTP próprio

Rejeitado pelo custo operacional, reputação de envio e complexidade de entregabilidade.

## Consequências

- Produção depende da disponibilidade e dos limites do Resend.
- DNS e domínio remetente precisam ser configurados antes do lançamento.
- O sistema distingue aceitação pelo provedor de entrega confirmada.
- Bounces e reclamações interrompem novas tentativas automáticas daquele envio.
- A abstração do Laravel reduz o impacto de uma futura troca de provedor.
- Credenciais do Resend permanecem somente no backend.
