<template>
  <Modal :value="value" v-on="$listeners">
    <ModalTitle>Create stream</ModalTitle>
    <LabeledInput v-model="name" focus label="Name" class="mt-2" @keypress.enter="createStream" />

    <template #actions>
      <BaseButton
        :disabled="!name"
        color="primary"
        class="flex w-full sm:ml-3 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:shadow-outline-red sm:text-sm sm:leading-5"
        @click="createStream"
      >
        Create stream
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
  import { mapActions } from 'vuex'
  import Modal from 'ui/modals/Modal'
  import BaseButton from 'ui/BaseButton'
  import LabeledInput from 'ui/inputs/LabeledInput'
  import ModalTitle from 'ui/modals/ModalTitle'

  export default {
    name: 'AddStreamModal',
    components: { ModalTitle, LabeledInput, BaseButton, Modal },
    props: {
      value: Boolean,
    },
    data() {
      return {
        name: null,
      }
    },
    watch: {
      value(val) {
        if (val) {
          this.name = null
        }
      },
    },
    methods: {
      ...mapActions('streams', ['create']),
      async createStream() {
        if (!this.name) {
          return
        }

        const { name } = this
        await this.create(name)
        this.close()
      },
      close() {
        this.$emit('input', false)
      },
    },
  }
</script>
