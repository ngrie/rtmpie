<template>
  <div class="flex flex-col">
    <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
      <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        <table class="min-w-full">
          <thead>
          <tr>
            <th
              v-for="col in columns"
              :key="col"
              class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"
            >
              {{ col }}
            </th>
            <th v-if="withActionColumn" class="px-6 py-3 border-b border-gray-200 bg-gray-50" />
          </tr>
          </thead>
          <tbody>
          <slot />
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Table',
    props: {
      columns: {
        type: Array,
        required: true,
      },
      withActionColumn: Boolean,
    },
  }
</script>
