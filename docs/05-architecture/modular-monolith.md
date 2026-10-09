# Monólito modular

## Forma da aplicação

O backend do Comentaro será uma única aplicação implantável, organizada em módulos de negócio com limites explícitos. Os módulos compartilham o processo e podem compartilhar a infraestrutura física, mas não compartilham livremente suas implementações internas.

O frontend é uma aplicação independente e acessa o backend somente pela API publicada. A separação entre as aplicações e a stack estão registradas no [ADR-002](adr/002-technology-stack-and-application-boundaries.md).

Os limites iniciais esperados são:

- identidade e acesso;
- organizações e estabelecimentos;
- conexões externas;
- interações;
- notificações;
- assistência por IA.

Os nomes e recortes podem ser refinados com o modelo de domínio. Criar novos módulos exige uma responsabilidade de negócio clara.

## Organização interna de um módulo

Cada módulo adota somente as camadas necessárias entre estas responsabilidades:

```text
module
├── domain
│   ├── entities and value objects
│   ├── business policies
│   └── domain events
├── application
│   ├── use cases
│   ├── input and output contracts
│   └── transaction coordination
└── adapters
    ├── inbound: HTTP, jobs and event handlers
    └── outbound: persistence, providers and messaging
```

Essa árvore é conceitual. A stack escolhida poderá usar nomes equivalentes, desde que preserve as responsabilidades e a direção das dependências.

## Direção das dependências

- O domínio não depende de framework, banco, transporte HTTP ou SDK externo.
- A aplicação coordena casos de uso e depende do domínio e de contratos necessários.
- Adaptadores implementam contratos e traduzem detalhes externos.
- Entradas chamam casos de uso; não concentram regras de negócio.
- Persistência não define o modelo do domínio apenas por conveniência do banco.

## Limites entre módulos

- Cada módulo é responsável por suas regras e dados.
- Um módulo não acessa diretamente repositórios ou adaptadores internos de outro.
- Comunicação síncrona usa contratos públicos da camada de aplicação.
- Comunicação assíncrona usa eventos explícitos quando houver benefício concreto.
- Escritas que atravessam módulos devem ocorrer por caso de uso do módulo proprietário.
- Um núcleo compartilhado deve ser pequeno e conter apenas conceitos realmente comuns e estáveis.

## Aplicação pragmática

O projeto não pretende reproduzir integralmente uma implementação acadêmica de Clean Architecture.

- Criar abstrações apenas em fronteiras reais ou quando houver substituição, isolamento ou teste relevante.
- Evitar interfaces com uma única implementação quando elas não protegem uma dependência externa ou um limite arquitetural.
- Evitar camadas que apenas repassam dados sem validação, coordenação ou tradução.
- Manter nomes claros, funções coesas e regras próximas do conceito que representam.
- Preferir código direto quando a complexidade adicional não protege o domínio.
- Testar regras e contratos relevantes; não duplicar a implementação em testes sem valor comportamental.

## Persistência e implantação

Uma única implantação e um banco físico compartilhado são compatíveis com esta decisão. A propriedade lógica dos dados continua pertencendo aos módulos. Estratégia de schemas, migrações e aplicação automática dos limites será definida depois da escolha da stack.

## Evolução

Os limites permitem extrair um módulo no futuro caso escala, operação ou autonomia de equipe justifiquem. A possibilidade de extração não é motivo para introduzir comunicação distribuída no MVP.
