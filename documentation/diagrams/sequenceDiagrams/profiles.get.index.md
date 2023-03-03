# Profiles.get.index

```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
  client->>+server: GET /profiles
  alt сотрудник авторизирован
    server->>server: преобразование квери параметров
    server->>+db: sql-запрос
    db-->>-server: данные о профилях
    server->>server: формирование html-страницы
    server-->>client: html-страница

  else
    server-->>-client: html-страница с ошибкой авторизации
  end
```

[Diagrams](../Diagrams.md)