<template>
  <div class="bg-gray-200 p-2 rounded" :class="{ inline }">
    <input ref="copyField" type="text" :value="value" class="sr-only whitespace-pre-wrap" area-hidden />
    <div :class="{ inline, 'flex items-center': !inline }">
      <pre :class="{ inline, 'break-all whitespace-normal': !inline }">{{ value }}</pre>
      <fa-icon
        :icon="['fas', 'clipboard']"
        size="lg"
        class="text-gray-600 hover:text-gray-900 cursor-pointer"
        :class="{ 'ml-1': inline, 'ml-2': !inline }"
        title="Copy to clipboard"
        @click="copy"
      />
    </div>
  </div>
</template>

<script>
  export default {
    name: 'CredentialsWrapper',
    props: {
      value: {
        type: String,
        required: true,
      },
      inline: Boolean,
    },
    methods: {
      copy() {
        this.$refs.copyField.select()
        document.execCommand('copy')
      },
    },
  }
</script>
