<template>
  <div class="rounded-md p-4" :class="wrapperClass">
    <div class="flex">
      <div class="flex-shrink-0">
        <slot name="icon" />
      </div>
      <div class="ml-3 flex-1 md:flex md:justify-between">
        <p class="text-sm leading-5" :class="textClass">
          <slot />
        </p>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Alert',
    props: {
      color: {
        type: String,
        default: 'blue',
      },
    },
    computed: {
      wrapperClass() {
        switch (this.color) {
          case 'green': return 'bg-green-50'
          default: return 'bg-blue-50'
        }
      },
      textClass() {
        switch (this.color) {
          case 'green': return 'text-green-700'
          default: return 'text-blue-700'
        }
      },
    },
  }
</script>
