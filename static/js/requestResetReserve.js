;(() => {
  async function requestCancelReserve(id) {
    try {
      const res = await fetch(`/books/${id}`, {
        method: 'PATCH',
      })
      if ([400, 404, 500].includes(res.status)) {
        throw new Error(res)
      }
      return Promise.resolve()
    } catch (err) {
      console.error(err)
      return Promise.reject()
    }
  }
  document.querySelectorAll('#modal-reset')?.forEach((item) => {
    item?.addEventListener('click', (e) => {
      requestCancelReserve(e.target.getAttribute('book-id'))
        .then(() => {
          location.reload()
        })
        .catch(() => {
          alert('Ошибка при удалении')
        })
    })
  })
})()
