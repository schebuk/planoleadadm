import Vue from 'vue'
import VueRouter from 'vue-router'

import Auth from '../../Auth.js';

import Login from '@/views/Login.vue'
import Dashboard from '@/views/dashboard/Dashboard.vue'
import Users from '@/views/Users.vue'
import Icons from '@/views/icons/Icons.vue'
import Card from '@/views/cards/Card.vue'
import FormLayouts from '@/views/form-layouts/FormLayouts.vue'
import Error from '@/views/Error.vue'
import AccountSettings from '@/views/pages/account-settings/AccountSettings.vue'
import Register from '@/views/Register.vue'

Vue.use(VueRouter)


const routes = [
  {
    path: '/',
    redirect: 'dashboard',
  },
  { path: '/api', },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/users',
    name: 'users',
    component: Users,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/icons',
    name: 'icons',
    component: Icons,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/cards',
    name: 'cards',
    component: Card,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/form-layouts',
    name: 'form-layouts',
    component: FormLayouts,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/pages/account-settings',
    name: 'pages-account-settings',
    component: AccountSettings,
    meta:{
      requiresAuth: true,
    },
  },
  
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      layout: 'blank',
      guest: true,
      requiresAuth: false,
    },
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      layout: 'blank',
      requiresAuth: false,
    },
  },
  {
    path: '/error-404',
    name: 'error-404',
    component:Error,
    meta: {
      layout: 'blank',
      requiresAuth: false,
    },
  },
  {
    path: '*',
    redirect: 'error-404',
    requiresAuth: false,
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth) ) {
      if (Auth.check()) {
          next();
          return;
      } else {
          router.push('/login');
      }
  } else {
      next();
  }
});

export default router
