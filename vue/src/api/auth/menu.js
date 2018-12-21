import request from '@/utils/request'

const baseUrl = '/api/admin/menu'

export function getList(search) {
  return request({
    url: baseUrl,
    method: 'get',
    params: search
  })
}

export function show(id) {
  return request({
    url: baseUrl + '/' + id,
    method: 'get'
  })
}

export function menuSelect(id) {
  return request({
    url: baseUrl + '/tree',
    method: 'get'
  })
}

export function apiIds(id) {
  return request({
    url: baseUrl + '/apis',
    method: 'get',
    params: { id: id }
  })
}

export function store(data) {
  return request({
    url: baseUrl,
    method: 'post',
    data: data
  })
}

export function addApis(data) {
  return request({
    url: baseUrl + '/addApis',
    method: 'post',
    data: data
  })
}

export function update(id, data) {
  return request({
    url: baseUrl + '/' + id,
    method: 'put',
    data: data
  })
}

export function destroy(id) {
  return request({
    url: baseUrl + '/' + id,
    method: 'delete'
  })
}
