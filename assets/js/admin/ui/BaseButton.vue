<template>
  <span class="inline-flex rounded-md shadow-sm">
    <button
      type="button"
      class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150"
      :class="classes"
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
    props: ['icon', 'buttonClass', 'color'],
    computed: {
      classes() {
        let classes = []
        if (this.buttonClass) {
          classes = Array.isArray(this.buttonClass) ? this.buttonClass : [this.buttonClass]
        }

        switch (this.color) {
          case 'primary':
            classes.push('text-white bg-indigo-600 focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700')
            if (!this.isDisabled) classes.push('hover:bg-indigo-500')
            break;
            case 'red':
              classes.push('bg-red-600 text-white focus:border-red-700 focus:shadow-outline-red')
              if (!this.isDisabled) classes.push('hover:bg-red-500')
              break;
          default:
            classes.push('border-gray-300 bg-white text-gray-700 focus:border-blue-300')
            if (!this.isDisabled) classes.push('hover:text-gray-500')
        }

        if (this.isDisabled) {
          classes.push('opacity-50', 'cursor-not-allowed')
        }

        return classes
      },
      isDisabled() {
        return this.$attrs.disabled
      }
    },
  }
</script>
