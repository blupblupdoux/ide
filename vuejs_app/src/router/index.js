import store from '../store/index.js'
import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../views/Home.vue'
import Test from '../views/Test.vue'
import Login from '../views/Login.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/connexion',
    name: 'Login',
    component: Login
  },
  {
    path: '/test',
    name: 'Test',
    component: Test,
    meta: {
      requiresAuth: true,
    }
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {

  if(to.matched.some(record => record.meta.requiresAuth)) {

    if (store.getters.isLoggedIn) {

      next()
      return
    }

    next('/connexion')
    
  } else {
    next()
  }
})

export default router
