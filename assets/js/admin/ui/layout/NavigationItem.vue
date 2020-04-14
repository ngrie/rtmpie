<template>
  <a
    class="ml-4 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:text-white focus:bg-gray-700"
    :class="{ 'text-white bg-gray-900': active, 'text-gray-300 hover:text-white hover:bg-gray-700': !active }"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <slot />
  </a>
</template>

<script>
  export default {
    name: 'NavigationItem',
    props: {
      active: Boolean,
    },
  }
</script>
