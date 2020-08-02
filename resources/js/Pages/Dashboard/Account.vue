<template>
  <layout :title="`Viewing – ${account.name}`">
    <button class="duration-200 ease-in-out font-semibold group inline-flex items-center relative text-lg text-yellow transition-colors z-20 focus:outline-none hover:text-offset-grey" @click="navigateToOverview">
      <svg class="duration-200 ease-in-out h-6 mr-3 relative transform transition-transform w-6 group-hover:-translate-x-4 group-hover:scale-125" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
      </svg>
      Back to overview
    </button>

    <div class="-mb-2 -mt-4 pr-4 relative text-right z-10">
      <h2 class="bg-yellow border-b border-up font-bold inline-block lowercase px-2 text-2xl text-up">
        About <em>up</em> account
      </h2>
    </div>

    <div class="bg-white mb-12 px-12 py-10 rounded shadow-md">
      <div class="grid grid-cols-4 gap-10 text-xl">
        <div>
          <h3 class="font-bold text-2xl text-up">Type</h3>
          <p v-if="account.type === 'SAVER'">
            <span class="text-2xl">⚡</span>
            Saver
          </p>
          <p class="capitalize" v-else>{{ account.type.toLowerCase() }}</p>
        </div>
        <div>
          <h3 class="font-bold text-2xl text-up">Balance</h3>
          <p>{{ account.balance | formatAmount }}</p>
        </div>
        <div>
          <h3 class="font-bold text-2xl text-up">Transactions</h3>
          <p>{{ transactionsCount }}</p>
        </div>
        <div>
          <h3 class="font-bold text-2xl text-up">Open Since</h3>
          <p>{{ account.created | createdDate }}</p>
        </div>
      </div>
    </div>

    <transactions title="Transactions" :transactions="transactions" />
  </layout>
</template>

<script>
import { format } from 'date-fns'

import Layout from '../Layout'
import Transactions from '../../components/Transactions'

export default {
  name: 'DashboardAccount',

  components: {
    Layout,
    Transactions,
  },

  props: {
    account           : Object,
    transactions      : Array,
    transactionsCount : Number,
  },

  methods: {
    navigateToOverview() {
      this.$inertia.replace('/')
    },
  },

  filters: {
    createdDate: (value) => format(new Date(value), 'MMMM dd, yyyy'),
  },
}
</script>
