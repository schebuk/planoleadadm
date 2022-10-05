import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'
import axios from './plugins/axios'
import auth from '../Auth.js'

Vue.use(router)
Vue.use(auth)

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  axios,
  auth,
  render: h => h(App),
}).$mount('#app')
