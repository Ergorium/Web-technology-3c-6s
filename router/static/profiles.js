import express from 'express'
import { promiseConnect } from '../../db/connector.js'
const router = express.Router()
import overdueHelper from '../helpers/overdueHelpers.js'

router.get('/', async (req, res) => {
  const connect = await promiseConnect()
  let elems = []
  if (Object.keys(req.query).length > 0) {
    const where = queryConvert(req.query)
    elems = await connect.query(`SELECT * FROM profiles WHERE ${where}`)
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
  })
})

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
      `select *, b.title as title from reserves as r left join books as b on r.bookId = b.id where r.profileId = ${profile.id}`
    )
  )
  res.render('profileInfo', {
    profile,
  })
})

export default router
