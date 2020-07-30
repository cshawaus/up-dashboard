import { InertiaApp } from '@inertiajs/inertia-vue'
import VueFormulate from '@braid/vue-formulate'
import Vue from 'vue'

// import './bootstrap'

Vue.use(InertiaApp)

Vue.use(VueFormulate, {
  classes: {
    errors : 'pt-2 text-red-600 text-sm',
    label  : 'block font-bold mb-2 text-gray-700 text-sm',

    input(context, classes) {
      let newClasses = 'appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline'

      if (context.type === 'submit' || context.type === 'button') {
        let baseButtonClasses = 'font-bold inline-flex items-center py-3 px-8 rounded'

        // HACK: Uses the 'options' property to determine the disabled state
        newClasses = baseButtonClasses + ' ' + (context.options.disabled === true
          ? 'bg-gray-200 cursor-not-allowed text-gray-600'
          : 'bg-up text-white focus:outline-none focus:shadow-outline hover:bg-opacity-75')
      }

      return [...classes, ...newClasses.split(' ')]
    },
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
