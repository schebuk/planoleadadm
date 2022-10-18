import Vue from 'vue'

import axios from 'axios'

window.axios = axios;

const axiosIns = axios.create({
  baseURL: process.env.APP_URL,
})

Vue.prototype.$http = axiosIns

export default axiosIns