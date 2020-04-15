<template>
  <StreamListItem :first="first">
    <template #image>
      <img class="h-12 w-12 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
    </template>
    <template #details>
      <div class="text-sm leading-loose text-gray-900">
        <div class="bg-gray-200 inline p-2 rounded">
          <input ref="streamUrl" type="text" :value="streamUrl" class="sr-only whitespace-pre-wrap" area-hidden />
          <pre class="inline">{{ streamUrl }}</pre>
          <fa-icon
            :icon="['fas', 'clipboard']"
            size="lg"
            class="text-gray-600 ml-1 hover:text-gray-900 cursor-pointer"
            title="Copy to clipboard"
            @click="copyStreamUrl"
          />
        </div>
      </div>
      <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
        <input ref="streamKey" type="text" :value="streamKey" class="sr-only whitespace-pre-wrap" area-hidden />
        <a
          href="#"
          class="text-sm leading-5 text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline"
          @click.prevent="copyStreamKey"
        >
          Copy stream key to clipboard
        </a>
      </div>
    </template>
    <template #actions>
      <router-link to="/">Edit</router-link>
    </template>

    <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
      {{ stream.name }}
    </div>
    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
      <Badge v-if="stream.live" color="green">Live</Badge>
      <Badge v-else>Offline</Badge>
      <template v-if="stream.live">
        <fa-icon :icon="['far', 'eye']" size="lg" class="flex-shrink-0 ml-4 mr-1.5 h-5 w-5 text-gray-400" />
        <span class="truncate">{{ stream.viewerCount }}</span>
      </template>
    </div>
  </StreamListItem>
</template>

<script>
  import Badge from 'ui/Badge'
  import StreamListItem from 'ui/streamList/StreamListItem'
  import { config } from '../../utils'
  export default {
    name: 'StreamItem',
    components: { StreamListItem, Badge },
    props: {
      stream: {
        type: Object,
        required: true,
      },
      first: Boolean,
    },
    computed: {
      streamUrl() {
        return `rtmp://${config('host')}/live/${this.stream.slug}`
      },
      streamKey() {
        return `${this.stream.slug}?key=${this.stream.key}`
      }
    },
    methods: {
      copyStreamUrl() {
        this.$refs.streamUrl.select()
        document.execCommand('copy')
      },
      copyStreamKey() {
        this.$refs.streamKey.select()
        document.execCommand('copy')
      },
    },
  }
</script>
