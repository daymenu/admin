import Vue from 'vue'
import Router from 'vue-router'

// in development-env not use lazy-loading, because lazy-loading too many pages will cause webpack hot update too slow. so only in production use lazy-loading;
// detail: https://panjiachen.github.io/vue-element-admin-site/#/lazy-loading

Vue.use(Router)

/* Layout */
// import Layout from '../views/layout/Layout'

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    title: 'title'               the name show in submenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar,
  }
**/
export const constantRouterMap = [
  { path: '/login', component: () => import('@/views/login/index'), name: 'login', hidden: true },
  { path: '/404', component: () => import('@/views/404'), name: '404', hidden: true },

  {
    path: '/',
    component: () => import('@/views/layout/Layout'),
    redirect: '/dashboard',
    name: 'Dashboard',
    hidden: true,
    children: [{
      path: 'dashboard',
      component: () => import('@/views/dashboard/index')
    }]
  },

  {
    path: '/auth',
    component: () => import('@/views/layout/Layout'),
    redirect: '/auth/admin',
    name: 'auth',
    meta: {
      title: '权限管理',
      icon: 'eye'
    },
    children: [
      {
        path: 'admin',
        component: () => import('@/views/auth/admin/main'), // Parent router-view
        name: 'admin',
        meta: { title: '人员管理' },
        children: [
          {
            path: '',
            component: () => import('@/views/auth/admin/list'), // Parent router-view
            name: 'adminList',
            meta: { title: '人员列表', nonMenu: true },
            hidden: true
          },
          {
            path: 'edit/:id',
            component: () => import('@/views/auth/admin/edit'), // Parent router-view
            name: 'adminEdit',
            meta: { title: '人员编辑', nonMenu: true },
            hidden: true
          },
          {
            path: 'add',
            component: () => import('@/views/auth/admin/create'), // Parent router-view
            name: 'adminAdd',
            meta: { title: '人员添加', nonMenu: true },
            hidden: true
          }
        ]
      },
      {
        path: 'role',
        component: () => import('@/views/auth/admin/index'),
        name: 'role',
        meta: { title: '角色管理' }
      },
      {
        path: 'menu',
        component: () => import('@/views/auth/admin/index'), // Parent router-view
        name: 'menu',
        meta: { title: '菜单管理' }
      },
      {
        path: 'api',
        component: () => import('@/views/auth/api/index'), // Parent router-view
        name: 'api',
        meta: { title: '接口管理' }
      }
    ]
  },

  { path: '*', redirect: '/404', hidden: true }
]

export default new Router({
  mode: 'history', // 后端支持可开
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap
})
