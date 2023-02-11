import express from 'express'
import { body, validationResult } from 'express-validator'
import { promiseConnect } from '../../db/connector.js'
const router = express.Router()

router.get('/new', (_, res) => {
  res.render('bookNew')
})
router.post(
  '/new',
  body('title').isLength({ min: 5 }),
  body('author').isLength({ min: 4 }),
  body('description').isLength({ min: 20 }),
  body('img_url').isLength({ min: 10 }),
  async (req, res) => {
    const connect = await promiseConnect()
    const errors = validationResult(req)
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() })
    }
    const r = await connect.query(
      `insert into books(title, author, description, img_url) values ('${req.body.title}', '${req.body.author}', "${req.body.description}", '${req.body.img_url}')`
    )
    res.redirect('/static/books/' + r.insertId)
  }
)

router.get('/:id', async (req, res) => {
  const connect = await promiseConnect()
  const books = await connect.query(
    `select *, b.id, r.profileId from books as b left join reserves as r on r.bookId = b.id where b.id = ${req.params.id}`
  )(books)
  res.render('bookInfo', {
    book: books[0],
  })
})

export default router
