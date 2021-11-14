<template>
  <div>
    <PageHeader>
      <PageTitle>Personal settings</PageTitle>
    </PageHeader>

    <PageWrapper>
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Change password</h3>
            <p class="mt-1 text-sm leading-5 text-gray-500">
              Please choose a secure password.
            </p>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <form method="POST" @submit.prevent="changePassword">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="px-4 py-5 bg-white sm:p-6">
                <Alert v-if="showSuccess" color="green" class="mb-4">
                  <template #icon>
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                  </template>
                  Password changed successfully.
                </Alert>

                <div class="grid grid-cols-3 gap-6">
                  <div class="col-span-3 sm:col-span-2">
                    <label for="password" class="block text-sm font-medium leading-5 text-gray-700">New password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input v-model="password" id="password" type="password" class="form-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>
                  </div>
                </div>
              </div>

              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button
                  :disabled="!password"
                  type="submit"
                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Save
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </PageWrapper>
  </div>
</template>

<script>
  import api from 'api'
  import PageHeader from 'ui/layout/PageHeader'
  import PageTitle from 'ui/layout/PageTitle'
  import PageWrapper from 'ui/layout/PageWrapper'
  import Alert from 'ui/alerts/Alert'

  export default {
    name: 'UserSettings',
    components: { Alert, PageWrapper, PageTitle, PageHeader },
    data() {
      return {
        password: null,
        showSuccess: false,
      }
    },
    methods: {
      async changePassword() {
        if (!this.password) {
          return
        }

        const { password } = this
        await api.post('change_password_requests', { password })
        this.password = null
        this.showSuccess = true
      },
    },
  }
</script>
