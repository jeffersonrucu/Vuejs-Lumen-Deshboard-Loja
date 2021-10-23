import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    page: 'Visão Geral'
  },
  mutations: {
    attPage (state, name) {
      state.page = name
    }
  },
  actions: {
  },
  modules: {
  }
})
