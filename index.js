import express from 'express'
import bodyParser from 'body-parser'
import { engine } from 'express-handlebars'
import router from './router/index.js'

import path from 'path'
import { fileURLToPath } from 'url'
const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const app = express()
const PORT = process.env.PORT || 3000
app.use(bodyParser.json())
app.use(bodyParser.urlencoded())
app.engine(
  'handlebars',
  engine({
    partialsDir: __dirname + '/views/partials',
  })
)
app.set('view engine', 'handlebars')
app.set('views', './views')

app.use('/', router)

app.use(express.static('static'))

app.listen(PORT, () => {
  console.log(`server started on ${PORT}`)
})
