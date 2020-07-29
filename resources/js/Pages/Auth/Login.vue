<template>
  <form @submit.prevent="submit">
    <label for="email">Email:</label>
    <input id="email" v-model="form.email" />
    <p v-if="errors.email">{{ errors.email[0] }}</p>

    <label for="password">Password:</label>
    <input id="password" v-model="form.password" />
    <p v-if="errors.password">{{ errors.password[0] }}</p>

    <button type="submit">Submit</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email    : null,
        password : null,
      },
    }
  },

  props: {
    action: String,
    errors: Object,
  },

  methods: {
    submit() {
      this.$inertia.post(this.action, this.form)
    },
  },
}
</script>
