<template>
  <span
    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
    :class="colorClasses"
  >
    <slot />
  </span>
</template>

<script>
  export default {
    name: 'Badge',
    props: {
      color: String,
    },
    computed: {
      colorClasses() {
        switch (this.color) {
          case 'green': return 'bg-green-100 text-green-800'
          default: return 'bg-gray-100 text-gray-800'
        }
      },
    },
  }
</script>
