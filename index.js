import express from 'express'
import bodyParser from 'body-parser'
import { create } from 'express-handlebars'
import router from './router/index.js'

import path from 'path'
import { fileURLToPath } from 'url'
const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

const app = express()
const PORT = process.env.PORT || 3000
const hsb = create({
  helpers: {
    eq: function (arg1, arg2, options) {
      return arg1 == arg2 ? options.fn(this) : options.inverse(this)
    },
    json: function (i) {
      return `<pre>${JSON.stringify(i)}</pre>`
    },
  },
  partialsDir: __dirname + '/views/partials',
})
app.use(bodyParser.json())
app.use(bodyParser.urlencoded())
app.engine('handlebars', hsb.engine)
app.set('view engine', 'handlebars')
app.set('views', './views')

app.use(express.static('static'))
app.use('/', router)

app.listen(PORT, () => {
  console.log(`server started on ${PORT}`)
})
