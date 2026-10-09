# Arquitetura — estado inicial

O Comentaro será um monólito modular. A aplicação terá uma única unidade de implantação, dividida internamente por módulos de negócio com limites explícitos e camadas pragmáticas.

## Forma e camadas

Cada módulo separa domínio, aplicação e adaptadores na medida necessária para proteger regras e dependências externas. A direção das dependências aponta para o núcleo do módulo. Não será aplicada uma versão cerimonial de Clean Architecture com abstrações sem uso concreto.

Módulos se comunicam por contratos públicos de aplicação ou eventos explícitos. Um módulo não acessa diretamente repositórios, tabelas internas ou adaptadores de outro.

Consulte [modular-monolith.md](modular-monolith.md) e [ADR-001](adr/001-modular-monolith.md).

## Diretriz de isolamento

`Organization` é o limite de acesso aos dados desde o MVP. Toda operação autenticada deve derivar a organização do usuário autenticado e restringir consultas e alterações a ela. A estratégia técnica será definida na arquitetura.

## Diretriz de integrações

O módulo `Connections` gerencia integrações e expõe capacidades independentes do provedor. Cada provedor possui um conector. Credenciais da aplicação e tokens permanecem no servidor; associações de contas externas pertencem às organizações e unidades autorizadas.

## Diretriz de sincronização

Sincronizações são trabalhos retomáveis e idempotentes por integração. O progresso só avança depois da persistência, e uma falha em uma loja não bloqueia outras. A solução deve oferecer agendamento, execução durável, retentativas controladas e observabilidade.

Um banco relacional é suficiente como fonte de verdade do MVP. Fila ou mecanismo equivalente será avaliado no desenho técnico. Banco vetorial não faz parte desta responsabilidade.

Consulte [integrations.md](integrations.md) para o desenho conceitual e as restrições verificadas do iFood.

## Decisões pendentes

- Linguagem, frameworks e organização física do código.
- Persistência e hospedagem.
- Provedor e mecanismo de autenticação e recuperação de acesso.
- Estratégia técnica de isolamento e testes contra acesso entre organizações.
- Tecnologia de jobs, fila e observabilidade e políticas exatas de retentativa.
- Provedores de IA e e-mail.

Decisões técnicas futuras devem ser justificadas e registradas em `adr/` antes de guiar a implementação.
