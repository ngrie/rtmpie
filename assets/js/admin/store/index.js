import Vuex from 'vuex'

import createUserModule from './user'
import createStreamsModule from './streams'

const createStore = () => new Vuex.Store({
  modules: {
    user: createUserModule(),
    streams: createStreamsModule(),
  },
  actions: {
    init({ dispatch }) {
      dispatch('user/init')
    },
    authenticated({ dispatch }) {
      dispatch('streams/init')
    },
  },
})

export default createStore
