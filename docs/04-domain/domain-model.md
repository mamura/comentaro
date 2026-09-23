# Modelo de domínio conceitual

```text
Organization
├── User
└── Location
    └── Integration
        ├── ExternalAccount
        ├── SyncCheckpoint
        └── Interaction
            ├── Analysis
            ├── Notification
            ├── Reply
            └── HistoryEntry
```

- **Organization:** negócio acompanhado pelo Comentaro e limite de isolamento dos dados.
- **User:** conta autenticada vinculada a uma organização. No MVP, existe um usuário por organização e não há perfis.
- **Location:** unidade ou estabelecimento da organização, sem pressupor restaurante.
- **Integration:** conexão de uma unidade a um provedor, incluindo estado, capacidades e saúde.
- **ExternalAccount:** identificação autorizada da unidade no provedor; no iFood, inclui o `merchantId`.
- **SyncCheckpoint:** posição confirmada da sincronização, usada para retomada segura e prevenção de perdas.
- **Interaction:** item recebido de um canal conectado. É o conceito central do domínio.
- **Analysis:** prioridade, satisfação inferida, confiança e estado de processamento.
- **Notification:** tentativa de avisar o usuário e seu estado.
- **Reply:** rascunho, sugestão, tentativa de envio e estado da resposta.
- **HistoryEntry:** registro temporal de eventos e tentativas relevantes.

Credenciais globais do aplicativo de um provedor não pertencem à `Organization` nem à `Integration`. São configuração protegida do servidor. Os estados de conexão, processamento, notificação, resposta e sugestão por IA são independentes.

O modelo representa relações conceituais, não tabelas, cardinalidades, APIs ou uma arquitetura implementada.
