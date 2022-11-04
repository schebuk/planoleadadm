import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'
import axios from './plugins/axios'
import auth from '../Auth.js'
import DatetimePicker from 'vuetify-datetime-picker'
import VueDraggable from 'vue-draggable'
import moment from 'moment';

Vue.filter('formatDate', function(value) {
  if (value) {
      return moment(String(value)).format('DD/MM/YYYY HH:mm')
  }
});

Vue.use(router)
Vue.use(auth)
Vue.use(DatetimePicker)

Vue.use(VueDraggable)

Vue.use(require('vue-resource'));

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  axios,
  auth,
  render: h => h(App),
}).$mount('#app')
