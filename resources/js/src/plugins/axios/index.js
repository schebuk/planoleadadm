import Vue from 'vue'

// axios
import axios from 'axios'

window.axios = axios;
/*
axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};*/

const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: 'http://planoleadadm.test',
  // timeout: 1000,
  // headers: {'X-Custom-Header': 'foobar'}
})

Vue.prototype.$http = axiosIns

export default axiosIns