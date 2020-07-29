<template>
  <main class="bg-gray-100 overflow-y-auto" scroll-region>
    <header class="bg-white border-b-2 border-gray-200 py-6 sticky top-0">
      <div class="container flex items-center justify-between mx-auto">
        <div class="text-gray-800">
          <h1 class="font-semibold leading-snug text-3xl text-up">{{ title }}</h1>
          <slot name="header-content" />
        </div>

        <img class="h-16 w-16" :src="`${$page['app.url']}images/up-yeah-logo.jpg`" alt="">
      </div>
    </header>

    <article class="container mx-auto py-20">
      <slot />
    </article>
  </main>
</template>

<script>
export default {
  props: {
    title: String,
  },

  watch: {
    title: {
      immediate: true,

      handler(title) {
        document.title = `${title} | ${this.$page['app.name']}`
      },
    },
  },
}
</script>
