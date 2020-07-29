<template>
  <layout title="Setup Dashboard">
    <template v-slot:header-content>
      <div class="max-w-3xl w-full">
        <p class="text-base">Before you can use the dashboard it is best to ensure it is secure. Create an administrator account below that will have access to manage the entire dashboard.</p>
      </div>
    </template>

    <div class="max-w-md mx-auto w-full">
      <form class="bg-white px-8 py-10 rounded shadow-md" @submit.prevent="submitting = true, submit()">
        <div class="mb-6">
          <label class="block font-bold mb-2 text-gray-700 text-sm" for="email">
            Email Address
          </label>
          <input class="appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline"
            v-model="form.email"
            autocomplete="email"
            id="email"
            type="email"
            required>
        </div>

        <div class="mb-6">
          <label class="block font-bold mb-2 text-gray-700 text-sm" for="name">
            Name
          </label>
          <input class="appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline"
            v-model="form.name"
            autocomplete="name"
            id="name"
            type="text"
            required>
        </div>

        <div class="mb-6">
          <label class="block font-bold mb-2 text-gray-700 text-sm" for="password">
            Password
          </label>
          <input class="appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline"
            v-model="form.password"
            autocomplete="new-password"
            id="password"
            type="password">
        </div>

        <div class="mb-6">
          <label class="block font-bold mb-2 text-gray-700 text-sm" for="password_confirmation">
            Confirm Password
          </label>
          <input class="appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline"
            v-model="form.password_confirmation"
            autocomplete="new-password"
            id="password_confirmation"
            type="password">
        </div>

        <!-- <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Password
          </label>
          <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
          <p class="text-red-500 text-xs italic">Please choose a password.</p>
        </div> -->

        <div class="flex items-center justify-center pt-6">
          <button class="font-bold py-3 px-8 rounded" type="submit" :class="submitButtonClasses" :disabled="submitting">
            Finish Setup
          </button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import axios from 'axios'

import Layout from '../Layout'

export default {
  name: 'SetupIndex',

  components: {
    Layout,
  },

  data() {
    return {
      form: {
        email                 : null,
        name                  : null,
        password              : null,
        password_confirmation : null,
      },

      submitting: false,
    }
  },

  props: {
    action: String,
  },

  computed: {
    submitButtonClasses: function() {
      const submitting = this.submitting

      return {
        'bg-gray-200 cursor-not-allowed text-gray-600': submitting,
        'bg-up text-white focus:outline-none focus:shadow-outline hover:bg-opacity-75': !submitting,
      }
    },
  },

  methods: {
    submit() {
      axios.post(this.action, this.form).then((response) => {
        this.submitting = false

        console.log(response)
      })
    },
  },
}
</script>
