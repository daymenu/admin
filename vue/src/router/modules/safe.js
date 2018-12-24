const SafeRouter = {
  path: '/safe',
  component: () => import('@/views/layout/Layout'),
  redirect: '/safe/login',
  name: 'safe',
  meta: {
    title: '网站安全',
    icon: 'table'
  },
  children: [{
    path: 'login',
    component: () => import('@/views/safe/login'), // Parent router-view
    name: 'safeLogin',
    meta: {
      title: '登录日志'
    }
  }, {
    path: 'operation',
    component: () => import('@/views/safe/operation'), // Parent router-view
    name: 'safeOperation',
    meta: {
      title: '操作日志'
    }
  }]
}

export default SafeRouter
