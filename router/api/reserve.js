import express from 'express'
import { promiseConnect } from '../../db/connector.js'
import queryConvert from '../helpers/queryConvert.js'
import overdueHelper from '../helpers/overdueHelpers.js'
const router = express.Router()

router.get('/', async (req, res) => {
  const connect = await promiseConnect()
  let elems = []
  if (Object.keys(req.query).length > 0) {
    let where = ''
    where = queryConvert(req.query)
    elems = await connect.query(`select * from reserves ${where}`)
    if (elems.length === 0) {
      return res.sendStatus(404)
    }
  } else {
    elems = await connect.query('select * from reserves')
  }
  res.json(overdueHelper(elems))
})

router.post('/', async (req, res) => {
  const connect = await promiseConnect()
  const reserve = req.body
  try {
    const elem = await connect.query(
      `insert into reserves(bookId, profileId, timeout, created_at) values (${
        reserve.bookId
      }, ${reserve.profileId}, '${new Date(reserve.timeout)
        .toISOString()
        .slice(0, 10)}', '${new Date().toISOString().slice(0, 10)}')`
    )
    await connect.query(
      `update books set reserved = true where id = ${reserve.bookId}`
    )
    res.json(elem)
  } catch (err) {
    console.error(err)
    res.sendStatus(500)
  }
})

router.patch('/:id', async (req, res) => {
  const connect = await promiseConnect()
  const elems = await connect.query(
    `update reserves set canceled = true where id = ${req.params.id}`
  )
  await connect.query(
    `update books set reserved = false where id = ${req.params.id}`
  )
  res.sendStatus(204)
})

export default router
