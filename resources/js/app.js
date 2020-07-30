import { InertiaApp } from '@inertiajs/inertia-vue'
import VueFormulate from '@braid/vue-formulate'
import Vue from 'vue'

Vue.use(InertiaApp)
Vue.use(VueFormulate)

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
