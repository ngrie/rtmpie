import Vuex from 'vuex'

import createUserModule from './user'

const createStore = () => new Vuex.Store({
  modules: {
    user: createUserModule(),
  },
  actions: {
    init({ dispatch }) {
      dispatch('user/init')
    },
  },
})

export default createStore
