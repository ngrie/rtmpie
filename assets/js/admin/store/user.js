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
    async init({ commit }) {
      try {
        const { data } = await axios.get('/me')
        commit('setUser', data)
        commit('checkedAuthentication')
      } catch (e) {
        if (e.response && e.response.status === 401) {
          commit('checkedAuthentication')
        }
      }
    },
    login({ commit }, credentials) {
      return axios.post('/login', credentials)
        .then(({ data }) => {
          commit('setUser', data)
          commit('checkedAuthentication')
          return data
        })
    }
  }
})

export default createUserModule
