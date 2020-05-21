<template>
  <PageWrapper class="text-center text-gray-400 mt-6">
    <fa-icon :icon="['far', 'frown']" size="7x" />
    <div class="text-3xl mt-4">Stream not found</div>
    <div class="text-md">
      The stream you are searching for does not exist or was deleted.
    </div>
    <div>
      <!-- TODO: add router-link capability to BaseButton -->
      <router-link :to="{ name: 'streams' }" v-slot="{ navigate }">
        <BaseButton color="primary" class="mt-6" @click="navigate">
          View streams
        </BaseButton>
      </router-link>
    </div>
  </PageWrapper>
</template>

<script>
  import PageWrapper from 'ui/layout/PageWrapper'
  import BaseButton from 'ui/BaseButton'

  export default {
    name: 'StreamNotFound',
    components: { BaseButton, PageWrapper },
  }
</script>
