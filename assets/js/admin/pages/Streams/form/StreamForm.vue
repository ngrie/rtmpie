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
              Edit the name and slug of the stream.<br>
              <strong>Please note:</strong> The slug is part of the "stream key" used to connect to the stream within the streaming software. If it is changed, the streaming settings in your streaming software need to be adjusted as well.
            </p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form method="POST" @submit.prevent="updateStream">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="px-4 py-5 bg-white sm:p-6">
                <Alert v-if="dataChanged" class="mb-4">
                  Stream information changed since you opened this page. You should update the form to avoid overriding the new values accidentally.
                  <template #icon>
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                  </template>
                  <template #actions>
                    <p class="mt-3 text-sm leading-5 md:mt-0 md:ml-6">
                      <a
                        href="#"
                        class="whitespace-no-wrap font-medium text-blue-700 hover:text-blue-600 transition ease-in-out duration-150"
                        @click.prevent="updateForm"
                      >
                        <fa-icon :icon="['fas', 'redo']" class="mr-1" />
                        Update form
                      </a>
                    </p>
                  </template>
                </Alert>
                <StatusAlert
                  v-if="generalAlert"
                  v-bind="generalAlert"
                  class="mb-4"
                  @dismiss="generalAlert = null"
                />

                <div class="grid grid-cols-3 gap-6">
                  <div class="col-span-3 sm:col-span-2">
                    <label for="name" class="block text-sm font-medium leading-5 text-gray-700">Name</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input v-model="form.name" id="name" class="form-input block w-full sm:text-sm sm:leading-5" />
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
                      <input v-model="form.slug" id="slug" class="form-input flex-1 block w-full rounded-none rounded-r-md transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
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

      <div class="hidden sm:block">
        <div class="py-5">
          <div class="border-t border-gray-200"></div>
        </div>
      </div>

      <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
          <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
              <h3 class="text-lg font-medium leading-6 text-gray-900">Secret key</h3>
              <p class="mt-1 text-sm leading-5 text-gray-500">
                The secret key is a random token which must be specified as part of the "stream key" when connecting to the stream using a streaming software.<br>
                <a
                  href="#"
                  class="inline-block mt-1 text-sm leading-5 text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline"
                  @click.prevent="openStreamingCredentialsModal"
                >
                  Show streaming credentials
                </a>
              </p>
            </div>
          </div>
          <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="px-4 py-5 bg-white sm:p-6">
                <StatusAlert v-if="keyAlert" v-bind="keyAlert" class="mb-4" @dismiss="keyAlert = null" />
                <span class="mb-2 block text-sm font-medium leading-5 text-gray-700">Key</span>
                <CredentialsWrapper inline :value="stream.key" />
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <span class="inline-flex rounded-md shadow-sm">
                  <button
                    type="button"
                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                    @click="showRegenerateKeyDialog = true"
                  >
                    <fa-icon :icon="['fas', 'redo']" class="-ml-1 mr-2 h-5 w-5" />
                    Regenerate secret key
                  </button>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </PageWrapper>

    <DeleteStreamConfirmDialog v-model="showDeleteStreamDialog" @confirmed="deleteStream" />
    <StreamingCredentialsModal v-model="showStreamingCredentialsModal" :stream="stream" />
    <RegenerateKeyConfirmDialog v-model="showRegenerateKeyDialog" @confirmed="regenerateKey" />
  </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'
  import { generateErrorMessageFromResponse, getRtmpPrefix } from 'utils'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import PageWrapper from 'ui/layout/PageWrapper'
  import BaseButton from 'ui/BaseButton'
  import DeleteStreamConfirmDialog from './DeleteStreamConfirmDialog'
  import Alert from 'ui/alerts/Alert'
  import CredentialsWrapper from '../../../components/CredentialsWrapper'
  import StreamingCredentialsModal from '../StreamingCredentialsModal'
  import RegenerateKeyConfirmDialog from './RegenerateKeyConfirmDialog'
  import StatusAlert from 'ui/alerts/StatusAlert'

  export default {
    name: 'StreamForm',
    components: {
      StatusAlert,
      RegenerateKeyConfirmDialog,
      StreamingCredentialsModal,
      CredentialsWrapper,
      Alert,
      DeleteStreamConfirmDialog,
      BaseButton,
      PageWrapper,
      PageTitle,
      PageHeader,
    },
    props: {
      id: {
        required: true,
      },
    },
    data() {
      return {
        form: {
          name: null,
          slug: null,
        },

        showDeleteStreamDialog: false,
        showRegenerateKeyDialog: false,
        showStreamingCredentialsModal: false,
        generalAlert: null,
        keyAlert: null,
        dataChanged: false,
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
    watch: {
      stream: {
        handler(val) {
          if (!val) return
          if (this.form.name === null) {
            this.form.name = val.name
            this.form.slug = val.slug
          } else if (val.name !== this.form.name || val.slug !== this.form.slug) {
            this.dataChanged = true
          }
        },
        deep: true,
        immediate: true,
      },
    },
    methods: {
      ...mapActions('streams', ['update', 'delete']),
      async updateStream() {
        this.generalAlert = null
        const { name, slug } = this.form
        try {
          await this.update({ id: this.stream.id, data: { name, slug } })
          this.generalAlert = { type: 'success', message: 'Changes saved successfully.' }
        } catch ({ response }) {
          this.generalAlert = {
            type: 'error',
            message: generateErrorMessageFromResponse('An error occurred.', response),
          }
        }
      },
      async deleteStream() {
        await this.delete(this.stream.id)
        this.goBack()
      },
      async regenerateKey() {
        this.keyAlert = null
        try {
          await this.$store.dispatch('streams/regenerateKey', this.stream.id)
          this.keyAlert = { type: 'success', message: 'Key regenerated successfully.' }
        } catch ({ response }) {
          this.keyAlert = {
            type: 'error',
            message: generateErrorMessageFromResponse('An error occurred.', response),
          }
        }
      },
      updateForm() {
        this.form.name = this.stream.name
        this.form.slug = this.stream.slug
        this.dataChanged = false
      },
      openStreamingCredentialsModal() {
        this.showStreamingCredentialsModal = true
      },
      goBack() {
        this.$router.push({ name: 'streams' })
      },
    },
  }
</script>
