import express from 'express'
const router = express.Router()
import { promiseConnect } from '../../db/connector.js'
import queryConvert from '../helpers/queryConvert.js'

router.get('/', async (req, res) => {
  const connect = await promiseConnect()
  let elems = []
  if (Object.keys(req.query).length > 0) {
    const where = queryConvert(req.query)
    elems = await connect.query(`SELECT * FROM books ${where}`)
  } else {
    elems = await connect.query('select * from books')
  }
  res.json(elems)
})

router.get('/:id', async (req, res) => {
  const connect = await promiseConnect()
  const books = await connect.query(
    `select * from books where id = ${req.params.id}`
  )
  if (books.length === 0 || books.length > 1) {
    return res.sendStatus(404)
  }
  const book = books[0]
  book.reserve = await connect.query(
    `select * from reserves where bookId = ${req.params.id}`
  )
  res.json(book)
})

router.post('/', async (req, res) => {
  const connect = await promiseConnect()
  const book = req.body
  const elem = await connect.query(
    `insert into books(title, author, description, img_url) values ('${book.title}', '${book.author}', '${book.description}', '${book.img_url}')`
  )
  res.json({
    id: elem.insertId,
  })
})

router.patch('/:id', async (req, res) => {
  const connect = await promiseConnect()
  try {
    await connect.query(
      `update books set reserved = false where id = ${req.params.id}`
    )
    await connect.query(
      `update reserves set canceled = true where bookId = ${req.params.id}`
    )
    res.sendStatus(204)
  } catch (err) {
    console.error(err)
    res.sendStatus(500)
  }
})

router.delete('/:id', async (req, res) => {
  const id = req.params.id
  const connect = await promiseConnect()
  const elem = await connect.query(`delete from books where id = ${id}`)
  if (elem.affectedRows === 0) {
    return res.sendStatus(404)
  }
  res.status(204).send(elem)
})

export default router
