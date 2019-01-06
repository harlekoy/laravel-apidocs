import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import { apiPath } from '@/utils/url'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: '/',
  routes: [
    {
      path: `/${apiPath()}`,
      redirect: { name: 'home' }
    },
    {
      path: `/${apiPath()}/list`,
      name: 'home',
      component: Home
    },
  ]
})
