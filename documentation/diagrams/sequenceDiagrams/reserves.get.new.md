# Reserves.get.new

```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
  client->>+server: GET /reserves/new
  server->>server: Генерация html-страницы
  server-->>-client: HTML-страница
```

[diagrams](../Diagrams.md)