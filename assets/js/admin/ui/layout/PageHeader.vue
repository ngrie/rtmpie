<template>
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
          <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
            <slot />
          </h2>
        </div>
        <div v-if="$slots.actions" class="mt-4 flex md:mt-0 md:ml-4">
          <slot name="actions" />
        </div>
      </div>
    </div>
  </header>
</template>

<script>
  export default {
    name: 'PageHeader',
  }
</script>
