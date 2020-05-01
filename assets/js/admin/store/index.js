import Vuex from 'vuex'

import createUserModule from './user'
import createStreamsModule from './streams'
import createNotificationModule from './notification'

const createStore = () => new Vuex.Store({
  modules: {
    user: createUserModule(),
    streams: createStreamsModule(),
    notification: createNotificationModule(),
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
