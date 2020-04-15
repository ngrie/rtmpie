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
        class="form-input block w-full sm:text-sm sm:leading-5"
        @input="$emit('input', $event.target.value)"
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
