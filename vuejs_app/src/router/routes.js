import Home from '../views/Home.vue'
import Test from '../views/Test.vue'
import Login from '../views/Login.vue'

const routes = [
    {
      path: '/',
      name: 'Home',
      component: Home,
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
        isAdmin: true
      }
    }
]

export default routes