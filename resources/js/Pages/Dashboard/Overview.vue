<template>
  <layout title="Overview">
    <template v-slot:header-content>
      <p class="text-sm">Get an overview of your <strong class="italic text-up">up</strong> account(s).</p>
    </template>

    <div class="text-center">
      <h2 class="bg-yellow font-bold inline-block mb-12 px-2 text-3xl text-up">Accounts &amp; Savers</h2>
    </div>

    <div class="grid grid-cols-4 gap-8">
      <div
        class="bg-white cursor-pointer duration-200 ease-in-out px-10 py-8 relative rounded-lg shadow-md transform transition hover:scale-110 hover:shadow-xl"
        v-for="account in accounts.data"
        :key="account.id"
        @click="navigateToAccount(account.id)"
      >
        <span
          class="absolute right-0 text-2xl top-0 transform -translate-x-5 translate-y-3"
          v-if="account.attributes.accountType === 'SAVER'"
        >
          ⚡
        </span>

        <h2 class="font-bold text-lg">{{ account.attributes.displayName }}</h2>
        <p>{{ account.attributes.balance.value | formatBalance }}</p>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout'

export default {
  name: 'DashboardOverview',

  components: {
    Layout,
  },

  props: {
    accounts: Object,
  },

  methods: {
    navigateToAccount(id) {
      this.$inertia.visit(`/account/${id}`)
    },
  },
}
</script>
