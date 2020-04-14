import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import vClickOutside from 'v-click-outside'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import './fontawesome'

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(vClickOutside)
Vue.component('fa-icon', FontAwesomeIcon)

import createRouter from './router'
import createStore from './store'

const store = createStore()
store.dispatch('init')

const router = createRouter(store)

import App from './App'

import '../../css/admin/admin.css'

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App),
})
