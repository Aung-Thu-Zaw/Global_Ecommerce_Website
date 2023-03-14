<script setup>
import { ref } from "vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
const showingNavigationDropdown = ref(false);
</script>

<template>
  <div>
    <div class="min-h-screen bg-white">
      <!-- Page Heading -->
      <header class="bg-slate-400 shadow" v-if="$slots.header">
        <div
          class="flex items-center justify-between max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"
        >
          <slot name="header" />
          <UserDropdown></UserDropdown>
        </div>
      </header>
      <!-- Page Content -->
      <main class="px-5">
        <slot />
      </main>
    </div>
  </div>
</template>
