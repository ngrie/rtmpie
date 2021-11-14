<template>
  <td
    class="px-6 py-4 whitespace-nowrap text-sm leading-5"
    :class="{ 'font-medium text-gray-900': bold, 'text-gray-500': !bold }"
  >
    <slot />
  </td>
</template>

<script>
  export default {
    name: 'TableColumn',
    props: {
      bold: Boolean,
    },
  }
</script>
