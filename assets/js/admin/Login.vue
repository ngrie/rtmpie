<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
      <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
        Sign in
      </h2>
      <form class="mt-8" action="/login" method="POST" @submit.prevent="login">
        <div class="rounded-md shadow-sm">
          <div>
            <input ref="usernameInput" v-model="username" aria-label="Username" name="username" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Username" />
          </div>
          <div class="-mt-px">
            <input v-model="password" aria-label="Password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
          </div>
        </div>

        <!--<div class="mt-6 flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
            <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
              Remember me
            </label>
          </div>
        </div>-->

        <div class="mt-6">
          <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400 transition ease-in-out duration-150" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
            Sign in
          </button>
        </div>
      </form>
    </div>

    <Notification error :value="loginFailed" @input="loginFailed = false">
      <template #icon>
        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
      </template>
      <template #title>
        Login failed
      </template>

      Please check your credentials and try again.
    </Notification>
  </div>
</template>

<script>
  import { mapActions } from 'vuex'
  import Notification from 'ui/notifications/Notification'

  export default {
    name: 'Login',
    components: { Notification },
    data() {
      return {
        username: null,
        password: null,
        loading: false,
        loginFailed: false,
      }
    },
    mounted() {
      setTimeout(() => {
        if (this.$refs.usernameInput) {
          this.$refs.usernameInput.focus()
        }
      }, 200)
    },
    methods: {
      ...mapActions({
        storeLogin: 'user/login',
      }),
      async login() {
        const { username, password } = this

        this.loginFailed = false
        this.loading = true
        try {
          await this.storeLogin({ username, password })
          this.$router.push('/')
        } catch (e) {
          this.loginFailed = true
        } finally {
          this.loading = false
        }
      },
    },
  }
</script>
