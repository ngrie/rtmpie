<template>
  <StreamListItem :first="first">
    <template #image>
      <img
        v-if="stream.live && thumbnailUrl"
        class="h-16 w-20 object-cover rounded shadow"
        :src="thumbnailUrl" alt=""
      />
      <div v-else class="border-4 border-dashed border-gray-200 rounded-lg h-16 w-20"></div>
    </template>
    <template #details>
      <div class="text-sm leading-loose text-gray-900">
        <CredentialsWrapper inline :value="streamUrl" />
      </div>
      <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
        <a
          href="#"
          class="text-sm leading-5 text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline"
          @click.prevent="openStreamingCredentialsModal"
        >
          Show streaming credentials
        </a>
      </div>
    </template>
    <template #actions>
      <router-link :to="{ name: 'stream', params: { id: stream.id } }">Edit</router-link>
    </template>

    <div class="text-sm leading-5 font-medium truncate">
      {{ stream.name }}
    </div>
    <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
      <Badge v-if="stream.live" color="green">Live</Badge>
      <Badge v-else>Offline</Badge>
      <template v-if="stream.live">
        <fa-icon :icon="['far', 'eye']" size="lg" class="flex-shrink-0 ml-4 mr-1.5 h-5 w-5 text-gray-400" />
        <span class="truncate">{{ stream.viewerCount }}</span>
        <a
          href="#"
          class="hidden sm:inline-flex ml-4 text-sm leading-5 font-medium text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline"
          @click.prevent="showDropPublisherModal = true"
        >
          Drop publisher
        </a>
      </template>
    </div>

    <StreamingCredentialsModal v-model="showStreamingCredentialsModal" :stream="stream" />
    <DropPublisherConfirmDialog
      v-model="showDropPublisherModal"
      @confirmed="dropPublisher"
      @confirmedWithRegeneratingKey="dropPublisherAndRegenKey"
    />
  </StreamListItem>
</template>

<script>
  import { mapActions } from 'vuex'
  import notificationMixin from 'mixins/notification'
  import Badge from 'ui/Badge'
  import StreamListItem from 'ui/streamList/StreamListItem'
  import { generateErrorMessageFromResponse, getRtmpPrefix } from 'utils'
  import StreamingCredentialsModal from './StreamingCredentialsModal'
  import CredentialsWrapper from '../../components/CredentialsWrapper'
  import DropPublisherConfirmDialog from './DropPublisherConfirmDialog'

  export default {
    name: 'StreamItem',
    mixins: [notificationMixin],
    components: { DropPublisherConfirmDialog, CredentialsWrapper, StreamingCredentialsModal, StreamListItem, Badge },
    props: {
      stream: {
        type: Object,
        required: true,
      },
      thumbnailUrl: String,
      first: Boolean,
    },
    data() {
      return {
        showStreamingCredentialsModal: false,
        showDropPublisherModal: false,
      }
    },
    computed: {
      streamUrl() {
        return `${getRtmpPrefix()}/${this.stream.slug}`
      },
      streamKey() {
        return `${this.stream.slug}?key=${this.stream.key}`
      },
    },
    methods: {
      ...mapActions('streams', {
        dropPublisherRequest: 'dropPublisher',
      }),
      openStreamingCredentialsModal() {
        this.showStreamingCredentialsModal = true
      },
      async dropPublisher() {
        try {
          await this.dropPublisherRequest({ streamId: this.stream.id, regenerateStreamKey: false })
        } catch ({ response }) {
          this.showErrorNotification(generateErrorMessageFromResponse('Publisher could not be kicked from the stream.', response))
        }
      },
      async dropPublisherAndRegenKey() {
        try {
          await this.dropPublisherRequest({ streamId: this.stream.id, regenerateStreamKey: true })
        } catch ({ response }) {
          this.showErrorNotification(generateErrorMessageFromResponse('Publisher could not be kicked from the stream.', response))
        }
      },
    },
  }
</script>
