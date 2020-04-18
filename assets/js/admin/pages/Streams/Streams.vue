<template>
  <div>
    <PageHeader>
      <PageTitle>Streams</PageTitle>
      <template #actions>
        <BaseButton color="primary" :icon="['fas', 'plus']" @click="addModalOpen = true">
          Create stream
        </BaseButton>
      </template>
    </PageHeader>

    <PageWrapper>
      <StreamList>
        <StreamItem
          v-for="(stream, index) in streams"
          :key="stream.id"
          :stream="stream"
          :thumbnail-url="thumbnailById(stream.id)"
          :first="!index"
        />
      </StreamList>
    </PageWrapper>

    <AddStreamModal v-model="addModalOpen" />
    <SseConnectionErrorNotification v-model="sseErrorNotification" />
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import PageWrapper from 'ui/layout/PageWrapper'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import StreamList from 'ui/streamList/StreamList'
  import BaseButton from 'ui/BaseButton'
  import StreamItem from './StreamItem'
  import AddStreamModal from './AddStreamModal'
  import SseConnectionErrorNotification from './SseConnectionErrorNotification'

  export default {
    name: 'Streams',
    components: {
      SseConnectionErrorNotification,
      AddStreamModal,
      StreamItem,
      BaseButton,
      StreamList,
      PageTitle,
      PageHeader,
      PageWrapper,
    },
    data() {
      return {
        addModalOpen: false,
        sseErrorNotification: false,
        thumbnailInterval: null,
      }
    },
    computed: {
      ...mapGetters('streams', {
        streams: 'all',
        liveStreams: 'liveStreams',
        thumbnailById: 'thumbnailById',
        hasSseError: 'hasSseError',
      }),
    },
    watch: {
      hasSseError: {
        handler(val) {
          if (val) {
            this.sseErrorNotification = true
          }
        },
        immediate: true,
      },
    },
    mounted() {
      this.thumbnailInterval = setInterval(() => {
        if (this.liveStreams.length) {
          this.fetchThumbnails()
        }
      }, 20000)
      this.fetchThumbnails()
    },
    beforeDestroy() {
      clearInterval(this.thumbnailInterval)
    },
    methods: {
      ...mapActions('streams', ['fetchThumbnails']),
    },
  }
</script>
