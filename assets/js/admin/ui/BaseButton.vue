<template>
  <span class="inline-flex rounded-md shadow-sm">
    <button
      type="button"
      class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150"
      v-bind="$attrs"
      v-on="$listeners"
    >
      <fa-icon v-if="icon" :icon="icon" class="-ml-1 mr-2 h-5 w-5" />
      <slot />
    </button>
  </span>
</template>

<script>
  export default {
    name: 'BaseButton',
    props: ['icon'],
  }
</script>
