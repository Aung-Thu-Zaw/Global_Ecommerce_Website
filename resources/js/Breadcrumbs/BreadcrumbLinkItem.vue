<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  name: {
    type: String,
    required: true,
  },
  href: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <li>
    <div class="flex items-center">
      <i class="fa-solid fa-angle-right text-gray-400"></i>
      <Link
        :href="route(href)"
        :data="{
          page: 1,
          per_page: 5,
          sort: 'id',
          direction: 'desc',
        }"
        class="ml-1 text-sm font-semibold text-blueGray-600 hover:text-orange-600 md:ml-2"
      >
        {{ name }}
      </Link>
    </div>
  </li>
</template>
