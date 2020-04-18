<template>
  <div class="rounded-md bg-blue-50 p-4">
    <div class="flex">
      <div class="flex-shrink-0">
        <slot name="icon" />
      </div>
      <div class="ml-3 flex-1 md:flex md:justify-between">
        <p class="text-sm leading-5 text-blue-700">
          <slot />
        </p>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Alert',
  }
</script>
