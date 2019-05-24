
export function toTree(data){
  data.forEach(item => {
    delete item.children
  })
  var map = {}
  data.forEach(item => {
    map[item.id] = item
  })
  var val = []
  data.forEach(item => {
    var parent = map[item.pId]
    if (parent) {
      ( parent.children || (parent.children = []) ).push(item)
    } else {
      val.push(item)
    }
  })
  return val
}