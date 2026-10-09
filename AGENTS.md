# Instruções para agentes

- Leia a visão, o escopo, as decisões, as jornadas, as regras de negócio e o modelo de domínio antes de propor código.
- Preserve as decisões registradas. Não transforme hipóteses ou pendências em requisitos confirmados sem validação do responsável pelo produto.
- Não implemente aplicação, escolha stack ou contrate serviços apenas com base nesta documentação inicial.
- Organize a aplicação como monólito modular: primeiro por módulo de negócio e, dentro de cada módulo, por camada.
- Mantenha domínio, casos de uso e adaptadores com responsabilidades explícitas. Dependências devem apontar para o núcleo do módulo.
- Não crie interfaces, objetos de transferência, mapeadores ou camadas sem uma necessidade concreta. Aplique a separação suficiente para proteger regras de negócio e limites externos.
- Um módulo não acessa diretamente repositórios, tabelas internas ou adaptadores de outro módulo. Integrações entre módulos usam contratos de aplicação ou eventos explicitamente definidos.
- Mantenha `Interaction` como conceito central e a hierarquia `Organization > Location > Integration > Interaction`. O domínio não deve depender de conceitos exclusivos de restaurantes.
- Implemente integrações externas por meio do módulo `Connections`, com um conector por provedor e capacidades explícitas. Não espalhe detalhes do iFood pelo domínio central.
- Credenciais e tokens de provedores permanecem no servidor. Nunca exponha segredos ou tokens ao navegador e nunca use um identificador externo sem validar sua associação à organização autenticada.
- Limite o MVP a avaliações do iFood associadas às integrações conectadas. Menções públicas externas pertencem à visão futura.
- Não implemente classificação ou tratamento especial de casos críticos enquanto não existirem exemplos reais e uma regra aprovada.
- Registre novas decisões de produto em `docs/02-discovery/decisions.md` e decisões de arquitetura em `docs/05-architecture/adr/` quando forem tomadas.
- Trabalhe em mudanças pequenas e verificáveis. Antes de implementar uma funcionalidade futura, confirme seus critérios e a viabilidade do canal envolvido.
