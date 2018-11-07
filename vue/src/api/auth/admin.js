import request from '@/utils/request'

export function getList(search) {
  return request({
    url: '/api/admin/user',
    method: 'get',
    params: search
  })
}

export function show(id) {
  return request({
    url: '/api/admin/user/show',
    method: 'get',
    params: {
      id: id
    }
  })
}

export function store(user) {
  return request({
    url: '/api/admin/user/show',
    method: 'post',
    data: user
  })
}

export function update(user) {
  return request({
    url: '/api/admin/user/update',
    method: 'post',
    data: user
  })
}

export function destroy(id) {
  return request({
    url: '/api/admin/user/destroy',
    method: 'post',
    data: {
      id: id
    }
  })
}

