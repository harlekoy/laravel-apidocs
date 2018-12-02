import axios from 'axios'
import qs from 'qs'
import store from '@/store'
import { apiUrl } from '@/utils/url'
import { fail } from '@/utils/toast'
import { isEmpty } from 'lodash'

axios.defaults.baseURL = apiUrl()
axios.defaults.paramsSerializer = params => qs.stringify(params, {arrayFormat: 'repeat'})

axios.interceptors.request.use(request => {
  if (!isEmpty(store.getters['headers'])) {
    request.headers = Object.assign(request.headers, store.getters['headers'])
  }

  return request
})

axios.interceptors.response.use(response => response, async (error) => {
  const { status, data: { message }} = error.response

  switch (status) {
    case 500:
      fail({
        title: 'Error!',
        text: message,
        timer: 5000,
        position: 'bottom-right',
        width: 500,
      })
    break
  }

  return Promise.reject(error)
})
