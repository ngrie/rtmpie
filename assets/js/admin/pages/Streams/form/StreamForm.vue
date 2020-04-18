<template>
  <div v-if="stream">
    <PageHeader>
      <PageTitle>{{ stream.name }}</PageTitle>
      <template #actions>
        <BaseButton
          :disabled="stream.live"
          color="red"
          :icon="['fas', 'trash']"
          @click="showDeleteStreamDialog = true"
        >
          Delete stream
        </BaseButton>
        <BaseButton :icon="['fas', 'chevron-left']" class="ml-3" @click="goBack">
          Back
        </BaseButton>
      </template>
    </PageHeader>

    <PageWrapper>
      <Alert v-if="stream.live" class="mb-6">
        <template #icon>
          <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
          </svg>
        </template>

        While the stream is live, it cannot be deleted and the slug cannot be edited.
      </Alert>

      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">General</h3>
            <p class="mt-1 text-sm leading-5 text-gray-500">
              Name, stream key etc.
            </p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form method="POST" @submit.prevent="updateStream">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-3 gap-6">
                  <div class="col-span-3 sm:col-span-2">
                    <label for="name" class="block text-sm font-medium leading-5 text-gray-700">Name</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input v-model="stream.name" id="name" class="form-input block w-full sm:text-sm sm:leading-5" />
                    </div>
                  </div>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-6">
                  <div class="col-span-3 sm:col-span-2">
                    <label for="slug" class="block text-sm font-medium leading-5 text-gray-700">
                      Slug
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                      <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        {{ rtmpPrefix }}
                      </span>
                      <input v-model="stream.slug" id="slug" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <span class="inline-flex rounded-md shadow-sm">
                  <button
                    :disabled="stream.live"
                    type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                  >
                    Save
                  </button>
                </span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </PageWrapper>

    <DeleteStreamConfirmDialog v-model="showDeleteStreamDialog" @confirmed="deleteStream" />
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import { getRtmpPrefix } from 'utils'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import PageWrapper from 'ui/layout/PageWrapper'
  import BaseButton from 'ui/BaseButton'
  import DeleteStreamConfirmDialog from './DeleteStreamConfirmDialog'
  import Alert from 'ui/alerts/Alert'

  export default {
    name: 'StreamForm',
    components: { Alert, DeleteStreamConfirmDialog, BaseButton, PageWrapper, PageTitle, PageHeader },
    props: {
      id: {
        required: true,
      },
    },
    data() {
      return {
        showDeleteStreamDialog: false,
      }
    },
    computed: {
      ...mapGetters('streams', {
        streamById: 'byId',
      }),
      stream() {
        return this.streamById(this.id)
      },
      rtmpPrefix() {
        return `${getRtmpPrefix()}/`
      },
    },
    methods: {
      ...mapActions('streams', ['update', 'delete']),
      updateStream() {
        const { name, slug } = this.stream
        this.update({ id: this.stream.id, data: { name, slug } })
      },
      async deleteStream() {
        await this.delete(this.stream.id)
        this.goBack()
      },
      goBack() {
        this.$router.push({ name: 'streams' })
      },
    },
  }
</script>
