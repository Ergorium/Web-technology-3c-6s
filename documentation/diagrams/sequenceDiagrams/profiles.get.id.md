# Profiles.get.id

```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
	client->>+server: GET /:id
  alt сотрудник авторизирован
    server->>+db: sql-запрос профилей по id
    db-->>-server: список найденных профилей
    server->>+db: sql-запрос на получение связанных резервов книг
    db-->>-server: список резервов
    server->>server: генерация единого объекта профиля
    server->>server: Генерация html-страницы
    server-->>client: html-страница
  else
    server-->>-client: html-страница с ошибкой авторизации
  end
  
```

[Diagrams](../Diagrams.md)