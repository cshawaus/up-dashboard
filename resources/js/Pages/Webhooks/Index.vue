<template>
  <layout title="Webhooks">
    <div class="mb-12">
      <div class="grid grid-cols-4 gap-4 mb-3">
        <div class="text-center" v-if="webhooks.length === 0">
          <p>No webhooks have been created yet.</p>
        </div>

        <template v-else>
          <div
          class="bg-white px-10 py-8 relative rounded-lg shadow-md"
          v-for="({ created_at, description, identifier, last_requested }) in webhooks"
          :key="identifier"
        >
          <p class="mb-3 text-base">{{ description }}</p>
          <p class="text-gray-600 text-xs">
            <template v-if="last_requested">
              <strong>Updated:</strong> {{ last_requested | formatDate }}<br>
            </template>
            <template v-else>
              <strong>Created:</strong> {{ created_at | formatDate }}
            </template>
          </p>
        </div>
        </template>
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
    formatDate: (value) => format(new Date(value), 'MMM dd, yyyy – h:mm aaa'),
  },
}
</script>
