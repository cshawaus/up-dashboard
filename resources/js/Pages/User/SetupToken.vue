<template>
  <layout title="Set API Token">
    <template #header-content>
      <div class="max-w-3xl w-full">
        <p class="text-base">Without a token the <strong class="text-up">up</strong> API cannot be contacted, set one below!</p>
      </div>
    </template>

    <div class="max-w-4xl mx-auto w-full">
      <FormulateForm class="bg-white px-8 py-10 rounded shadow-md" @submit="submitted = true, submit($event)">
        <div
          class="bg-red-100 border border-red-400 mb-6 px-4 py-3 rounded text-red-700 text-sm"
          role="alert"
          v-if="errors.generic"
        >
          <strong class="font-bold">Hmm!</strong>
          <p class="block">{{ errors.generic[0] }}</p>
        </div>

        <div class="mb-6">
          <FormulateInput
            :disabled="submitted"
            :error="errors.token ? errors.token[0] : null"
            autocomplete="off"
            label="Up Yeah token"
            name="token"
            type="textarea"
            validation="required|starts_with:up:yeah:"
            :validation-messages="{
              starts_with: 'Invalid token provided, please ensure it begins with up:yeah:',
            }" />
        </div>

        <div class="flex items-center justify-center pt-6">
          <FormulateInput
            :disabled="submitted"
            :options="{ 'disabled': submitted }"
            type="submit"
          >
            Set Token <span class="spinner" v-if="submitted" />
          </FormulateInput>
        </div>
      </FormulateForm>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout'

export default {
  name: 'UserSetupToken',

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
