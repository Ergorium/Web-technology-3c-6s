export default function overdueHelper(items) {
  return items.map((item) => {
    item.overdue = item.timeout - item.created_at < 0 && !item.canceled
    item.created_at = new Date(item.created_at)
      .toLocaleDateString()
      .padStart(10, '0')
    item.timeout = new Date(item.timeout).toLocaleDateString().padStart(10, '0')
    return item
  })
}
