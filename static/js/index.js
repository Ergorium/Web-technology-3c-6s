;(function () {
  const getBookList = async () => {
    try {
      const res = await fetch('/api/book-list')
      const elems = await res.json()
      renderBookList(elems)
    } catch (err) {
      console.error(error)
    }
  }

  const renderBookList = (value) => {
    const html = value.map((item) => {
      let r = `<div class="card flex mb-4">
      <div class="card--icon">
        <img src="${
          item?.img_url || 'assets/2379396.svg'
        }" class="max-w-[80px] mr-2" alt="Logo">
      </div>
      <div class="card--main">
        <h3 class="card--header text-3xl text-amber-200">${item.title}</h3>
        <h5 class="card--header text-2xl text-amber-200">${item.author}</h5>
        <p class="card--description">${item.description}</p>
      `
      if (!item.reserved) {
        r += `<button class="card-reserve-button text-xl text-amber-200 underline" book-id="${item.id}">Резерв</button>`
      } else {
        r += `<button class="card-reserve-info-button text-xl text-amber-200 underline" book-id="${item.id}">Получить информацию по резерву</button>`
      }
      r += `</div></div>`
      return r
    })
    // Подвязка фильтров по авторам
    const authorFilter = Array.from(
      new Set(value.map((item) => item.author))
    ).map(
      (item) => `
        <option value="${item}">${item}</option>
      `
    )
    authorFilter.splice(0, 0, '<option value="*">Все</option>')
    document.querySelector('#filter-author').innerHTML = authorFilter
    // сброс значения чекбокса
    document.querySelector('#filter-reserved').checked = false
    // Вставка элементов
    document.querySelector('#itemlist').innerHTML = html.join('')
    // Подвязка срабатывания кликов на резерв
    document
      .querySelectorAll('.card-reserve-button')
      .forEach((item) => item.addEventListener('click', onReserveBook))

    document
      .querySelectorAll('.card-reserve-info-button')
      .forEach((item) => item.addEventListener('click', onGetReservInfo))
  }

  const onSearchQuery = async (event) => {
    event.preventDefault()
    try {
      const seachInput = document.querySelector('#search')
      const query = `?book=${seachInput.value}`
      const res = await fetch(`/api/search-book${query}`)
      const elems = await res.json()
      renderBookList(elems)
    } catch (err) {
      console.error('search query', error)
    }
  }

  const onFilterQuery = async (event) => {
    event.preventDefault()
    const form = event.target
    const authorFilter =
      form.authorfilter.value !== '*'
        ? `&author='${form.authorfilter.value}'`
        : ''
    const query = `?reserved=${!!form.reserved.checked}${authorFilter}`
    try {
      const res = await fetch(`/api/filter-book${query}`)
      const elems = await res.json()
      renderBookList(elems)
    } catch (err) {
      console.error('search query', error)
    }
  }

  const onReserveBook = async (event) => {
    event.preventDefault()
    const target = event.target
    const bookId = target.getAttribute('book-id')
    const block = document.querySelector('#view-modal')
    const form = `
    <div class="modal fixed left-0 right-0 top-0 bottom-0 bg-stone-600 bg-opacity-60 flex justify-center items-center">
      <form id="modal-form" class="modal-content min-w-[350px] bg-stone-700 rounded-md relative">
        <div class="modal-cancel absolute right-4 top-2 text-3xl cursor-pointer opacity-70 hover:opacity-100 transition-all active:scale-95 select-none">x</div>
        <div class="modal--header p-4 select-none">Резерв книги</div>
        <div class="modal--main p-4">
          <label for="name" class="block mb-4">
            <p>Имя</p>
            <input type="text" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="name" name="name" required>
          </label>
          <label for="email" class="block mb-4">
            <p>email</p>
            <input type="email" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="email" name="email" required>
          </label>
          <label for="timeout" class="block">
            <p>Время резерва</p>
            <input type="date" class="w-full bg-stone-500 px-2 py-1 border-0 outline-0" id="timeout" name="timeout" required>
          </label>
        </div>
        <div class="modal--footer p-4 flex justify-end items-center">
          <button id="modal-ok" class="p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-2">Ok</button>
          <button class="modal-cancel p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md">Cancel</button>
        </div>
      </form>
    </div>
    `
    block.innerHTML = form
    const close = (e) => {
      e?.preventDefault()
      document
        .querySelectorAll('.modal-cancel')
        .forEach((item) => item.removeEventListener('click', close))
      document
        .querySelector('#modal-form')
        .removeEventListener('submit', submit)
      block.innerHTML = ''
    }
    const submit = async (e) => {
      e?.preventDefault()
      const form = e.target
      const data = {
        name: form.name.value,
        email: form.email.value,
        timeout: form.timeout.value,
        bookId: Number(bookId),
      }
      try {
        const res = await fetch('/api/book-reserve', {
          method: 'POST',
          body: JSON.stringify(data),
          headers: {
            'Content-Type': 'application/json',
          },
        })
        if (res.status === 204) {
          alert(`Книга зарезервирована`)
          getBookList()
          close()
        } else {
          throw new Error(res)
        }
      } catch (err) {
        console.error('reserv request', err)
      }
    }
    document.querySelector('#modal-form').addEventListener('submit', submit)
    document
      .querySelectorAll('.modal-cancel')
      .forEach((item) => item.addEventListener('click', close))
  }

  const onGetReservInfo = async (event) => {
    event.preventDefault()
    const close = (e) => {
      e?.preventDefault()
      document.querySelector('#view-modal').innerHTML = ''
      document
        .querySelectorAll('.modal-close')
        .forEach((i) => i.removeEventListener('click', close))
    }
    const bookId = event.target.getAttribute('book-id')
    try {
      const res = await fetch(`/api/reserve-info/${bookId}`)
      const items = await res.json()
      const r =
        `
      <div class="modal fixed left-0 right-0 top-0 bottom-0 bg-stone-600 bg-opacity-60 flex justify-center items-center">
        <div class="modal-content min-w-[350px] bg-stone-700 rounded-md relative">
          <div class="modal-close absolute right-4 top-2 text-3xl cursor-pointer opacity-70 hover:opacity-100 transition-all active:scale-95 select-none">x</div>
          <div class="modal--header p-4 select-none">Резерв книги</div>
          <div class="modal--main p-4">` +
        items
          .map(
            (item) => `
            <div class="${
              !item.isReserCanceled && 'bg-stone-200 bg-opacity-20'
            } px-2 border-b-2 border-stone-500">
              <span class="mb-2 text-lg">Имя:</span>
              <span class="mb-2">${
                item.name
              }</span><span class="ml-2 mr-4">|</span>
              <span class="mb-2 text-lg">Email:</span>
              <span class="mb-2">${
                item.email
              }</span><span class="ml-2 mr-4">|</span>
              <span class="mb-2 text-lg">Время резерва:</span>
              <span class="mb-2">${
                item.timeout
              }</span><span class="ml-2 mr-4">|</span>
              <span class="mb-2 text-lg">Завершен:</span>
              <span class="mb-2">${!item.isReserCanceled ? 'Нет' : 'Да'}</span>
            </div>
          `
          )
          .join('') +
        `</div>
          <div class="modal--footer p-4 flex justify-end items-center">
            <button class="modal-reserv p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md mr-4">Прервать резерв</button>
            <button class="modal-close p-2 bg-stone-500 hover:bg-opacity-70 active:scale-95 rounded-md">Закрыть</button>
          </div>
        </div>
      </div>
      `
      document.querySelector('#view-modal').innerHTML = r
      document
        .querySelectorAll('.modal-close')
        .forEach((i) => i.addEventListener('click', close))
      document.querySelector('.modal-reserv').addEventListener('click', () => {
        onCancelReserve(bookId).then(() => {
          close()
        })
      })
    } catch (err) {
      console.error('search query', error)
    }
  }

  const onCancelReserve = async (bookId) => {
    try {
      const res = await fetch(`/api/reserve-info/${bookId}`, {
        method: 'PUT',
      })
      if (res.status === 204) {
        alert('Резерв прекращен')
        getBookList()
        return Promise.resolve()
      }
    } catch (err) {
      console.error('search query', err)
      return Promise.reject()
    }
  }

  const init = () => {
    getBookList()
    document
      .querySelector('#query-form')
      .addEventListener('submit', onSearchQuery)
    document
      .querySelector('#filter-form')
      .addEventListener('submit', onFilterQuery)
    document
      .querySelector('#reset-filter')
      .addEventListener('click', getBookList)
  }

  init()
})()
