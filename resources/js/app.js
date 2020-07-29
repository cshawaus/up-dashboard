import { InertiaApp } from '@inertiajs/inertia-vue'
import VueFormulate from '@braid/vue-formulate'
import Vue from 'vue'

import './bootstrap'

Vue.use(InertiaApp)

Vue.use(VueFormulate, {
  classes: {
    errors : 'pt-2 text-red-600 text-sm',
    input  : 'appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline',
    label  : 'block font-bold mb-2 text-gray-700 text-sm',
  },
})

const app = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),

      async resolveComponent(name) {
        return import(/* webpackChunkName: "js/pages/[request]" */ `./pages/${name}`)
          .then(module => module.default)
      },
    },
  }),
}).$mount(app)
