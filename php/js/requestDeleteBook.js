;(() => {
  async function requestDeleteBook(id) {
    try {
      const res = await fetch(`/books/delete.php?id=${id}`, {
        method: 'POST',
      })
      if ([400, 404, 500].includes(res.status)) {
        throw new Error(res)
      }
    } catch (err) {
      console.error(err)
      return Promise.reject(err)
    }
  }

  document.querySelector('#modal-delete').addEventListener('click', (e) => {
    requestDeleteBook(e.target.getAttribute('book-id'))
      .then(() => {
        window.location = '/books'
      })
      .catch(() => {
        alert('Ошибка при удалении')
      })
  })
})()
