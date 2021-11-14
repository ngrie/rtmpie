<template>
  <ConfirmDialog :value="value" v-on="$listeners">
    <ModalTitle>Delete stream</ModalTitle>
    <div class="mt-2">
      <p class="text-sm leading-5 text-gray-500">
        Are you sure you want to delete this stream?
      </p>
    </div>

    <template #actions>
      <BaseButton
        color="red"
        class="flex w-full sm:ml-3 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:ring-red-500 sm:text-sm sm:leading-5"
        @click="confirm"
      >
        Delete stream
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
      <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
      </svg>
    </template>
  </ConfirmDialog>
</template>

<script>
  import ConfirmDialog from 'ui/modals/ConfirmDialog'
  import ModalTitle from 'ui/modals/ModalTitle'
  import BaseButton from 'ui/BaseButton'

  export default {
    name: 'DeleteStreamConfirmDialog',
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
