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
        v-for="account in accounts"
        :key="account.identifier"
        @click="navigateToAccount(account.identifier)"
      >
        <span
          class="absolute right-0 text-2xl top-0 transform -translate-x-5 translate-y-3"
          v-if="account.type === 'SAVER'"
        >
          ⚡
        </span>

        <h2 class="font-bold text-lg">{{ account.name }}</h2>
        <p>{{ account.balance | formatBalance }}</p>
        <p class="text-xs">
          <strong>Updated:</strong> {{ account.updated_at | lastUpdatedDate }}
        </p>
      </div>
    </div>
  </layout>
</template>

<script>
import { format } from 'date-fns'

import Layout from '../Layout'

export default {
  name: 'DashboardOverview',

  components: {
    Layout,
  },

  props: {
    accounts: Array,
  },

  methods: {
    navigateToAccount(id) {
      this.$inertia.visit(`/account/${id}`)
    },
  },

  filters: {
    lastUpdatedDate: (value) => format(new Date(value), 'MMMM dd, yyyy'),
  },
}
</script>
