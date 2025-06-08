import { createRouter, createWebHistory } from 'vue-router'

import LoginView from './views/auth/LoginView.vue'
import RegisterView from './views/auth/RegisterView.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
