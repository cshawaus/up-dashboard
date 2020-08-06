<template>
  <layout title="Webhooks">
    <div class="mb-12">
      <div class="grid grid-cols-4 gap-4 mb-3">
        <div class="text-center" v-if="webhooks.length === 0">
          <p>No webhooks have been created yet.</p>
        </div>
        <!-- <div
          class="bg-white cursor-pointer duration-200 ease-in-out px-10 py-8 relative rounded-lg shadow-md transform transition hover:scale-105 hover:shadow-xl"
          v-for="({ balance, identifier, name, type, updated_at }) in accounts"
          :key="identifier"
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
        </div> -->
      </div>
    </div>
  </layout>
</template>

<script>
import { format } from 'date-fns'

import Layout from '../Layout'

export default {
  name: 'WebhooksIndex',

  components: {
    Layout,
  },

  props: {
    webhooks: Array,
  },

  filters: {
    lastRequestedDate: (value) => format(new Date(value), 'MMM dd, yyyy – h:mm aaa'),
  },
}
</script>
