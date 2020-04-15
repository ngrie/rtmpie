import axios from 'axios'

const createUserModule = () => ({
  namespaced: true,
  state: {
    user: null,
    checkedAuthentication: false,
  },
  getters: {
    user: ({ user }) => user,
    authenticated: (state, { user }) => !!user,
    checkedAuthentication: ({ checkedAuthentication }) => checkedAuthentication,
  },
  mutations: {
    setUser(state, user) {
      state.user = user
    },
    checkedAuthentication(state) {
      state.checkedAuthentication = true
    },
  },
  actions: {
    async init({ commit, dispatch }) {
      try {
        const { data } = await axios.get('/me')
        commit('setUser', data)
        commit('checkedAuthentication')
        dispatch('authenticated', null, { root: true })
      } catch (e) {
        if (e.response && e.response.status === 401) {
          commit('checkedAuthentication')
        }
      }
    },
    login({ commit, dispatch }, credentials) {
      return axios.post('/login', credentials)
        .then(({ data }) => {
          commit('setUser', data)
          commit('checkedAuthentication')
          dispatch('authenticated', null, { root: true })
          return data
        })
    }
  }
})

export default createUserModule
