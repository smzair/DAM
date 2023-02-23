/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
window.Vue = require('vue');
window.Fire = new Vue();
import {BootstrapVue , IconsPlugin } from 'bootstrap-vue'

Vue.use( BootstrapVue)
Vue.use(IconsPlugin)



import VueToastr from "vue-toastr";
Vue.use(VueToastr, {
  defaultTimeout: 3000,
  defaultPosition: "toast-top-right",

});


import moment from 'moment';
Vue.filter("date",function(created){
  return  moment(created).format('MMMM Do YYYY, h:mm:ss a');
  ;
})



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Swal from 'sweetalert2'

window.swal=Swal;
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
  });

 
  window.toast= Toast;
  
  import { BFormTags } from 'bootstrap-vue'
  Vue.component('b-form-tags', BFormTags)
 
  import { Form, HasError, AlertError } from 'vform'
  window.Form =Form; 
  Vue.component(HasError.name, HasError)
  Vue.component(AlertError.name, AlertError)
  
  require('./component');
  const app = new Vue({
    el: '#app'
});


  

