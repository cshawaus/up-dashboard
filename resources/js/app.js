import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'

import './bootstrap'

Vue.use(InertiaApp)

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
