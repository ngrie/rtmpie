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
          :first="!index"
        />
      </StreamList>
    </PageWrapper>

    <AddStreamModal v-model="addModalOpen" />
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import PageWrapper from 'ui/layout/PageWrapper'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import StreamList from 'ui/streamList/StreamList'
  import BaseButton from 'ui/BaseButton'
  import StreamItem from './StreamItem'
  import AddStreamModal from './AddStreamModal'

  export default {
    name: 'Streams',
    components: { AddStreamModal, StreamItem, BaseButton, StreamList, PageTitle, PageHeader, PageWrapper },
    data() {
      return {
        addModalOpen: false,
      }
    },
    computed: {
      ...mapGetters('streams', {
        streams: 'all',
      }),
    },
  }
</script>
