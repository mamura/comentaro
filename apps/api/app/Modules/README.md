# Módulos do backend

O backend é organizado primeiro por capacidade de negócio. Cada módulo introduz apenas as camadas necessárias para proteger regras e fronteiras externas.

Limites iniciais previstos:

- Identity;
- Organizations;
- Connections;
- Interactions;
- Notifications;
- AiAssistance.

Estrutura conceitual:

```text
Module/
├── Domain/
├── Application/
└── Infrastructure/
    ├── Inbound/
    └── Outbound/
```

Módulos não acessam diretamente repositórios ou implementações internas de outros módulos. Consulte os ADRs antes de criar um novo limite.
