# Estados da interação

Os estados são independentes. A interação não possui um único estado que misture processamento, notificação, resposta e IA.

## Processamento

| Estado | Significado |
| --- | --- |
| `received` | Avaliação capturada e persistida. |
| `analyzing` | Prioridade, satisfação e confiança estão sendo calculadas. |
| `available` | Processamento concluído e avaliação disponível para atendimento. |
| `processing_failed` | Uma etapa do processamento falhou. A avaliação continua acessível. |

## Notificação

| Estado | Significado |
| --- | --- |
| `pending` | A notificação aguarda processamento. |
| `submitted` | O Resend aceitou a mensagem. |
| `delivered` | O webhook confirmou a entrega. |
| `failed` | O envio não foi aceito ou esgotou as tentativas. |
| `bounced` | O provedor informou rejeição pelo destino. |
| `complained` | O destinatário marcou a mensagem como indesejada. |
| `silenced` | A configuração do estabelecimento impediu o envio. |

## Resposta

| Estado | Significado |
| --- | --- |
| `not_replied` | Ainda não há resposta do estabelecimento. |
| `draft` | Existe um texto preparado e ainda não enviado. |
| `sending` | O envio ao iFood está em andamento. |
| `replied` | A resposta foi confirmada no iFood. |
| `send_failed` | A tentativa falhou ou teve resultado incerto e requer reconciliação. |
| `unavailable` | O iFood não permite mais responder à avaliação. |

## Sugestão por IA

| Estado | Significado |
| --- | --- |
| `not_requested` | Nenhuma sugestão foi solicitada. |
| `generating` | A sugestão está sendo gerada. |
| `available` | A sugestão está disponível para revisão e edição. |
| `failed` | A geração falhou; a resposta manual continua disponível. |

## Transições importantes

- Uma interação pode estar `processing_failed` e continuar `not_replied`, permitindo resposta manual.
- Uma notificação `failed` não muda o estado de processamento ou resposta.
- `send_failed` exige consulta ao iFood antes de uma nova tentativa.
- `silenced` registra a decisão vigente no momento da captura; mudar a configuração não envia retroativamente os avisos silenciados.
