<template>
  <div>
    <label :for="id" class="block text-sm font-medium leading-5 text-gray-700">
      {{ label }}
    </label>
    <div class="mt-1 relative rounded-md shadow-sm">
      <input
        ref="input"
        :value="value"
        :id="id"
        :type="type"
        class="form-input shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
        @input="$emit('input', $event.target.value)"
        v-on="listeners"
      />
    </div>
  </div>
</template>

<script>
  let suffix = 1

  export default {
    name: 'LabeledInput',
    props: {
      value: String,
      label: String,
      focus: Boolean,
      type: {
        type: String,
        default: 'text',
      },
    },
    data() {
      return {
        suffix: null,
      }
    },
    computed: {
      id() {
        return `LabeledInput-${this.suffix}`
      },
      listeners() {
        const { input, ...rest } = this.$listeners
        return rest
      },
    },
    beforeMount() {
      this.suffix = suffix
      suffix += 1
    },
    mounted() {
      if (this.focus) {
        setTimeout(() => {
          this.$refs.input.focus()
        }, 200)
      }
    },
  }
</script>
