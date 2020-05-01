const createNotificationModule = () => ({
  namespaced: true,
  state: {
    message: null,
  },
  getters: {
    message: ({ message }) => message,
  },
  mutations: {
    setMessage(state, message) {
      state.message = message
    },
  },
  actions: {
    show({ commit }, message) {
      commit('setMessage', message)
    },
    hide({ commit }) {
      commit('setMessage', null)
    },
  },
})

export default createNotificationModule
