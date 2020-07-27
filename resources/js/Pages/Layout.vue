<template>
  <main class="bg-gray-900 overflow-y-auto text-white" scroll-region>
    <header class="bg-white py-8 sticky top-0">
      <div class="container mx-auto">
        <h1 class="flex font-semibold items-center text-4xl text-up">
          <img class="h-20 mr-6 w-20" src="/images/up-yeah-logo.jpg" alt="">
          {{ title }}
        </h1>
      </div>
    </header>

    <article class="container mx-auto py-12">
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
        document.title = `${title} | up yeah dashboard`
      },
    },
  },
}
</script>
