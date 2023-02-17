export default function queryConvert(value) {
  const res = Object.keys(value)
    .map((key) => {
      if (key === 'overdue') return `datediff(timeout, created_at) < 0`
      if (key === 'reserved') return 'reserved=true'
      if (key.match(/.*id.*/gim)?.length > 0) {
        return `${key} = ${value[key]}`
      }
      if (['canceled'].includes(key))
        return `${key} = ${value[key] ? 'true' : 'false'}`
      return `${key} like '%${value[key]}%'`
    })
    .filter((item) => item !== null)
    .join(' and ')
  if (res.length === 0) {
    return ''
  }
  return 'where ' + res
}
