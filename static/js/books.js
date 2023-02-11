function init() {
  class BookList {
    constructor(bookListTag, indicatorTag) {
      this.bookListTag = document.querySelector(bookListTag)
      this.indicatorTag = document.querySelector(indicatorTag)
      this.controllBlock = document.querySelector('#controll-block')
      this.modal = document.querySelector('#view-modal')
    }

    async requestBookList() {
      this.renderIndicator(true)
      try {
        const res = await fetch('/api/books')
        const elems = await res.json()
        this.renderBookList(elems)
      } catch (err) {
        console.error(err)
      } finally {
        this.renderIndicator(false)
      }
    }
    async requestNewBook(body) {
      try {
        const res = await fetch('/api/books', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(body),
        })
        this.requestBookList()
        return Promise.resolve()
      } catch (err) {
        console.error(err)
        return Promise.reject()
      }
    }
    async requestDeleteBook(id) {
      try {
        const res = await fetch(`/api/books/${id}`, {
          method: 'DELETE',
        })
        return Promise.resolve()
      } catch (err) {
        console.error(err)
        return Promise.reject()
      }
    }
    async requestBookInfo(id) {
      try {
        const res = await fetch(`/api/books/${id}`)
        const elem = await res.json()
        return Promise.resolve(elem)
      } catch (err) {
        console.error(err)
        return Promise.reject()
      }
    }
    async requestCancelReserve(id) {
      try {
        const res = await fetch(`/api/books/${id}`, {
          method: 'PATCH',
        })
        return Promise.resolve()
      } catch (err) {
        console.error(err)
        return Promise.reject()
      }
    }

    renderNewBookModal() {
      const elem = document.createElement('div')
      const html = `
      <div class="modal fixed left-0 right-0 top-0 bottom-0 bg-stone-600 bg-opacity-60 flex justify-center items-center">
        <form id="modal-form" class="modal-content min-w-[350px] bg-stone-700 rounded-md relative">
          <div class="modal-cancel absolute right-4 top-2 text-3xl cursor-pointer opacity-70 hover:opacity-100 transition-all active:scale-95 select-none">x</div>
          <div class="modal--header p-4 select-none">Резерв книги</div>
          <div class="modal--main p-4">
            <label for="name" class="block mb-4">
              <p>Название книги</p>
              <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="name" name="title" required>
            </label>
            <label for="author" class="block mb-4">
              <p>Автор</p>
              <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="author" name="author" required>
            </label>
            <label for="description">
              <p>Описание</p>
              <textarea name="description" id="description" cols="30" rows="5" class="w-full bg-stone-500"></textarea>
            </label>
            <label for="img_url">
              <p>Ссылка на обложку</p>
              <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" name="img_url" id="img_url">
            </label>
            
          </div>
          <div class="modal--footer p-4 flex justify-end items-center">
            <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2">Ok</button>
            <button class="modal-cancel p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md">Cancel</button>
          </div>
        </form>
      </div>
      `
      elem.innerHTML = html
      const close = () => {
        elem
          .querySelectorAll('.modal-cancel')
          .forEach((item) => item?.removeEventListener('click', close))
        elem
          .querySelector('#modal-form')
          ?.removeEventListener('submit', onSubmit)
        this.modal.innerHTML = ''
      }
      elem
        .querySelectorAll('.modal-cancel')
        .forEach((item) => item?.addEventListener('click', close))
      const onSubmit = (e) => {
        e?.preventDefault()
        const form = e?.target
        if (!form) return
        const book = {
          title: form.title.value,
          author: form.author.value,
          description: form.description.value,
          img_url: form.img_url.value,
        }
        this.requestNewBook(book).then(() => {
          close()
        })
      }
      elem.querySelector('#modal-form')?.addEventListener('submit', onSubmit)

      this.modal.appendChild(elem)
    }
    async renderBookInfoModal(id) {
      const item = await this.requestBookInfo(id)
      const elem = document.createElement('div')
      let r = `
        <div class="modal fixed left-0 right-0 top-0 bottom-0 bg-stone-600 bg-opacity-60 flex justify-center items-center">
          <div id="modal-form" class="modal-content min-w-[350px] bg-stone-700 rounded-md relative max-w-[90%]">
            <div class="modal-cancel absolute right-4 top-2 text-3xl cursor-pointer opacity-70 hover:opacity-100 transition-all active:scale-95 select-none">x</div>
            <div class="modal--header p-4 select-none">${item?.title}</div>
            <div class="modal--main p-4">
                <p><span class="font-bold">Название книги:</span> ${item?.title}</p>
                <p><span class="font-bold">Автор:</span> ${item?.author}</p>
                <p><span class="font-bold">Описание:</span> <p>${item?.description}</p></p>
                <img src="${item?.img_url}" alt="logo" class="max-w-[60px]">
      `
      r += item?.reserved ? '<p>Книга зарезервирована</p>' : ''
      r += `
            </div>
            <div class="modal--footer p-4 flex justify-end items-center">
              <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2" type="submit">Резерв</button>
              <button id="modal-reserve" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2">Снять резерв</button>
              <button id="modal-delete" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2">Удалить</button>
              <button class="modal-cancel p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md">Закрыт</button>
            </div>
          </div>
        </div>
      `
      elem.innerHTML = r
      const deleteBook = async () => {
        this.requestDeleteBook(id).then(() => {
          close()
          this.requestBookList()
        })
      }
      const cancelReserve = async () => {
        this.requestCancelReserve(id).then(() => {
          close()
          this.requestBookList()
          this.renderBookInfoModal(id)
        })
      }
      const close = () => {
        elem
          .querySelectorAll('.modal-cancel')
          .forEach((item) => item?.removeEventListener('click', close))
        elem
          .querySelector('#modal-delete')
          .removeEventListener('click', deleteBook)
        elem
          .querySelector('#modal-reserve')
          .removeEventListener('click', cancelReserve)
        this.modal.innerHTML = ''
      }
      elem
        .querySelectorAll('.modal-cancel')
        .forEach((item) => item?.addEventListener('click', close))
      elem.querySelector('#modal-delete').addEventListener('click', deleteBook)
      elem
        .querySelector('#modal-reserve')
        .addEventListener('click', cancelReserve)
      this.modal.appendChild(elem)
    }
    renderIndicator(status) {
      const html = `
        <div class="text-4xl">Loading...</div>
      `
      if (status) {
        this.bookListTag.innerHTML = ''
        this.indicatorTag.innerHTML = html
      } else {
        this.indicatorTag.innerHTML = ''
      }
    }
    renderBookList(value) {
      this.bookListTag.innerHTML = ''
      const elem = document.createElement('div')
      elem.innerHTML = value
        .map((item) => {
          return `
        <div class="card flex mb-4">
          <div class="card--icon">
            <img src="${
              item?.img_url || 'assets/2379396.svg'
            }" class="max-w-[80px] mr-2" alt="Logo">
          </div>
          <div class="card--main">
            <h3 class="card--header text-3xl text-amber-200 book-modal cursor-pointer" book-id="${
              item.id
            }">${item.title}</h3>
            <h5 class="card--header text-2xl text-amber-200">${item.author}</h5>
            <p class="card--description">${item.description}</p>
          </div>
        </div>
        `
        })
        .join('')
      elem.querySelectorAll('.book-modal').forEach((item) => {
        item.addEventListener('click', () => {
          this.renderBookInfoModal(item.getAttribute('book-id'))
        })
      })
      this.bookListTag.appendChild(elem)
    }
    renderCreateBookButton() {
      const elem = document.createElement('button')
      elem.classList =
        'px-2 py-1 bg-stone-600 rounded active:scale-95 transition-all'
      elem.innerHTML = 'Новая книга'
      elem.addEventListener('click', () => {
        this.renderNewBookModal()
      })
      this.controllBlock.appendChild(elem)
    }
  }

  const bookList = new BookList('#bookList', '#indicator')
  bookList.requestBookList()
  bookList.renderCreateBookButton()
}
window.addEventListener('DOMContentLoaded', init)
