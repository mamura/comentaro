# Critérios de aceite do MVP

Os critérios estão organizados por história e descrevem comportamento observável. Detalhes de interface e tecnologia serão definidos depois.

## US-001 — Cadastrar usuário e organização

**Como** novo usuário, **quero** criar minha conta e organização, **para** começar a configurar o Comentaro.

- Dado um e-mail ainda não cadastrado e dados válidos, quando o cadastro for concluído, então usuário e organização são criados juntos e vinculados.
- Se qualquer parte do cadastro falhar, não deve existir usuário utilizável sem organização nem organização ativa sem usuário.
- Depois do cadastro, o sistema informa que o e-mail precisa ser confirmado.
- Antes da confirmação, o usuário não acessa o uso normal da aplicação.

## US-002 — Confirmar e acessar a conta

**Como** usuário cadastrado, **quero** confirmar meu e-mail e entrar, **para** acessar minha organização.

- Um mecanismo de confirmação válido confirma o e-mail uma única vez.
- Um mecanismo inválido, expirado ou já utilizado não confirma a conta e apresenta orientação segura.
- E-mail e senha válidos de uma conta confirmada iniciam uma sessão persistente.
- Credenciais inválidas não iniciam sessão nem revelam detalhes desnecessários sobre a conta.
- A ação de sair encerra a sessão atual.

## US-003 — Recuperar a senha

**Como** usuário, **quero** redefinir minha senha por e-mail, **para** recuperar o acesso.

- A solicitação apresenta resposta neutra independentemente de o e-mail estar cadastrado.
- Um mecanismo temporário válido permite definir uma nova senha.
- Depois de utilizado ou expirado, o mecanismo não pode ser usado novamente.
- A nova senha passa a ser necessária nos próximos acessos.

## US-004 — Manter isolamento por organização

**Como** usuário, **quero** acessar somente minha organização, **para** proteger os dados de cada cliente.

- Toda leitura ou alteração autenticada deriva a organização da sessão.
- Alterar um identificador enviado pela interface não permite consultar ou modificar unidade, integração, interação, resposta ou histórico de outra organização.
- Uma tentativa entre organizações é recusada e não revela o conteúdo do recurso.

## US-005 — Cadastrar estabelecimento

**Como** usuário, **quero** cadastrar um estabelecimento, **para** conectá-lo a um canal.

- Um estabelecimento válido é criado dentro da organização autenticada.
- O estabelecimento aparece na lista da organização.
- Estabelecimentos de outras organizações não aparecem nem podem ser associados.

## US-006 — Solicitar conexão com o iFood

**Como** usuário, **quero** iniciar a conexão de um estabelecimento, **para** autorizar o Comentaro a acessar suas avaliações.

- O usuário seleciona um estabelecimento da própria organização e informa ID ou CNPJ da loja.
- O sistema cria uma única integração em `draft` para a tentativa.
- O usuário acompanha as transições `access_requested` e `awaiting_approval` e recebe orientação sobre a aprovação no Portal do Parceiro.
- Repetir a ação não cria uma segunda integração para a mesma associação.
- Nenhuma credencial ou token da aplicação iFood é exibido ao usuário.

## US-007 — Ativar a loja autorizada

**Como** usuário, **quero** que a aprovação seja reconhecida, **para** iniciar a sincronização.

- Depois da aprovação e propagação da permissão, a loja aparece na consulta de lojas autorizadas.
- O `merchantId` confirmado é associado somente ao estabelecimento e à organização corretos.
- Um `merchantId` já associado ativamente não pode ser vinculado a outro estabelecimento.
- Durante a carga inicial, a integração fica `activating`.
- A integração só fica `active` depois da conclusão confirmada da carga inicial.

## US-008 — Importar avaliações iniciais

**Como** usuário, **quero** receber um histórico recente, **para** começar com contexto suficiente.

- A ativação consulta a janela móvel dos 30 dias anteriores.
- São persistidas no máximo as 100 avaliações mais recentes da janela.
- Se uma avaliação aparecer novamente em outra página ou tentativa, permanece uma única interação.
- Avaliações dessa carga não geram e-mail de notificação.
- Uma falha parcial não marca como concluído um lote que não foi persistido.

## US-009 — Sincronizar novas avaliações

**Como** usuário, **quero** sincronização periódica, **para** acompanhar novas avaliações.

- Uma integração nova recebe frequência padrão de uma hora.
- O usuário pode escolher uma das frequências permitidas para a integração.
- A interface mostra a última execução, seu resultado e a próxima execução prevista.
- Uma execução repetida ou sobreposta não duplica avaliações.
- Depois de falha transitória, o processo retoma a partir de progresso confirmado.
- Falhar em uma integração não interrompe a sincronização das demais.

## US-010 — Consultar e compreender uma interação

**Como** usuário, **quero** uma caixa de entrada e um detalhe da avaliação, **para** decidir como atendê-la.

- Cada item mostra estabelecimento, origem, nota, comentário, data e estado de resposta.
- Notas 1–2 aparecem com prioridade alta, nota 3 com média e notas 4–5 com baixa.
- O detalhe mostra satisfação inferida e confiança separadas da nota e da prioridade.
- Confiança baixa apresenta satisfação indeterminada ou indicação de revisão.
- Falha na análise não impede leitura nem resposta manual.

## US-011 — Configurar e receber notificações

**Como** usuário, **quero** ativar ou silenciar notificações por estabelecimento, **para** controlar os avisos.

- Depois da conexão, a notificação começa ativa.
- Uma nova avaliação capturada após a carga inicial gera um e-mail quando a configuração está ativa.
- A configuração silenciada preserva a captura e impede o envio de novos e-mails.
- Mudar a configuração não envia retroativamente notificações silenciadas.
- Uma falha de envio fica visível e permite reenvio manual sem afetar a interação.

## US-012 — Responder uma avaliação

**Como** usuário, **quero** escrever e enviar uma resposta, **para** atender o cliente no iFood.

- A resposta pode ser salva como rascunho e editada antes do envio.
- Antes do envio, o sistema consulta o estado atual da avaliação e valida as restrições vigentes do iFood.
- Uma resposta aceita pelo iFood muda o estado local para `replied` e entra no histórico.
- Se o iFood não permitir resposta, o estado passa a `unavailable` e nenhum novo envio é feito.
- Se o resultado do envio for incerto, o sistema consulta o iFood antes de permitir nova tentativa.
- Uma resposta já registrada no iFood não é enviada novamente.

## US-013 — Acompanhar e recuperar falhas

**Como** usuário, **quero** entender falhas e tentar novamente quando possível, **para** continuar o trabalho.

- A etapa afetada, o estado atual e uma mensagem útil ficam visíveis.
- Cada tentativa registra data, etapa e resultado conhecido.
- A nova tentativa só aparece quando a operação puder ser repetida com segurança.
- Falha de análise, notificação ou IA não bloqueia a resposta manual.
- Revogação de acesso ao iFood interrompe novas sincronizações daquela integração sem apagar interações existentes.

## US-014 — Gerar sugestão por IA

**Como** usuário, **quero** solicitar uma sugestão de resposta, **para** reduzir o tempo de redação.

- A geração ocorre somente após solicitação do usuário.
- A sugestão fica disponível para revisão e edição e nunca é publicada automaticamente.
- O usuário confirma explicitamente o envio do texto final.
- Uma falha na geração mantém a resposta manual disponível.

Esta história pertence à segunda prioridade do MVP.
