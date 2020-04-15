import { sortBy } from 'lodash'
import api from 'api'
import { config } from '../utils'

const createStreamsModule = () => ({
  namespaced: true,
  state: {
    streams: [],
    hasSseError: false,
  },
  getters: {
    all: ({ streams }) => sortBy(streams, 'live'),
    hasSseError: ({ hasSseError }) => hasSseError,
  },
  mutations: {
    setStreams(state, streams) {
      state.streams = streams
    },
    addOrUpdate(state, data) {
      const index = state.streams.findIndex(({ id }) => id === data.id);
      if (index >= 0) {
        Object.assign(state.streams[index], data)
      } else {
        state.streams.push(data)
      }
    },
    hasSseError(state) {
      state.hasSseError = true
    },
  },
  actions: {
    async init({ commit, dispatch }) {
      await dispatch('fetch')

      // Watch for Server Sent Events
      const url = new URL(config('sseHost'));
      url.searchParams.append('topic', '/api/streams/{id}');
      const eventSource = new EventSource(url);
      eventSource.onmessage = ({ data }) => commit('addOrUpdate', JSON.parse(data))
      eventSource.onerror = () => {
        eventSource.close()
        commit('hasSseError')
      }
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
