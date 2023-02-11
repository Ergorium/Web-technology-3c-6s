import express from 'express'
import path from 'path'
import { fileURLToPath } from 'url'

import bookRouter from '../router/api/book.js'
import profileRouter from '../router/api/profile.js'
import reserveRouter from '../router/api/reserve.js'

import staticRouter from './static/index.js'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const router = express.Router()
router.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, '../static/index.html'))
})
router.use('/static', staticRouter)
router.get('/admin', (_, res) => {
  res.sendFile(path.join(__dirname, 'static/admin.html'))
})

router.use('/api/books', bookRouter)
router.use('/api/profiles', profileRouter)
router.use('/api/reserves', reserveRouter)

export default router
