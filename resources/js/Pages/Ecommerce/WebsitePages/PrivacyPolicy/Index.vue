<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  privacyPolicy: Object,
});
</script>

<template>
  <AppLayout>
    <Head title="Privacy Policy" />

    <div class="min-h-screen bg-gray-50 mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl mb-5">{{ privacyPolicy.title }}</h1>
        <p v-html="privacyPolicy.description" class="text-[.9rem]"></p>
      </div>
    </div>
  </AppLayout>
</template>

