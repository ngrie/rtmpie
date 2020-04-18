<template>
  <ModalWrapper v-bind="$attrs" v-on="$listeners">
    <div class="sm:flex sm:items-start">
      <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
        <slot name="icon" />
      </div>
      <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
        <slot />
      </div>
    </div>
    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
      <slot name="actions" />
    </div>
  </ModalWrapper>
</template>

<script>
  import ModalWrapper from 'ui/modals/ModalWrapper'

  export default {
    name: 'ConfirmDialog',
    components: { ModalWrapper },
  }
</script>
