<template>
  <layout :title="`Viewing – ${account.data.attributes.displayName}`">
    <button class="duration-200 ease-in-out font-semibold group inline-flex items-center relative text-lg text-yellow transition-colors z-20 focus:outline-none hover:text-offset-grey" @click="navigateToOverview">
      <svg class="duration-200 ease-in-out h-6 mr-3 relative transform transition-transform w-6 group-hover:-translate-x-4 group-hover:scale-125" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
      </svg>
      Back to overview
    </button>

    <div class="-mt-8 relative text-center z-10">
      <h2 class="bg-yellow border-b border-up font-bold inline-block lowercase px-2 text-3xl text-up">
        About <em>up</em> account
      </h2>
    </div>

    <div class="bg-white mb-12 -mt-2 px-12 py-10 rounded shadow-md sticky top-0">
      <div class="grid grid-cols-4 gap-10 text-xl">
        <div>
          <h3 class="font-bold text-2xl text-up">Type</h3>
          <p v-if="account.data.attributes.accountType === 'SAVER'">
            <span class="text-2xl">⚡</span>
            Saver
          </p>
          <p class="capitalize" v-else>{{ account.data.attributes.accountType.toLowerCase() }}</p>
        </div>
        <div>
          <h3 class="font-bold text-2xl text-up">Balance</h3>
          <p>{{ account.data.attributes.balance.value | formatBalance }}</p>
        </div>
        <div>
          <h3 class="font-bold text-2xl text-up">Transactions</h3>
          <p>–</p>
        </div>
        <div>
          <h3 class="font-bold text-2xl text-up">Open Since</h3>
          <p>{{ account.data.attributes.createdAt | createdDate }}</p>
        </div>
      </div>
    </div>

    <h2 class="font-bold mb-4 text-4xl text-yellow">Transactions</h2>
    <div class="space-y-1">
      <div
        class="bg-white px-12 py-5 rounded shadow"
        v-for="({ attributes, id }) in transactions.data" :key="id"
      >
        <span class="font-semibold">{{ attributes.description }}</span>
      </div>
    </div>
  </layout>
</template>

<script>
import { format } from 'date-fns'
import Layout from '../Layout'

export default {
  name: 'DashboardAccount',

  components: {
    Layout,
  },

  props: {
    account      : Object,
    transactions : Object,
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
