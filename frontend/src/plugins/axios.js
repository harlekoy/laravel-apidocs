import axios from 'axios'
import qs from 'qs'
import { apiUrl } from '@/utils/url'
import store from '@/store'
import { isEmpty } from 'lodash'

axios.defaults.baseURL = apiUrl()
axios.defaults.paramsSerializer = params => qs.stringify(params, {arrayFormat: 'repeat'})

axios.interceptors.request.use(request => {
  if (!isEmpty(store.getters['headers'])) {
    request.headers = Object.assign(request.headers, store.getters['headers'])
  }

  return request
})

