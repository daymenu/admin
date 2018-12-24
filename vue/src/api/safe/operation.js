import request from '@/utils/request'

const baseUrl = '/api/admin/safe/operation'

export function getList(search) {
  return request({
    url: baseUrl,
    method: 'get',
    params: search
  })
}
