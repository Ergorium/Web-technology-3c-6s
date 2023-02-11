import express from 'express'
const router = express.Router()
import { promiseConnect } from '../../db/connector.js'
import queryConvert from '../helpers/queryConvert.js'

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
    elems = await connect.query('select * from profiles')
  }
  res.json(elems)
})

router.post('/', async (req, res) => {
  const connect = await promiseConnect()
  const profile = req.body
  const elem = await connect.query(
    `insert into profiles(name, email, phone) values ('${profile.name}', '${profile.email}', '${profile.phone}')`
  )
  res.json(elem)
})

router.delete('/:id', async (req, res) => {
  const connect = await promiseConnect()
  const profile = await connect.query(
    `delete from profiles where id = ${req.params.id}`
  )
  if (profile.affectedRows === 0) {
    return res.sendStatus(404)
  }

  res.json(profile)
})

export default router
