import { InertiaApp } from '@inertiajs/inertia-vue'
import VueFormulate from '@braid/vue-formulate'
import Vue from 'vue'

Vue.use(InertiaApp)
Vue.use(VueFormulate)

const currencyFormatter = new Intl.NumberFormat('en-AU', {
  currency : 'AUD',
  style    : 'currency',
})

function rand(min, max) {
  const randomNum = Math.random() * (max - min) + min

  return Math.round(randomNum)
}

Vue.filter('formatAmount', (value) => {
  return currencyFormatter.format(parseFloat(value))
  return currencyFormatter.format(parseFloat(value) + rand(100, 2000))
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
