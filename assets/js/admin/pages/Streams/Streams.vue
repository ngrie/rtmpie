<template>
  <div>
    <PageHeader>
      <PageTitle>Streams</PageTitle>
      <template #actions>
        <BaseButton :icon="['fas', 'plus']">
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
  </div>
</template>

<script>
  import api from 'api'
  import PageWrapper from 'ui/layout/PageWrapper'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import StreamList from 'ui/streamList/StreamList'
  import BaseButton from 'ui/BaseButton'
  import StreamItem from './StreamItem'

  export default {
    name: 'Streams',
    components: { StreamItem, BaseButton, StreamList, PageTitle, PageHeader, PageWrapper },
    data() {
      return {
        streams: [],
      }
    },
    async mounted() {
      const { data } = await api('streams')
      this.streams = data
    },
  }
</script>
