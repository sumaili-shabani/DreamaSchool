

/* resources > js > app.js */


require('./bootstrap');

import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import '@mdi/font/css/materialdesignicons.css'
window.Vue = require('vue');

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'


import ApexCharts from 'apexcharts'
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

Vue.component('font-awesome-icon', FontAwesomeIcon) // Register component globally
library.add(fas) // Include needed icons



// Vue.component('app-init', require('./AppInit.vue').default);
// Vue.component('login', require('./emerfine/login.vue').default);
// Vue.component('register', require('./emerfine/register.vue').default);


import Core from './mixins/core'
Vue.mixin(Core);
import Vuex from 'vuex';
Vue.use(Vuex);


import Toasted from 'vue-toasted';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);
Vue.use(Toasted);

import shareData from './store/index';
const store = new Vuex.Store(
  shareData
);

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify);


import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap and BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    `${window.emerfine.baseURL}/css/styles.css`  

  ],
  timeout: 1000, // default timeout before the print window appears
  autoClose: true, // if false, the window will not close after printing
  windowTitle: window.document.title, // override the window title
}

Vue.component('login', require('./VueBackend/LoginPage.vue').default);
Vue.component('register', require('./VueBackend/RegisterPage.vue').default);
Vue.component('dashboard', require('./VueBackend/AdminPage.vue').default);
// Vue.use(VueHtmlToPaper, options);
// Vue.use(VueHtmlToPaper);

import VueHtmlToPaper from 'vue-html-to-paper';
Vue.use(VueHtmlToPaper, options);
Vue.use(VueHtmlToPaper);

import router  from './router';
import appCss from './app.css';


const app = new Vue({
  el: '#app',
  router,
  vuetify: new Vuetify(),
  store
});



