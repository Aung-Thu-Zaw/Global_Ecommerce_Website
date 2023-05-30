<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
  links: Array,
});
</script>

<template>
  <div class="flex items-center justify-center">
    <div v-if="links.length > 3">
      <div class="flex flex-wrap -mb-1">
        <template v-for="(link, p) in links" :key="p">
          <div
            v-if="link.url === null"
            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
            v-html="link.label"
          />

          <div v-else class="flex items-center">
            <Link
              v-if="$page.props.ziggy.query.tab"
              class="mr-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white hover:text-indigo-500 hover:border-indigo-500 focus:border-indigo-500 focus:text-indigo-500"
              :class="{ 'bg-blue-700 text-white': link.active }"
              :href="link.url"
              :data="{ tab: $page.props.ziggy.query.tab }"
              v-html="link.label"
            >
            </Link>
            <Link
              v-else
              class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white hover:text-indigo-500 hover:border-indigo-500 focus:border-indigo-500 focus:text-indigo-500"
              :class="{ 'bg-blue-700 text-white': link.active }"
              :href="link.url"
              v-html="link.label"
            >
            </Link>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

