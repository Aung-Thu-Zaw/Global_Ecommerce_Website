<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  termsAndConditions: Object,
});
</script>

<template>
  <AppLayout>
    <Head :title="__('TERMS_AND_CONDITIONS')" />

    <div class="min-h-screen bg-gray-50 mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl mb-5">{{ termsAndConditions.title }}</h1>
        <p v-html="termsAndConditions.description" class="text-[.9rem]"></p>
      </div>
    </div>
  </AppLayout>
</template>

