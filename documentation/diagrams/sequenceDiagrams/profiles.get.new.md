# Profiles.get.new

```mermaid
sequenceDiagram;
	participant client
	participant server
	client->>+server: GET /book/new
	server->>server: Генерирует html-страницу
	server-->>-client: html-страница
```

[Diagrams](../Diagrams.md)