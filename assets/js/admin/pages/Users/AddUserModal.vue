<template>
  <Modal :value="value" v-on="$listeners">
    <ModalTitle>Create user</ModalTitle>
    <LabeledInput v-model="username" label="Username" class="mt-2" @keypress.enter="createUser" focus />
    <LabeledInput v-model="password" label="Password" class="mt-2" @keypress.enter="createUser" type="password" />

    <template #actions>
      <BaseButton
        :disabled="!username || !password"
        color="primary"
        class="flex w-full sm:ml-3 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:shadow-outline-red sm:text-sm sm:leading-5"
        @click="createUser"
      >
        Create user
      </BaseButton>
      <BaseButton
        class="mt-3 flex w-full sm:ml-3 sm:mt-0 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:shadow-outline-red sm:text-sm sm:leading-5"
        @click="close"
      >
        Cancel
      </BaseButton>
    </template>
  </Modal>
</template>

<script>
  import api from 'api'
  import Modal from 'ui/modals/Modal'
  import ModalTitle from 'ui/modals/ModalTitle'
  import LabeledInput from 'ui/inputs/LabeledInput'
  import BaseButton from 'ui/BaseButton'

  export default {
    name: 'AddUserModal',
    components: { BaseButton, LabeledInput, ModalTitle, Modal },
    props: {
      value: Boolean,
    },
    data() {
      return {
        username: null,
        password: null,
      }
    },
    watch: {
      value(val) {
        if (val) {
          this.username = null
          this.password = null
        }
      },
    },
    methods: {
      async createUser() {
        if (!this.username || !this.password) {
          return
        }

        const { username, password } = this
        await api.post('create_user_requests', { username, password })
        this.$emit('created')
        this.close()
      },
      close() {
        this.$emit('input', false)
      },
    },
  }
</script>
