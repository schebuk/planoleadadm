import Vue from 'vue'
import VueRouter from 'vue-router'

import Auth from '../../Auth.js';

import Login from '@/views/Login.vue'
import Dashboard from '@/views/dashboard/Dashboard.vue'
import Users from '@/views/Users.vue'
import UsersTrash from '@/views/UsersTrash.vue'
import Segments from '@/views/Segments.vue'
import SegmentsTrash from '@/views/SegmentsTrash.vue'
import Rules from '@/views/Rules.vue'
import RulesTrash from '@/views/RulesTrash.vue'
import Quality from '@/views/Quality.vue'
import QualityTrash from '@/views/QualityTrash.vue'
import Ads from '@/views/Ads.vue'
import AdsTrash from '@/views/AdsTrash.vue'
import Integrants from '@/views/Integrants.vue'
import IntegrantsTrash from '@/views/IntegrantsTrash.vue'
import Clients from '@/views/Clients.vue'
import ClientsTrash from '@/views/ClientsTrash.vue'
import ClientsUser from '@/views/ClientsUser.vue'
import ClientsUserTrash from '@/views/ClientsUserTrash.vue'
import Leads from '@/views/Leads.vue'
import LeadsTrash from '@/views/LeadsTrash.vue'
import Error from '@/views/Error.vue'
import Configurations from '@/views/Configurations.vue'
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
    path: '/users/trash',
    name: 'users-trash',
    component: UsersTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/segments',
    name: 'segments',
    component: Segments,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/segments/trash',
    name: 'segments-trash',
    component: SegmentsTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/rules',
    name: 'rules',
    component: Rules,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/rules/trash',
    name: 'rules-trash',
    component: RulesTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/quality',
    name: 'quality',
    component: Quality,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/quality/trash',
    name: 'quality-trash',
    component: QualityTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/ads',
    name: 'ads',
    component: Ads,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/ads/trash',
    name: 'ads-trash',
    component: AdsTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/integrants',
    name: 'integrants',
    component: Integrants,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/integrants/trash',
    name: 'integrants-trash',
    component: IntegrantsTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/clients',
    name: 'clients',
    component: Clients,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/clients/trash',
    name: 'clients-trash',
    component: ClientsTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/clients-user',
    name: 'clients-user',
    component: ClientsUser,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/clients-user/trash',
    name: 'clients-user-trash',
    component: ClientsUserTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/leads',
    name: 'leads',
    component: Leads,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/leads/trash',
    name: 'leads-trash',
    component: LeadsTrash,
    meta:{
      requiresAuth: true,
    },
  },
  {
    path: '/configs',
    name: 'configs',
    component: Configurations,
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
