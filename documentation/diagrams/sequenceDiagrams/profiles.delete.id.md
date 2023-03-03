# Profiles.delete.id

```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
  client->>+server: DELETE /profiles/:id
  alt сотрудник авторизирован
    server-->>db: START TRANSACTION
    server->>+db: sql запрос на изменение статуса всех резервов по книгам
    db-->>-server: статус изменения
    server->>+db: sql запрос на удаление информации о профиле
    db-->>-server: статус удаления
    alt Успешное завершение операций
      server->>db: COMMIT
      server-->>client: redirect /profiles
    else
      server->>db: ROLLBACK
      server->>server: генерация html-страницы ошибки  
      server-->>client: html-страница ошибки
    end
  else
    server-->>-client: html-страница с ошибкой авторизации
  end
  ```

[Diagrams](../Diagrams.md)