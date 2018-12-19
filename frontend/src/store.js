import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'
import { getSavedState, saveState } from '@/utils/localStorage'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    config: {},
    groups: [],
    headers: getSavedState('apidocs.headers'),
  },

  mutations: {
    SET_CONFIG (state, config) {
      state.config = config
    },

    SET_GROUPS (state, groups) {
      state.groups = groups
    },

    SET_HEADERS (state, headers) {
      state.headers = headers
      saveState('apidocs.headers', headers)
    },
  },

  actions: {
    async fetchConfig ({ commit }) {
      const { data } = await axios.get('apidocs-api/config')

      commit('SET_CONFIG', data)
    },

    async fetchGroups ({ commit }) {
      const { data: response } = await axios.get('apidocs-api/endpoints')

      commit('SET_GROUPS', response.data)
    },

    setHeaders ({ commit }, headers) {
      commit('SET_HEADERS', headers)
    }
  },

  getters: {
    config (state) {
      return state.config
    },

    groups (state) {
      return state.groups
    },

    headers (state) {
      return state.headers
    },
  }
})
