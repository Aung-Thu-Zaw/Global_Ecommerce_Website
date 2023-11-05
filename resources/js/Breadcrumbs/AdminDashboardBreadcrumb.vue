<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <nav
    class="flex mb-5 md:mb-0 overflow-x-auto max-w-[350px] md:max-w-[600px] px-10 md:px-0"
    aria-label="Breadcrumb"
  >
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
      <li class="inline-flex items-center">
        <Link
          :href="route('admin.dashboard')"
          class="inline-flex items-center text-sm font-semibold text-blueGray-600 hover:text-blue-600"
        >
          <svg
            class="w-3 h-3 mr-2.5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
            />
          </svg>
          Dashboard
        </Link>
      </li>

      <slot />
    </ol>
  </nav>
</template>
