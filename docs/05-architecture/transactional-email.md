# E-mail transacional

## Responsabilidades

O e-mail transacional atende a:

- confirmação do endereço de e-mail;
- recuperação de senha;
- notificação de nova interação;
- aviso de integração que exige ação.

E-mails de marketing e campanhas não fazem parte do MVP.

## Ambientes

| Ambiente | Transporte |
| --- | --- |
| Desenvolvimento | Mailpit |
| Testes automatizados | Transporte falso do Laravel |
| Produção | Resend |

O backend envia mensagens pela abstração de e-mail do Laravel. O restante do domínio não depende diretamente da API ou dos tipos do Resend.

## Remetentes e domínio

O domínio técnico de envio será `mail.comentaro.com.br`, sujeito à disponibilidade e configuração do domínio principal.

Remetentes iniciais:

- `acesso@comentaro.com.br` para confirmação e recuperação;
- `notificacoes@comentaro.com.br` para avaliações e alertas operacionais.

Antes da produção, o domínio deve estar validado no Resend e publicar SPF, DKIM e DMARC no DNS.

## Templates

Templates ficam versionados no backend e separados por finalidade:

```text
Authentication
├── VerifyEmail
└── ResetPassword

Interactions
└── NewInteractionNotification

Operations
└── IntegrationRequiresAction
```

Não haverá rastreamento de abertura ou clique no MVP.

## Estados de uma notificação

| Estado | Significado |
| --- | --- |
| `pending` | A notificação aguarda processamento. |
| `submitted` | O Resend aceitou a mensagem. |
| `delivered` | O webhook confirmou a entrega. |
| `failed` | O envio não foi aceito ou esgotou as tentativas. |
| `bounced` | O provedor informou rejeição pelo destino. |
| `complained` | O destinatário marcou a mensagem como indesejada. |
| `silenced` | A configuração do estabelecimento impediu o envio. |

Aceitação pelo Resend não significa entrega, abertura ou leitura.

## Webhooks

O backend recebe eventos necessários de entrega, atraso, rejeição, bounce e reclamação.

Cada evento deve:

- ter sua assinatura validada;
- ser processado de forma idempotente;
- ser correlacionado pelo identificador externo do envio;
- atualizar apenas a notificação correspondente;
- rejeitar origens ou eventos inválidos;
- omitir segredos e conteúdo sensível desnecessário dos logs.

## Falhas e reenvio

Falhas transitórias seguem a política do ADR-004. Rejeições permanentes, bounces e reclamações não são repetidos automaticamente.

Uma notificação com falha pode ser reenviada manualmente. Uma mensagem `submitted` ou `delivered` não é reenviada pelo fluxo normal.

Confirmação de e-mail e recuperação de senha permitem nova solicitação com limitação de frequência.

## Evolução

O provedor poderá ser trocado por Amazon SES ou outro serviço sem alterar regras de negócio. A troca exige um novo adaptador, configuração de domínio e tratamento equivalente dos eventos relevantes.
