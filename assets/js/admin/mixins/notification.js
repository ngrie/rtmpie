const mixin = {
  methods: {
    showErrorNotification(message) {
      this.$store.dispatch('notification/show', message)
    },
  },
}

export default mixin
