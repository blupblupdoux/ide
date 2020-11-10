import Dashboard from '../views/Dashboard.vue'
import Home from '../views/Home.vue'
import Test from '../views/Test.vue'
import Login from '../views/Login.vue'

const routes = [
    // Visitor routes
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
    // User routes
    {
      path: '/dashboard',
      name: 'Dashboard',
      component: Dashboard,
      meta: {
        requiresAuth: true,
        isAdmin: false
      }
    },
    // Admin routes
    {
      path: '/test',
      name: 'Test',
      component: Test,
      meta: {
        requiresAuth: true,
        isAdmin: true
      }
    },
]

export default routes