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

**Status:** Aceita

O frontend e o backend serão aplicações independentes no mesmo repositório. O backend será um monólito modular em PHP 8.5 e Laravel 13, com API REST JSON, PostgreSQL, Laravel Queue, Laravel Scheduler e Pest. O frontend usará React 19, TypeScript, Vite, React Router, TanStack Query, Tailwind CSS, shadcn/ui e Vitest.

OpenAPI definirá o contrato entre as aplicações. A autenticação web usará Laravel Sanctum com cookies seguros. O ambiente local será coordenado com Docker Compose. Detalhes e consequências estão registrados no ADR-002.

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

O cadastro cria usuário e organização atomicamente e solicita nome, e-mail, senha, confirmação da senha e nome da organização. O acesso usa e-mail e senha. O usuário pode entrar antes de confirmar o e-mail, mas só utiliza as funcionalidades internas depois da confirmação.

A senha tem no mínimo 10 caracteres. Confirmação e recuperação usam links de uso único válidos por 60 minutos. A sessão comum expira depois de duas horas de inatividade, com opção de manter o acesso por até 30 dias. O MVP não inclui autenticação social nem segundo fator.

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

## DEC-021 — Sincronização inicial

**Status:** Aceita

Ao ativar uma integração, o Comentaro importa avaliações dos 30 dias anteriores, limitadas às 100 mais recentes. Avaliações importadas nessa carga inicial não geram notificações. Uma importação histórica adicional poderá ser oferecida futuramente.

## DEC-022 — Frequência de sincronização

**Status:** Aceita

No MVP, todas as integrações sincronizam a cada hora. A configuração de outras frequências e de um eventual menor intervalo será adicionada depois que a aplicação estiver em produção, com base no comportamento observado e nos limites da API.

## DEC-023 — Garantias de sincronização

**Status:** Aceita como diretriz

Falhas ou atrasos não podem criar duplicatas nem avançar o progresso além de dados persistidos. A sincronização retoma do último ponto confirmado com cinco minutos de sobreposição, expõe seu estado e mantém histórico das tentativas.

A fila inicial usa PostgreSQL por meio do Laravel Queue. Jobs possuem responsabilidades separadas, uma integração não executa duas sincronizações simultâneas e efeitos externos são idempotentes. São permitidas até cinco tentativas, com execução imediata e esperas de 1 minuto, 5 minutos, 15 minutos e 1 hora. Erros permanentes exigem ação sem repetir indefinidamente.


## DEC-024 — Provedor de e-mail transacional

**Status:** Aceita

O Resend será o provedor de produção para confirmação de e-mail, recuperação de senha, notificações de novas avaliações e avisos operacionais. O desenvolvimento usa Mailpit e os testes automatizados usam o transporte falso do Laravel. Templates permanecem versionados no backend.

Eventos assinados do provedor distinguem mensagem aceita, entregue, rejeitada, devolvida ou marcada como indesejada. O MVP não rastreia abertura nem clique.
