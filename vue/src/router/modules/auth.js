
const AuthRouter = {
  path: '/auth',
  component: () => import('@/views/layout/Layout'),
  redirect: '/auth/admin',
  name: 'auth',
  meta: {
    title: '权限管理',
    icon: 'form'
  },
  children: [{
    path: 'admin',
    component: () => import('@/views/auth/admin/main'), // Parent router-view
    name: 'authAdmin',
    meta: {
      title: '人员管理'
    },
    children: [{
      path: '',
      component: () => import('@/views/auth/admin/list'), // Parent router-view
      name: 'adminList',
      meta: {
        title: '人员列表',
        nonMenu: true
      },
      hidden: true
    },
    {
      path: 'edit/:id',
      component: () => import('@/views/auth/admin/edit'), // Parent router-view
      name: 'adminEdit',
      meta: {
        title: '人员编辑',
        nonMenu: true
      },
      hidden: true
    },
    {
      path: 'add',
      component: () => import('@/views/auth/admin/create'), // Parent router-view
      name: 'adminAdd',
      meta: {
        title: '人员添加',
        nonMenu: true
      },
      hidden: true
    }
    ]
  },
  {
    path: 'role',
    component: () => import('@/views/auth/role/index'),
    name: 'authRole',
    meta: {
      title: '角色管理'
    }
  },
  {
    path: 'menu',
    component: () => import('@/views/auth/menu/index'), // Parent router-view
    name: 'authMenu',
    meta: {
      title: '菜单管理'
    }
  },
  {
    path: 'api',
    component: () => import('@/views/auth/api/index'), // Parent router-view
    name: 'authApi',
    meta: {
      title: '接口管理'
    }
  }
  ]
}

export default AuthRouter
