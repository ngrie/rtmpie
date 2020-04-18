<template>
  <div>
    <nav class="bg-gray-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="h-8 w-8">
                RTMPie
              </div>
            </div>
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline">
                <slot name="navigation" />
              </div>
            </div>
          </div>
          <div class="hidden md:block">
            <div class="ml-4 flex items-center md:ml-6">
              <div v-click-outside="closeUserMenu" class="ml-3 relative">
                <div>
                  <button @click="userMenuOpen = !userMenuOpen" class="max-w-xs flex items-center text-sm rounded-full text-gray-200 focus:outline-none" id="user-menu" aria-label="User menu" aria-haspopup="true" :aria-expanded="userMenuOpen">
                    <fa-icon :icon="['far', 'user']" class="h-8 w-8" size="2x" />
                  </button>
                </div>
                <transition enter-active-class="transition ease-out duration-100" enter-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <div
                    v-if="userMenuOpen"
                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg"
                    @click="closeUserMenu"
                  >
                    <div class="py-1 rounded-md bg-white shadow-xs">
                      <div class="px-4 py-2 text-sm text-gray-500 border-b border-gray-200">
                        {{ user.username }}
                      </div>
                      <router-link
                        :to="{ name: 'user_settings' }"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      >
                        Personal settings
                      </router-link>
                      <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                    </div>
                  </div>
                </transition>
              </div>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <button @click="navigationOpen = !navigationOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white" :aria-label="navigationOpen ? 'Close main menu' : 'Main menu'" :aria-expanded="navigationOpen">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ hidden: navigationOpen, 'inline-flex': !navigationOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ hidden: !navigationOpen, 'inline-flex': navigationOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <div :class="{ block: navigationOpen, hidden: !navigationOpen }" class="md:hidden" @click="navigationOpen = false">
        <div class="px-2 pt-2 pb-3 sm:px-3">
          <slot name="mobile-navigation" />
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
          <div class="flex items-center px-5">
            <div class="flex-shrink-0">
              <fa-icon :icon="['far', 'user']" class="h-10 w-10 text-white" size="2x" />
            </div>
            <div class="ml-3">
              <div class="text-base font-medium leading-none text-white">
                {{ user.username }}
              </div>
            </div>
          </div>
          <div class="mt-3 px-2" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
            <a href="#" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700" role="menuitem">User settings</a>
            <a href="/logout" class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700" role="menuitem">Sign out</a>
          </div>
        </div>
      </div>
    </nav>
    <slot />
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'Layout',
    data() {
      return {
        navigationOpen: false,
        userMenuOpen: false,
      }
    },
    created: function () {
      window.addEventListener('keydown', this.onkey)
    },
    beforeDestroy: function () {
      window.removeEventListener('keydown', this.onkey)
    },
    computed: {
      ...mapGetters('user', ['user']),
    },
    methods: {
      closeUserMenu() {
        this.userMenuOpen = false
      },
      onkey(event) {
        if (event.key === 'Escape') {
          this.closeUserMenu()
        }
      }
    },
  }
</script>
