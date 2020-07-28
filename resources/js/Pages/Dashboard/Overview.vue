<template>
  <layout title="Overview">
    <template v-slot:header-content>
      <p class="text-sm">Get an overview of your <strong class="text-up">up</strong> account(s).</p>
    </template>

    <div class="grid grid-cols-2 gap-4">
      <div class="border border-opacity-75 border-up px-10 py-12 rounded" v-for="account in accounts.data" :key="account.id">
        <h2 class="font-bold text-lg">{{ account.attributes.displayName }}</h2>
        <p>{{ account.attributes.accountType }}</p>
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
  name: 'DashboardIndex',

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
