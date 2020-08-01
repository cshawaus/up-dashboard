<template>
  <layout title="Overview">
    <template v-slot:header-content>
      <p class="text-sm">Get an overview of your <strong class="italic text-up">up</strong> account(s).</p>
    </template>

    <div class="text-center">
      <h2 class="bg-yellow font-bold inline-block mb-12 px-2 text-3xl text-up">Accounts &amp; Savers</h2>
    </div>

    <div class="grid grid-cols-4 gap-8">
      <div class="bg-white px-10 py-8 relative rounded shadow-md" v-for="account in accounts.data" :key="account.id">
        <svg
          v-if="account.attributes.accountType === 'SAVER'"
          class="absolute h-8 right-0 text-up top-0 transform -translate-x-4 translate-y-4 w-8"
          fill="none"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>

        <h2 class="font-bold text-lg">{{ account.attributes.displayName }}</h2>
        <p>{{ account.attributes.balance.value | formatBalance }}</p>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '../Layout'

const currencyFormatter = new Intl.NumberFormat('en-AU', {
  currency : 'AUD',
  style    : 'currency',
})

export default {
  name: 'DashboardOverview',

  components: {
    Layout,
  },

  props: {
    accounts: Object,
  },

  filters: {
    formatBalance: (value) => currencyFormatter.format(parseFloat(value)),
  },
}
</script>
