import mysqlp from 'promise-mysql'

export const promiseConnect = () => {
  return mysqlp.createConnection({
    connectionLimit: 10,
    host: 'localhost',
    user: 'root',
    password: 'example',
    database: 'biblioteka',
  })
}
