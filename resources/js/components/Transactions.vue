<template>
  <div class="relative">
    <div class="sticky top-0">
      <div class="bg-up absolute h-full left-0 -mx-2 -mt-2 p-4 right-0 top-0"></div>

      <div class="flex justify-between relative z-10">
        <h2 class="bg-offset-grey font-bold inline-block mb-4 px-2 text-2xl text-up">{{ title }}</h2>

        <div v-if="meta && meta.current_page">
          <inertia-link
            class="font-semibold text-yellow"
            :href="meta.prev_page_url"
            :only="['transactions']"
            v-if="meta.current_page > 1 || meta.next_page_url === null"
          >
            Previous
          </inertia-link>

          <inertia-link
            class="font-semibold ml-4 text-yellow"
            :href="meta.next_page_url"
            :only="['transactions']"
            v-if="meta.current_page < meta.last_page"
          >
            Next
          </inertia-link>
        </div>
      </div>
    </div>

    <div class="space-y-1" v-if="transactions.length">
      <div
        class="bg-white gap-4 grid grid-cols-3 grid-flow-col-dense px-12 py-5 rounded shadow"
        v-for="({ account, amount, description, identifier, message, status }) in transactions" :key="identifier"
      >
        <div class="flex items-center">
          <div class="flex-shrink-0 w-16">
            <svg class="h-10 text-offset-grey w-10" fill="currentColor" viewBox="0 0 20 20">
              <template v-if="status === 'HELD'">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </template>
              <template v-else-if="description === 'Round Up'">
                <path class="text-green-500" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
              </template>
              <template v-else-if="status === 'SETTLED'">
                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
              </template>
            </svg>
          </div>

          <div>
            <span class="font-semibold">{{ description }}</span>
            <p class="text-gray-600 text-sm">
              <strong>Message:</strong> {{ message || 'n/a' }}
            </p>
          </div>
        </div>

        <div>
          <span>{{ amount | formatAmount }}</span>
        </div>

        <div v-if="account && account.type === 'SAVER'">
          <p class="font-bold">Sent to</p>
          <span class="text-sm">{{ account.name }}</span>
        </div>
        <div v-else>
          <p class="font-bold">Status</p>
          <span class="capitalize text-sm">{{ status.toLowerCase() }}</span>
        </div>
      </div>
    </div>

    <p v-else>No transactions are currently available for this account.</p>
  </div>
</template>

<script>
export default {
  name: 'Transactions',

  props: {
    meta         : Object,
    title        : String,
    transactions : Array,
  },
}
</script>
