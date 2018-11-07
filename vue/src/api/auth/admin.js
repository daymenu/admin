import request from '@/utils/request'

export function getList(search) {
  return request({
    url: '/api/admin/user',
    method: 'get',
    data: {
      search
    }
  })
}
