<template>
    <nav class="flex items-center justify-between">
      <button
        :disabled="!links.prev"
        @click="navigate(links.prev)"
        class="px-4 py-2 mr-2 bg-gray-300 rounded-md hover:bg-gray-400 disabled:opacity-50"
      >
        &laquo; Previous
      </button>
  
      <ul class="flex">
        <li
          v-for="link in links.pages"
          :key="link.url"
          :class="[{ 'font-bold': link.active }, 'px-4 py-2']"
          @click="link.url && navigate(link.url)"
          class="cursor-pointer hover:underline"
        >
          {{ link.label }}
        </li>
      </ul>
  
      <button
        :disabled="!links.next"
        @click="navigate(links.next)"
        class="px-4 py-2 ml-2 bg-gray-300 rounded-md hover:bg-gray-400 disabled:opacity-50"
      >
        Next &raquo;
      </button>
    </nav>
  </template>
  
  <script>
  export default {
    props: {
      links: {
        type: Object,
        required: true
      }
    },
    methods: {
      navigate(url) {
        this.$emit('navigate', url)
      }
    }
  }
  </script>
  