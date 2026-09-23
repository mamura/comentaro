# Planejamento inicial

## Dependências externas

1. Criar e configurar a aplicação de teste no Portal do Desenvolvedor iFood.
2. Habilitar e testar os módulos Authentication, Merchant e Review.
3. Implementar e validar o fluxo com a loja de teste.
4. Submeter a aplicação à homologação antes do acesso de produção.

## Prioridade 1 — Fluxo principal do MVP

1. Cadastrar usuário e organização, confirmar o e-mail, autenticar, recuperar senha e encerrar sessão.
2. Cadastrar um estabelecimento.
3. Iniciar, acompanhar e ativar sua conexão com o iFood.
4. Importar até 100 avaliações dos 30 dias anteriores sem notificações históricas.
5. Sincronizar periodicamente, com padrão de uma hora e frequência configurável.
6. Classificar prioridade pela nota.
7. Inferir satisfação e confiança a partir do comentário.
8. Exibir a caixa de entrada, o detalhe e os estados independentes da interação.
9. Enviar e-mail ao usuário e permitir silenciar a notificação por estabelecimento.
10. Permitir resposta manual e envio ao iFood.
11. Exibir falhas, manter histórico, reconciliar resultados incertos e oferecer nova tentativa segura.

## Prioridade 2 — Complemento do MVP

12. Gerar sugestão de resposta por IA.
13. Permitir revisão e edição da sugestão antes do envio.

## Antes da implementação

- Escolher provedor de autenticação e definir política de senha e duração da sessão.
- Definir opções de frequência, margem de sobreposição e política de retentativa.
- Definir provedores de e-mail e IA.
- Definir a arquitetura técnica e registrar suas decisões.
- Escrever critérios de aceite das primeiras histórias.

O ordenamento expressa prioridade relativa, não compromisso de prazo.
