<template>
  <li :class="{ 'border-t border-gray-200': !first }">
    <div class="block">
      <div class="flex items-center px-4 py-4 sm:px-6">
        <div class="min-w-0 flex-1 flex items-center">
          <div class="flex-shrink-0">
            <slot name="image" />
          </div>
          <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
            <div>
              <slot />
            </div>
            <div class="hidden md:block">
              <div>
                <slot name="details" />
              </div>
            </div>
          </div>
        </div>
        <div class="text-sm leading-5 font-medium text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">
          <slot name="actions" />
        </div>
      </div>
    </div>
  </li>
</template>

<script>
  export default {
    name: 'StreamListItem',
    props: {
      first: Boolean,
    },
  }
</script>
