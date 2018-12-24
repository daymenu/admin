import store from '../store'

export default function hasPrimission(btnName) {
  return store.getters.routeNames.includes(btnName)
}
