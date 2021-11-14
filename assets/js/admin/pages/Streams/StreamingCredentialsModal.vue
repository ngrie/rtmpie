<template>
  <Modal v-bind="$attrs" v-on="$listeners">
    <ModalTitle>Streaming credentials for {{ stream.name }}</ModalTitle>

    <div class="mt-5 border-t border-gray-200 pt-5">
      <dl>
        <div class="items-center sm:grid sm:grid-cols-3 sm:gap-4">
          <dt class="text-sm leading-5 font-medium text-gray-500">
            Server
          </dt>
          <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
            <CredentialsWrapper :value="server" class="w-full" />
          </dd>
        </div>
        <div class="mt-8 items-center sm:grid sm:mt-5 sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:pt-5">
          <dt class="text-sm leading-5 font-medium text-gray-500">
            Stream key
          </dt>
          <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
            <CredentialsWrapper :value="streamKey" />
          </dd>
        </div>
      </dl>
    </div>

    <template #actions>
      <BaseButton
        class="mt-3 flex w-full sm:ml-3 sm:mt-0 sm:w-auto"
        button-class="justify-center w-full text-base leading-6 shadow-sm focus:ring-indigo-500 sm:text-sm sm:leading-5"
        @click="$emit('input', false)"
      >
        Close
      </BaseButton>
    </template>
  </Modal>
</template>

<script>
  import { getRtmpPrefix } from 'utils'
  import Modal from 'ui/modals/Modal'
  import ModalTitle from 'ui/modals/ModalTitle'
  import BaseButton from 'ui/BaseButton'
  import CredentialsWrapper from '../../components/CredentialsWrapper'

  export default {
    name: 'StreamingCredentialsModal',
    components: { CredentialsWrapper, BaseButton, ModalTitle, Modal },
    props: {
      stream: {
        type: Object,
        required: true,
      },
    },
    computed: {
      server() {
        return getRtmpPrefix()
      },
      streamKey() {
        return `${this.stream.slug}?key=${this.stream.key}`
      },
    },
  }
</script>
