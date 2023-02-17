import express from 'express'
import path from 'path'
import { fileURLToPath } from 'url'
import { promiseConnect } from '../db/connector.js'
import queryConvert from './helpers/queryConvert.js'

import bookRouter from './book.js'
import profilesRouter from './profiles.js'
import reservesRouter from './reserves.js'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const router = express.Router()
router.get('/', async (req, res) => {
  const connect = await promiseConnect()
  let books = []
  const where = queryConvert(req.query)
  console.log(where)
  books = await connect.query(
    'select *, b.id, r.profileId from books as b left join reserves as r on r.bookId = b.id and r.canceled = false ' +
      where
  )

  res.render('bookList', {
    books,
    searcherConfig: {
      address: '/',
      defaultSelect: 'title',
      types: ['title', 'author'],
      customFields: [
        `
        <style>
          .search-checkbox:checked+* {
            display: inline
          }
          .search-checkbox+* {
            display: none
          }
        </style>`,
        `<label for="overdue" class="search-checkbox cursor-pointer bg-stone-600 px-2 py-1">
            <span>Просрочено</span>
            <input type="checkbox" id="overdue" name="overdue" class="search-checkbox hidden">
            <i class="fa-solid fa-check-double"></i>
        </label>
        `,
        ` <label for="reserved" class="search-checkbox cursor-pointer bg-stone-600 px-2 py-1">
          <span>В резерве</span>
          <input type="checkbox" id="reserved" name="reserved" class="search-checkbox hidden">
          <i class="fa-solid fa-check-double"></i>
        </label>`,
      ],
    },
  })
})
router.use('/books', bookRouter)
router.use('/profiles', profilesRouter)
router.use('/reserves', reservesRouter)
router.get('*', (_, res) => {
  res.render('404')
})

export default router
