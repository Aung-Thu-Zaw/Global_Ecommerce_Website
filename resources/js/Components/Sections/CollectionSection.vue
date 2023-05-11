<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  collections: Object,
});
</script>


<template>
  <!-- SECTION-ICONMENU -->
  <section class="pt-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <h2 class="text-md md:text-2xl font-bold">Collections</h2>
        <span class="hidden border-4 border-slate-300 w-[75%] lg:block"></span>
        <Link
          :href="route('collections.index')"
          class="text-sm font-bold md:text-md animate-bounce"
        >
          SEE ALL
          <i class="fa-solid fa-angles-right ml-3"></i>
        </Link>
      </div>

      <nav
        v-if="collections"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1"
      >
        <Link
          v-for="collection in collections"
          :key="collection.id"
          class="group border py-4 bg-slate-50 hover:shadow-lg hover:bg-slate-100 transition-all rounded-md"
          :href="route('collections.show', collection.slug)"
        >
          <div class="flex items-center justify-between">
            <div
              class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
            >
              <img
                :src="collection.products[0].image"
                class="h-full object-cover"
              />
            </div>

            <div
              class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
            >
              <img
                :src="collection.products[1].image"
                class="h-full object-cover"
              />
            </div>

            <div
              class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
            >
              <img
                :src="collection.products[2].image"
                class="h-full object-cover"
              />
            </div>
          </div>

          <p
            class="text-center text-gray-600 group-hover:text-blue-600 text-md font-bold px-3"
          >
            {{ collection.title }}
          </p>

          <p class="text-sm text-center text-secondary-600 my-2">
            {{ collection.products.length }} products
          </p>
        </Link>
      </nav>
      <div v-else>
        <p class="text-center text-xl font-bold text-red-600 animate-bounce">
          No Collection Found!
        </p>
      </div>
    </div>
    <!-- container //end -->
  </section>
  <!-- SECTION-ICONMENU //END -->
</template>



