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
  baseURL: process.env.APP_URL,
})

Vue.prototype.$http = axiosIns

export default axiosIns