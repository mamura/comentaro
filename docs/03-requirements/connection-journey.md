# Jornada de conexão com o iFood

## Pré-condições externas

O Comentaro precisa possuir aplicação de teste no Portal do Desenvolvedor iFood com os módulos necessários. Para produção, precisa concluir a homologação, criar a aplicação centralizada de produção e obter acesso às lojas.

## Conectar uma loja

1. O usuário seleciona uma `Location` da própria organização.
2. Inicia a conexão com o iFood e informa o ID ou CNPJ usado para localizar a loja.
3. O Comentaro registra a integração como `draft` e apresenta que a autorização depende do iFood.
4. O operador do Comentaro solicita acesso à loja no Portal do Desenvolvedor.
5. A integração passa a `access_requested` e depois a `awaiting_approval`.
6. O responsável pela loja aprova a solicitação no Portal do Parceiro iFood.
7. O Comentaro renova o token da aplicação e consulta as lojas autorizadas.
8. Quando o `merchantId` esperado aparece, o Comentaro confere a associação e ativa a integração.
9. A integração `active` fica disponível para sincronização de avaliações.

A propagação da permissão pelo iFood pode não ser imediata. O sistema deve apresentar espera sem orientar o usuário a repetir cadastros.

## Estados

| Estado | Significado |
| --- | --- |
| `draft` | Conexão iniciada, ainda sem solicitação externa confirmada. |
| `access_requested` | Solicitação de acesso registrada pelo Comentaro. |
| `awaiting_approval` | Aguardando aprovação no Portal do Parceiro. |
| `activating` | Aprovação esperada; token e lista de lojas estão sendo reconciliados. |
| `active` | Loja autorizada, associada à unidade e disponível para sincronização. |
| `authorization_revoked` | A loja revogou ou perdeu a autorização no iFood. |
| `connection_failed` | A ativação ou verificação falhou e requer diagnóstico ou nova tentativa. |
| `disconnected` | Associação encerrada no Comentaro. |

## Regras da associação

- Um `merchantId` ativo só pode estar associado a uma `Location` no Comentaro.
- A unidade e o `merchantId` devem pertencer à organização autenticada em todas as operações.
- O usuário nunca informa nem visualiza `clientSecret`, token de acesso ou outra credencial da aplicação iFood.
- A desconexão interrompe novas sincronizações sem apagar as interações já importadas.
- Revogação de uma loja não deve interromper conexões de outras lojas.
- Ativação repetida deve reconciliar a associação existente, sem criar outra integração.

## Pendência seguinte

Definir o período da sincronização inicial, a frequência das sincronizações posteriores e o cursor usado para evitar perda ou duplicidade de avaliações.
