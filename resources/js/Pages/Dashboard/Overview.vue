<template>
  <layout title="Overview">
    <template v-slot:header-content>
      <p class="text-sm">Get an overview of your <strong class="italic text-up">up</strong> account(s).</p>
    </template>

    <div class="text-center">
      <h2 class="bg-yellow font-bold inline-block mb-12 px-2 text-3xl text-up">Accounts &amp; Savers</h2>
    </div>

    <div class="mb-12">
      <div class="grid grid-cols-4 gap-4 mb-3">
        <div
          class="bg-white cursor-pointer duration-200 ease-in-out px-10 py-8 relative rounded-lg shadow-md transform transition hover:scale-105 hover:shadow-xl"
          v-for="({ balance, identifier, name, type, updated_at }) in accounts"
          :key="identifier"
          @click="navigateToAccount(identifier)"
        >
          <span
            class="absolute right-0 text-2xl top-0 transform -translate-x-5 translate-y-3"
            v-if="type === 'SAVER'"
          >
            ⚡
          </span>

          <h3 class="font-bold text-lg truncate">{{ name }}</h3>
          <p class="mb-1">{{ balance | formatAmount }}</p>
          <p class="text-gray-600 text-xs">
            <strong>Updated:</strong> {{ updated_at | lastUpdatedDate }}
          </p>
        </div>
      </div>

      <p class="text-xs">
        Accounts are only updated when new information is available, otherwise the <strong>updated date</strong> won't change. <inertia-link class="underline" href="/?updateAccounts=1" :only="['accounts']">Update accounts</inertia-link> manually.
      </p>
    </div>

    <transactions title="Last 5 Transactions" :transactions="transactions" />
  </layout>
</template>

<script>
import { format } from 'date-fns'

import Layout from '../Layout'
import Transactions from '../../components/Transactions'

export default {
  name: 'DashboardOverview',

  components: {
    Layout,
    Transactions,
  },

  props: {
    accounts     : Array,
    transactions : Array,
  },

  methods: {
    navigateToAccount(id) {
      this.$inertia.visit(`/account/${id}`)
    },
  },

  filters: {
    lastUpdatedDate: (value) => format(new Date(value), 'MMM dd, yyyy – h:mm aaa'),
  },
}
</script>
