import 'core-js/stable'
import 'regenerator-runtime/runtime'
import 'intersection-observer'
import Vue from 'vue'
import App from './App.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import router from './router'
import VueScrollTo from 'vue-scrollto'
import round from 'vue-round-filter'
    
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/main.css'

import CodesPostaux from 'codes-postaux'
Object.defineProperty(Vue.prototype, '$CodesPostaux', { value: CodesPostaux });

Vue.config.productionTip = false
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueAxios, axios);
Vue.use(VueScrollTo);

new Vue({
  router,
  filters: {
    round
  },
  render: h => h(App, {
    props: {
      url: "https://simulateur.2020.le-site-francais.fr"
    }
  }),
}).$mount('#app')
