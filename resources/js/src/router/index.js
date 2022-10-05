import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '@/views/Login.vue'
import Dashboard from '@/views/dashboard/Dashboard.vue'
import Typography from '@/views/typography/Typography.vue'
import Icons from '@/views/icons/Icons.vue'
import Card from '@/views/cards/Card.vue'
import SimpleTable from '@/views/simple-table/SimpleTable.vue'
import FormLayouts from '@/views/form-layouts/FormLayouts.vue'
import Error from '@/views/Error.vue'
import AccountSettings from '@/views/pages/account-settings/AccountSettings.vue'
import Register from '@/views/Register.vue'

Vue.use(VueRouter)

function guardMyroute(to, from, next)
{
 var isAuthenticated= false;
//this is just an example. You will have to find a better or 
// centralised way to handle you localstorage data handling 
if(localStorage.getItem('LoggedUser'))
  isAuthenticated = true;
 else
  isAuthenticated= false;
 if(isAuthenticated) 
 {
  next(); // allow to enter route
 } 
 else
 {
  next('/login'); // go to '/login';
 }
}

const routes = [
  {
    path: '/',
    redirect: 'dashboard',
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    beforeEnter : guardMyroute,
    meta:{
      requiresAuth: true,
    },
    children:[
      {
        path: '/typography',
        name: 'typography',
        component: Typography,
      },
      {
        path: '/icons',
        name: 'icons',
        component: Icons,
      },
      {
        path: '/cards',
        name: 'cards',
        component: Card,
      },
      {
        path: '/simple-table',
        name: 'simple-table',
        component: SimpleTable,
      },
      {
        path: '/form-layouts',
        name: 'form-layouts',
        component: FormLayouts,
      },
      {
        path: '/pages/account-settings',
        name: 'pages-account-settings',
        component: AccountSettings,
      },
    ]
  },
  
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      layout: 'blank',
      guest: true,
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

export default router
