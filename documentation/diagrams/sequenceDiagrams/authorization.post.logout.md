# Authoriztion.get.index

```mermaid
sequenceDiagram;
	participant client
	participant server
  client->>+server: POST /authorization/logout
  alt сотрудник авторизирован
    server->>server: Очистка сессии
    server-->>client: redirect /
  else
    server-->>-client: redirect /authorization
  end
```

[diagrams](../Diagrams.md)