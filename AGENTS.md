# Instruções para agentes

- Leia a visão, o escopo, as decisões, as jornadas, as regras de negócio e o modelo de domínio antes de propor código.
- Preserve as decisões registradas. Não transforme hipóteses ou pendências em requisitos confirmados sem validação do responsável pelo produto.
- Não implemente aplicação, escolha stack ou contrate serviços apenas com base nesta documentação inicial.
- Mantenha `Interaction` como conceito central e a hierarquia `Organization > Location > Integration > Interaction`. O domínio não deve depender de conceitos exclusivos de restaurantes.
- Limite o MVP a avaliações do iFood associadas às integrações conectadas. Menções públicas externas pertencem à visão futura.
- Não implemente classificação ou tratamento especial de casos críticos enquanto não existirem exemplos reais e uma regra aprovada.
- Registre novas decisões de produto em `docs/02-discovery/decisions.md` e decisões de arquitetura em `docs/05-architecture/adr/` quando forem tomadas.
- Trabalhe em mudanças pequenas e verificáveis. Antes de implementar uma funcionalidade futura, confirme seus critérios e a viabilidade do canal envolvido.
