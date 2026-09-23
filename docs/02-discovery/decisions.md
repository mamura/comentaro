# Registro de decisões de produto

## DEC-001 — Alcance do monitoramento

**Status:** Aceita

A visão inclui interações nos canais próprios conectados e menções públicas externas. O MVP começa apenas com interações diretamente associadas aos canais conectados.

## DEC-002 — Primeiro vertical

**Status:** Aceita

Restaurantes são o primeiro vertical. O modelo de domínio deve continuar aplicável a outros negócios.

## DEC-003 — Estrutura conceitual

**Status:** Aceita

Usar `Organization > Location > Integration > Interaction`. `Interaction` é a entidade central, abrangendo tipos de interação que não se limitam a avaliações.

## DEC-004 — Tratamento de casos críticos

**Status:** Adiada

O MVP não classifica nem aplica um fluxo especial a casos críticos. A regra será reconsiderada quando existirem exemplos reais suficientes para definir critérios confiáveis.

## DEC-005 — Arquitetura técnica

**Status:** Pendente

Stack, desenho de componentes, persistência, hospedagem e provedores não foram decididos nem implementados.

## DEC-006 — Primeiro canal

**Status:** Aceita

O iFood será o primeiro canal de integração. No primeiro recorte, as interações capturadas desse canal são avaliações associadas aos estabelecimentos conectados.

## DEC-007 — Prioridade e satisfação

**Status:** Aceita

A nota determina a prioridade inicial: 1 ou 2 estrelas resulta em prioridade alta, 3 em média e 4 ou 5 em baixa.

O texto é analisado separadamente para inferir satisfação como muito insatisfeito, insatisfeito, neutro, satisfeito, muito satisfeito ou indeterminado. A análise também informa confiança baixa, média ou alta. Com confiança baixa, a satisfação é apresentada como indeterminada ou como classificação que precisa de revisão.

## DEC-008 — Responsável pela jornada

**Status:** Aceita

No MVP, o usuário vinculado à organização recebe as notificações e prepara e envia respostas para os estabelecimentos da organização.

## DEC-009 — Tratamento de falhas

**Status:** Aceita

Quando uma etapa falhar, o Comentaro deve exibir o estado da interação, permitir uma nova tentativa segura e registrar o ocorrido no histórico.

## DEC-010 — Configuração de notificações

**Status:** Aceita

No MVP, a notificação é configurada por estabelecimento como ativa ou silenciada. Ela começa ativa depois da conexão com o iFood. Quando ativa, cada nova avaliação gera um e-mail para o usuário da organização. Quando silenciada, as avaliações continuam sendo capturadas e exibidas, sem aviso externo. WhatsApp fica fora do MVP.

## DEC-011 — Sugestão de resposta por IA

**Status:** Aceita

O MVP deve incluir sugestão de resposta por IA, com prioridade de implementação inferior ao fluxo principal de captura, análise, notificação e resposta. A sugestão deve ser revisável e editável pelo usuário e nunca será publicada automaticamente.

## DEC-012 — Estados independentes

**Status:** Aceita

Processamento, notificação, resposta e sugestão por IA possuem estados separados. Uma falha em uma dessas etapas não deve impedir operações independentes, como responder manualmente quando a análise ou a IA falhar.

## DEC-013 — Recuperação sem duplicidade

**Status:** Aceita

Avaliações não podem ser cadastradas duas vezes. Antes de repetir um envio de resposta após resultado incerto, o sistema consulta o iFood para reconciliar o estado. Notificações só podem ser reenviadas manualmente depois de falha. Toda tentativa integra o histórico.

## DEC-014 — Acesso no MVP

**Status:** Aceita

O MVP terá cadastro e autenticação simples, um usuário por organização e nenhum perfil ou papel de acesso. O usuário acessa todas as unidades, integrações e interações da própria organização e não pode acessar dados de outra organização.

## DEC-015 — Evolução para multitenancy

**Status:** Aceita como diretriz

`Organization` será o limite de isolamento dos dados desde o início. Recursos comerciais futuros, como múltiplos usuários, convites, papéis, planos e cobrança, serão avaliados se o produto for vendido. Eles não fazem parte do MVP.

## DEC-016 — Autenticação do MVP

**Status:** Aceita

O cadastro cria o usuário e a organização na mesma jornada. O acesso usa e-mail e senha, requer confirmação do e-mail, permite recuperação da senha e mantém uma sessão persistente com opção de sair. Provedor, política de senha e duração da sessão serão decisões técnicas posteriores.

## DEC-017 — Módulo de conexões

**Status:** Aceita

Integrações externas serão concentradas no módulo `Connections`. O módulo gerencia o ciclo de vida de `Integration`, contas externas, capacidades, saúde e sincronização. Cada provedor terá um conector próprio, como iFood, aiqfome ou Instagram, sem introduzir conceitos específicos do provedor no domínio central.

## DEC-018 — Modelo de capacidades

**Status:** Aceita

Conectores declaram capacidades como descobrir contas externas, capturar interações, consultar detalhes, publicar resposta e verificar saúde. Um provedor não precisa implementar capacidades que sua API não oferece.

## DEC-019 — Tipo da aplicação iFood

**Status:** Aceita

O Comentaro será integrado ao iFood como aplicação centralizada SaaS. Credenciais e tokens pertencem à aplicação Comentaro e ficam somente no servidor. A autorização de cada loja é representada separadamente pela associação entre a organização, a unidade e o `merchantId` autorizado.

## DEC-020 — Autorização de loja iFood

**Status:** Aceita

No fluxo centralizado, o acesso é solicitado no Portal do Desenvolvedor do iFood por ID ou CNPJ e aprovado pelo responsável no Portal do Parceiro. Depois da aprovação, o Comentaro obtém novo token, confirma a permissão pela listagem de lojas e associa o `merchantId` à unidade correta.
