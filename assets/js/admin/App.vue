<template>
  <Layout v-if="authenticated">
    <template #navigation>
      <router-link
        v-for="item in $options.navItems"
        :key="item.to"
        :exact="item.exact"
        :to="item.to"
        v-slot="{ href, navigate, isActive }"
      >
        <NavigationItem :href="href" :active="isActive" @click="navigate">
          {{ item.label }}
        </NavigationItem>
      </router-link>
    </template>
    <template #mobile-navigation>
      <router-link
        v-for="item in $options.navItems"
        :key="item.to"
        :exact="item.exact"
        :to="item.to"
        v-slot="{ href, navigate, isActive }"
      >
        <MobileNavigationItem :href="href" :active="isActive" @click="navigate">
          {{ item.label }}
        </MobileNavigationItem>
      </router-link>
    </template>

    <router-view />

    <GenericErrorNotification />
  </Layout>
  <router-view v-else />
</template>

<script>
  import { mapGetters } from 'vuex'
  import Layout from './ui/layout/Layout'
  import NavigationItem from './ui/layout/NavigationItem'
  import MobileNavigationItem from './ui/layout/MobileNavigationItem'
  import GenericErrorNotification from './components/GenericErrorNotification'

  const navItems = [
    // { to: '/', label: 'Dashboard', exact: true },
    { to: '/streams', label: 'Streams' },
    { to: '/users', label: 'Users' },
  ]

  export default {
    name: 'App',
    navItems,
    components: { GenericErrorNotification, MobileNavigationItem, NavigationItem, Layout },
    computed: {
      ...mapGetters('user', ['authenticated']),
    }
  }
</script>
