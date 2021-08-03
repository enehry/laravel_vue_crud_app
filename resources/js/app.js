require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'
import App from './views/App.vue'

// global variable for user
import User from './helper/user.js'
window.User = User

// Notification
import Notification from './helper/notification'
window.Notification = Notification

// Sweet Alert
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  window.Toast = Toast

  import CONSTS from './constants.js'
  window.CONSTS = CONSTS

Vue.use(VueRouter)

const router = new VueRouter({
    routes,
    mode: 'history'
})


const app = new Vue({
    el: '#app',
    router,
    render: h => h(App),
});
