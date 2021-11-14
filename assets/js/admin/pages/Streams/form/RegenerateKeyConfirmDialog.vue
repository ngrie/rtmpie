<template>
  <ConfirmDialog :value="value" color="primary" v-on="$listeners">
    <ModalTitle>Regenerate secret key</ModalTitle>
    <div class="mt-2">
      <p class="text-sm leading-5 text-gray-500">
        Are you sure you want to change the secret key? Clients publishing to this stream will stay connected but for new connections the new key will be needed.
      </p>
    </div>

    <template #actions>
      <BaseButton
        color="primary"
        class="flex w-full sm:ml-3 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:ring-indigo-500 sm:text-sm sm:leading-5"
        @click="confirm"
      >
        Regenerate key
      </BaseButton>
      <BaseButton
        class="mt-3 flex w-full sm:ml-3 sm:mt-0 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:ring-indigo-500 sm:text-sm sm:leading-5"
        @click="cancel"
      >
        Cancel
      </BaseButton>
    </template>
    <template #icon>
      <svg class="h-6 w-6 text-indigo-700" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
      </svg>
    </template>
  </ConfirmDialog>
</template>

<script>
  import ConfirmDialog from 'ui/modals/ConfirmDialog'
  import ModalTitle from 'ui/modals/ModalTitle'
  import BaseButton from 'ui/BaseButton'

  export default {
    name: 'RegenerateKeyConfirmDialog',
    components: { BaseButton, ModalTitle, ConfirmDialog },
    props: {
      value: Boolean,
    },
    methods: {
      confirm() {
        this.$emit('confirmed')
        this.$emit('input', false)
      },
      cancel() {
        this.$emit('canceled')
        this.$emit('input', false)
      },
    },
  }
</script>
