<script setup>
import { ref } from "vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
</script>

<template>
  <div>
    <div class="min-h-screen bg-white">
      <header class="bg-slate-400 shadow" v-if="$slots.header">
        <div
          class="flex items-center justify-between max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"
        >
          <slot name="header" />
          <UserDropdown></UserDropdown>
        </div>
      </header>
      <main class="px-5">
        <slot />
      </main>
    </div>
  </div>
</template>
