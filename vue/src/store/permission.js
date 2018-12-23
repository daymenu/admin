import { asyncRouterMap, constantRouterMap } from '@/router/'
import { getRouteNames } from '@/api/auth/admin'

function hasPermission(routeNames, route) {
  if (!route.name || route.name === '') {
    return true
  }
  if (routeNames.indexOf(route.name) === -1) {
    return false
  }
  return true
}

const permission = {
  state: {
    routers: constantRouterMap,
    addRouters: [],
    routeNames: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers
      state.routers = constantRouterMap.concat(routers)
    },
    SET_ROUTE_NAMES: (state, routeNames) => {
      state.routeNames = routeNames
    }
  },
  actions: {
    GenerateRoutes({ commit }) {
      return new Promise((resolve, reject) => {
        getRouteNames().then(response => {
          const routeNames = response.data
          const accessedRouters = asyncRouterMap.filter(v => {
            if (hasPermission(routeNames, v)) {
              if (v.children && v.children.length > 0) {
                v.children = v.children.filter(child => {
                  if (hasPermission(routeNames, child)) {
                    return child
                  }
                  return false
                })
                return v
              } else {
                return v
              }
            }
            return false
          })
          commit('SET_ROUTERS', accessedRouters)
          commit('SET_ROUTE_NAMES', routeNames)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    }
  }
}

export default permission
