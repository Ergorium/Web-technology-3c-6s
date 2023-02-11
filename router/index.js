import express from 'express'
import path from 'path'
import { fileURLToPath } from 'url'
import { promiseConnect } from '../db/connector.js'

import bookRouter from './book.js'
import profilesRouter from './profiles.js'
import reservesRouter from './reserves.js'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const router = express.Router()
router.get('/', async (_, res) => {
  const connect = await promiseConnect()
  const books = await connect.query(
    'select *, b.id, r.profileId from books as b left join reserves as r on r.bookId = b.id and r.canceled = false'
  )
  res.render('bookList', {
    books,
  })
})
router.use('/books', bookRouter)
router.use('/profiles', profilesRouter)
router.use('/reserves', reservesRouter)
router.get('*', (_, res) => {
  res.render('404')
})

export default router
