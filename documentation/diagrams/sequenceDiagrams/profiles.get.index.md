# Profiles.get.index

```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
  client->>+server: GET /profiles
  server->>server: преобразование квери параметров
  server->>+db: sql-запрос
  db-->>-server: данные о профилях
  server->>server: формирование html-страницы
  server-->>-client: html-страница
```

[Diagrams](../Diagrams.md)