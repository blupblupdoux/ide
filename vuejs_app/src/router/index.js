import store from '../store/index.js'
import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes.js'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {

  if(to.matched.some(record => record.meta.requiresAuth)) { // check if need to be connected

    if (store.getters.isLoggedIn) { // I need to be connected so I check if I am

      if(to.matched.some(record => record.meta.isAdmin)) { // Check if need to be admin

          if(store.state.auth.user.roles.includes('ROLE_ADMIN')) { // I need to be admin so I check if I am
            next() // I need to be admin and I am, move on to the page
            return

          } else {
            console.log('401 : je dois etre admin et je le suis pas')
          }

      } else {
        next() // I'm connected and I don't need to be admin, move on to the page
        return
      }

    } else {
      next('/connexion') // Need to be connected and I'm not, go to connexion page
    }

  } else {
    next() // Don't need to be connected, move on to the page
  }
})

export default router
