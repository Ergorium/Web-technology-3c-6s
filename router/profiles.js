import express from 'express'
import { promiseConnect } from '../db/connector.js'
import queryConvert from './helpers/queryConvert.js '
const router = express.Router()
import overdueHelper from './helpers/overdueHelpers.js'
import { body, validationResult } from 'express-validator'

router.get('/', async (req, res) => {
  const connect = await promiseConnect()
  let elems = []
  if (Object.keys(req.query).length > 0) {
    const where = queryConvert(req.query)
    elems = await connect.query(`SELECT * FROM profiles ${where}`)
    if (elems.length === 0) {
      return res.sendStatus(404)
    }
  } else {
    elems = await connect.query(
      'select *, (select count(*) from reserves as r where r.profileId = p.id and canceled = false ) as reserve from profiles as p'
    )
  }
  res.render('profiles', {
    profiles: elems.map((item) => ({
      ...item,
      json: JSON.stringify(item),
    })),
    searcherConfig: {
      address: '/profiles',
      defaultSelect: 'email',
      types: ['email', 'phone', 'name'],
    },
  })
})

router.get('/new', (req, res) => {
  res.render('profileNew')
})

router.post(
  '/new',
  body('email'),
  body('name').isLength({ min: 5 }),
  body('phone').isLength({ min: 11, max: 11 }),
  async (req, res) => {
    const connect = await promiseConnect()
    const errors = validationResult(req)
    if (!errors.isEmpty()) {
      return res.status(404).json({ errors: errors.array() })
    }
    const r = await connect.query(
      `insert into profiles(name, email, phone) values ('${req.body.name}', '${req.body.email}', '${req.body.phone}')`
    )
    res.redirect('/profiles/' + r.insertId)
  }
)

router.get('/:id', async (req, res) => {
  const connect = await promiseConnect()
  const elems = await connect.query(
    `select * from profiles  where id = ${req.params.id}`
  )
  if (elems.length === 0 || elems.length > 1) {
    return res.render('404')
  }
  const profile = elems[0]
  profile.reserve = overdueHelper(
    await connect.query(
      `select *, b.title as title from reserves as r left join books as b on r.bookId = b.id where r.profileId = ${profile.id} order by r.canceled`
    )
  )
  res.render('profileInfo', {
    profile,
  })
})

export default router
