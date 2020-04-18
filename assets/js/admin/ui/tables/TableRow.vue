<template>
  <tr :class="{ 'bg-gray-50': striped, 'bg-white': !striped }">
    <slot />
  </tr>
</template>

<script>
  export default {
    name: 'TableRow',
    props: {
      striped: Boolean,
    },
  }
</script>
