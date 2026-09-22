# Instruções para agentes

- Leia a visão, o escopo, as decisões, as jornadas e o modelo de domínio antes de propor código.
- Preserve as decisões registradas. Não transforme hipóteses ou pendências em requisitos confirmados sem validação do responsável pelo produto.
- Não implemente aplicação, escolha stack ou contrate serviços apenas com base nesta documentação inicial.
- Mantenha `Interaction` como conceito central e a hierarquia `Organization > Location > Integration > Interaction`. O domínio não deve depender de conceitos exclusivos de restaurantes.
- Limite o MVP a interações diretamente associadas aos canais conectados. Menções públicas externas pertencem à visão futura.
- Casos críticos exigem revisão humana antes da publicação de resposta; não presuma automação de resposta para esses casos.
- Registre novas decisões de produto em `docs/02-discovery/decisions.md` e decisões de arquitetura em `docs/05-architecture/adr/` quando forem tomadas.
- Trabalhe em mudanças pequenas e verificáveis. Antes de implementar uma funcionalidade futura, confirme seus critérios e a viabilidade do canal envolvido.
