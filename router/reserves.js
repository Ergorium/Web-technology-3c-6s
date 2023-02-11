import express from 'express'
import { body, validationResult } from 'express-validator'
import { promiseConnect } from '../db/connector.js'
const router = express.Router()

router.get('/new', (_, res) => {
  res.render('reserveNew', {
    bookid: _.query.bookId,
  })
})

router.post(
  '/new',
  body('profileId'),
  body('bookId'),
  body('timeout'),
  async (req, res) => {
    const connect = await promiseConnect()
    const errors = validationResult(req)
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() })
    }
    try {
      await connect.query('start transaction')
      const r = await connect.query(
        `insert into reserves(bookId, profileId, timeout, created_at) values (${
          req.body.bookId
        }, ${req.body.profileId}, '${new Date(req.body.timeout)
          .toISOString()
          .slice(0, 10)}', '${new Date().toISOString().slice(0, 10)}')`
      )
      await connect.query(
        `update books set reserved = true where id = ${req.body.bookId}`
      )
      await connect.query('commit')
      res.redirect('/books/' + req.body.bookId)
    } catch (err) {
      console.error(err)
      await connect.query('rollback')
      res.status(500).render('500')
    }
  }
)

export default router
