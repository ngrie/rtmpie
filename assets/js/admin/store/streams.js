import { sortBy } from 'lodash'
import api from 'api'

const createStreamsModule = () => ({
  namespaced: true,
  state: {
    streams: [],
  },
  getters: {
    all: ({ streams }) => sortBy(streams, 'live'),
  },
  mutations: {
    setStreams(state, streams) {
      state.streams = streams
    },
  },
  actions: {
    init({ dispatch }) {
      dispatch('fetch')
    },
    fetch({ commit }) {
      return api('streams')
        .then(({ data }) => {
          commit('setStreams', data)
          return data
        })
    },
    create({ dispatch }, name) {
      return api.post('streams', { name })
        .then(({ data }) => {
          dispatch('fetch')
          return data
        })
    },
  },
})

export default createStreamsModule
