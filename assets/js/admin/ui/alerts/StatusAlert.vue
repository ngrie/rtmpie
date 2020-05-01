<template>
  <component :is="comp" v-bind="$attrs" v-on="$listeners">
    {{ message }}
  </component>
</template>

<script>
  import SuccessAlert from 'ui/alerts/SuccessAlert'
  import ErrorAlert from 'ui/alerts/ErrorAlert'

  export default {
    name: 'StatusAlert',
    props: {
      type: {
        type: String,
        required: true,
      },
      message: {
        type: String,
        required: true,
      },
    },
    computed: {
      comp() {
        switch (this.type) {
          case 'error':
            return ErrorAlert
          case 'success':
          default:
            return SuccessAlert
        }
      },
    },
  }
</script>
