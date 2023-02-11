## interfaces

```typescript
interface IBook {
	id: number
	title: string
	author: string
	description: string
	reserved: 
}

interface IReserve {
	id: number
	profileCard: hasOne(IProfileCard)
	book: hasOne(IProfileCard)
	timeout: datetime
	closed: boolean
}

interface IProfileCard {
	id: number
	email: string
	phone: string
	books: hasMany(IReserv)
}
```

## sequinse diagrams

### get book list
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
	client->>+server: get request
	alt have query
		server->>+db: select * books where title like query.title
	else not query
		server->>db: select * books
	end
	db-->>-server: book list
	server-->>-client: book list
```

### get book info
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
	client->>+server: book title or book id
	server->>+db: select * books where title
	db-->>-server: book info
	server->>+db: select * reserves where book id
	db-->>-server: reserves list
	server-->>-client: book info and reserves list
```

### get profileCard
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
	client-)+server: profile id
	server->>+db: select * profiles where id
	db-->>-server: profile info
	server->>+db: select * reserves where userId = id
	db-->>-server: reserves list
	server-->>-client: profile info and reserves list

```

### create profileCard
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
	client-)+server: profile card info
	server->>+db: insert into profiles values profile card info
	db-->>-server: profile card info
	server-->>-client: profile info
```

### reserve book
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db
	client-)+server: reserve_information, profile id
	server->>db: select * reserved where bookId = bookid
	server->>server: available book status
	alt	available
		server->>+db: inserv into reserve value reserve_information
		db->>-server: reserv_info_from_db
		server-)+db: update book set reserved = true where id = bookid
		db->>-server: status ok
		server->>client: reserv_info_from_db
	else not available
		server->>-client: status bad request
	end
```

### get reserve info
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db	
	client->>+server: bookid
	server->>+db: select * reserve where bookId = bookid
	db->>-server: reserve info
	server->>-client: reserve info
```

### cancel reserve
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db	
	client->>+server: bookid
	server->>+db: update reserve set cancel=true where bookId = bookid and cancel = false
	db->>-server: status
	server->>-client: status

```

### create new book
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db	
	client->>+server: book_info
	server->>+db: insert into book values book_info
	db->>-server: book_info_from_db
	server->>-client: book_info_from_db
```

### delete book
```mermaid
sequenceDiagram;
	participant client
	participant server
	participant db	
	client->>+server: bookid
	server->>+db: delete from books where bookId = bookid
	db->>-server: status
	server->>-client: status
```