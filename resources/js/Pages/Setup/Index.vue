<template>
  <layout title="Setup Dashboard">
    <template #header-content>
      <div class="max-w-3xl w-full">
        <p class="text-base">Before you can use the dashboard it is best to ensure it is secure. Create an administrator account below that will have access to manage the entire dashboard.</p>
      </div>
    </template>

    <div class="max-w-md mx-auto w-full">
      <FormulateForm class="bg-white px-8 py-10 rounded shadow-md" @submit="submitted = true, submit($event)">
        <div class="mb-6">
          <FormulateInput
            autocomplete="email"
            label="Email Address"
            name="email"
            type="email"
            validation="required|email" />
        </div>

        <div class="mb-6">
          <FormulateInput
            autocomplete="name"
            label="Name"
            name="name"
            type="text"
            validation="required" />
        </div>

        <div class="mb-6">
          <FormulateInput
            autocomplete="new-password"
            label="Password"
            name="password"
            type="password"
            validation="required" />
        </div>

        <div class="mb-6">
          <FormulateInput
            autocomplete="new-password"
            label="Confirm Password"
            name="password_confirmation"
            type="password"
            validation="required|confirm:password"
            validation-name="Password confirmation" />
        </div>

        <!-- <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Password
          </label>
          <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
          <p class="text-red-500 text-xs italic">Please choose a password.</p>
        </div> -->

        <div class="flex items-center justify-center pt-6">
          <FormulateInput
            :disabled="submitted"
            :options="{ 'disabled': submitted }"
            type="submit"
          >
            Finish Setup <span class="spinner" v-if="submitted" />
          </FormulateInput>
        </div>
      </FormulateForm>
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
      submitted: false,
    }
  },

  props: {
    action   : String,
    errors   : Object,
    redirect : String,
  },

  updated() {
    this.submitted = false

    // if ()
  },

  methods: {
    submit(formData) {
      this.$inertia.post(this.action, formData)

      // axios.post(this.action, formData).then(({ data, status }) => {
      //   if (status === 200) {
      //     this.$inertia.visit(this.redirect)
      //   }
      // }).finally(() => this.submitting = false)
    },
  },
}
</script>
