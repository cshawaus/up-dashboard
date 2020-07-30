<template>
  <layout title="Login">
    <div class="max-w-md mx-auto w-full">
      <FormulateForm
        class="bg-white px-8 py-10 rounded shadow-md"
        @submit="submitted = true, submit($event)"
      >
        <div class="mb-6">
          <FormulateInput
            :disabled="submitted"
            :error="errors.email ? errors.email[0] : null"
            autocomplete="email"
            label="Email Address"
            name="email"
            type="email"
            validation="required|email" />
        </div>

        <div class="mb-6">
          <FormulateInput
            :disabled="submitted"
            :error="errors.password ? errors.password[0] : null"
            autocomplete="new-password"
            label="Password"
            name="password"
            type="password"
            validation="required" />
        </div>

        <div class="mb-6">
          <FormulateInput
            checked
            label="Remember Me?"
            name="remember"
            type="checkbox" />
        </div>

        <div class="flex items-center justify-center pt-6">
          <FormulateInput
            :disabled="submitted"
            :options="{ 'disabled': submitted }"
            type="submit"
          >
            Login <span class="spinner" v-if="submitted" />
          </FormulateInput>
        </div>
      </FormulateForm>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout'

export default {
  name: 'AuthLogin',

  components: {
    Layout,
  },

  data() {
    return {
      submitted: false,
    }
  },

  props: {
    action: String,
    errors: Object,
  },

  updated() {
    this.$nextTick(() => this.submitted = false)
  },

  methods: {
    submit(formData) {
      this.$inertia.post(this.action, formData)
    },
  },
}
</script>
