import Dashboard from '../views/Dashboard.vue'
import Home from '../views/Home.vue'
import Users from '../views/Users.vue'
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
      path: '/utilisateurs',
      name: 'Users',
      component: Users,
      meta: {
        requiresAuth: true,
        isAdmin: true
      }
    },
]

export default routes