# Reserves.post.new

```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
  client->>+server: POST /reserves/new, body: reservData
  alt сотрудник авторизирован
    server->>db: START TRANSACTION
    server->>+db: sql-запрос с информацией о резерве
    db-->>-server: статус запроса
    server->>+db: sql-запрос на изменение статуса резерва книги
    db-->>-server: статус запросаw
    alt Статус выполнения ОК
      server-->>db: COMMIT
      server-->>client: redirect /books/id
    else
      server-->>db: ROLLBACK
      server-->>client: html-страница с информацией об ошибке
    end
  else
    server-->>-client: html-страница с ошибкой авторизации
  end
  ```

[diagrams](../Diagrams.md)