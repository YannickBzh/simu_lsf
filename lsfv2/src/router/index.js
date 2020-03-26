import Vue from 'vue'
import Router from 'vue-router'

import Index from '@/components/general/index.vue'
import Recap from '@/components/recap/Recap.vue'

Vue.use(Router)
export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index
    },
    {
      path: '/recap',
      name: 'Recap',
      component: Recap
    }
  ]
})