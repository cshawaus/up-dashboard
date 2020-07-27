<template>
  <div class="container mx-auto pb-20 pt-12">
    <h1 class="flex font-semibold items-center mb-16 text-4xl" style="color: #ff7a64;">
      <img class="h-24 mr-6 w-24" src="/images/up-yeah-logo.jpg" alt="">
      Accounts
    </h1>

    <div class="grid grid-cols-4 gap-4">
      <div class="p-6 rounded shadow-lg" v-for="account in accounts.data" :key="account.id">
        <h2 class="font-bold text-lg">{{ account.attributes.displayName }}</h2>
        <p>{{ account.attributes.accountType }}</p>
        <p>{{ account.attributes.balance.value | formatBalance }}</p>
      </div>
    </div>
  </div>
</template>

<script>
const currencyFormatter = new Intl.NumberFormat('en-AU', {
  currency : 'AUD',
  style    : 'currency',
})

export default {
  name: 'DashboardIndex',

  props: {
    accounts: {
      required : true,
      type     : Object,
    },
  },

  filters: {
    formatBalance: (value) => value ? currencyFormatter.format(parseFloat(value)) : '0.00',
  },
}
</script>
