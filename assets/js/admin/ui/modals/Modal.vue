<template>
  <ModalWrapper v-bind="$attrs" v-on="$listeners">
    <div>
      <div class="mt-3 sm:mt-0 mb-6">
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
    name: 'Modal',
    components: { ModalWrapper },
  }
</script>
