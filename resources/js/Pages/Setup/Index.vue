<template>
  <layout title="Setup Dashboard">
    <template v-slot:header-content>
      <div class="max-w-3xl w-full">
        <p class="text-base">Before you can use the dashboard it is best to ensure it is secure. Create an administrator account below that will have access to manage the entire dashboard.</p>
      </div>
    </template>

    <div class="max-w-md mx-auto w-full">
      <form class="bg-white px-8 py-10 rounded shadow-md" @submit.prevent="submit">
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
            type="password"
            required>
        </div>

        <div class="mb-6">
          <label class="block font-bold mb-2 text-gray-700 text-sm" for="confirm_password">
            Confirm Password
          </label>
          <input class="appearance-none border leading-tight rounded px-3 py-3 shadow text-gray-700 w-full focus:outline-none focus:shadow-outline"
            v-model="form.confirm_password"
            autocomplete="new-password"
            id="confirm_password"
            type="password"
            required>
        </div>

        <!-- <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Password
          </label>
          <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
          <p class="text-red-500 text-xs italic">Please choose a password.</p>
        </div> -->

        <div class="flex items-center justify-center pt-6">
          <button class="bg-up font-bold text-white py-3 px-8 rounded focus:outline-none focus:shadow-outline hover:bg-opacity-75" type="submit">
            Finish Setup
          </button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout'

export default {
  name: 'SetupIndex',

  components: {
    Layout,
  },

  data() {
    return {
      form: {
        confirm_password : null,
        email            : null,
        name             : null,
        password         : null,
      },
    }
  },

  props: {
    action: String,
    errors: Object,
  },

  methods: {
    submit() {
      console.log(this.form)

      this.$inertia.post(this.action, this.form)
    },
  },
}
</script>
