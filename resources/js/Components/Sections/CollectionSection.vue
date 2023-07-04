<script setup>
import { Link } from "@inertiajs/vue3";
import CollectionCard from "@/Components/Cards/CollectionCard.vue";

defineProps({
  collections: Object,
});
</script>

<template>
  <section class="pt-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <!-- Titles  -->
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <h2 class="text-md md:text-2xl font-bold">{{ __("COLLECTIONS") }}</h2>
        <span class="hidden border-4 border-slate-300 w-[75%] lg:block"></span>
        <Link
          :href="route('collections.index')"
          class="text-sm font-bold md:text-md animate-bounce"
        >
          {{ __("SEE_ALL") }}
          <i class="fa-solid fa-angles-right ml-3"></i>
        </Link>
      </div>

      <!-- Collection Card -->
      <nav
        v-if="collections.length"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1"
      >
        <CollectionCard :collections="collections" />
      </nav>
      <div v-else>
        <p class="text-center text-xl font-bold text-red-600 animate-bounce">
          {{ __("NO_COLLECTION_FOUND") }}!
        </p>
      </div>
    </div>
  </section>
</template>



