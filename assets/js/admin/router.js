import VueRouter from 'vue-router'

import Login from './Login'
import Dashboard from './pages/Dashboard'
import Streams from './pages/Streams'

const routes = [
  { path: '/login', component: Login, name: 'login' },

  { path: '/', component: Dashboard },
  { path: '/streams', component: Streams },
]

const createRouter = (store) => {
  const router = new VueRouter({
    mode: 'history',
    base: '/admin',
    routes,
  })

  router.beforeEach((to, from, next) => {
    const proceed = () => {
      if ((store.getters['user/authenticated'] && to.name !== 'login') ||
        (!store.getters['user/authenticated'] && to.name === 'login')) {
        next()
      } else if (store.getters['user/authenticated'] && to.name === 'login') {
        next('/')
      } else {
        next('/login')
      }
    }

    if (store.getters['user/checkedAuthentication']) {
      proceed()
    } else {
      store.watch(() => store.getters['user/checkedAuthentication'], () => {
        if (store.getters['user/checkedAuthentication']) {
          proceed()
        }
      })
    }
  })

  return router
}

export default createRouter
