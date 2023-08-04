<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  collections: Object,
});

const approvedProducts = (products) => {
  return products.filter((product) => product.status === "approved");
};
</script>

<template>
  <Link
    v-for="collection in collections"
    :key="collection.id"
    class="group border py-4 bg-slate-50 hover:shadow-lg hover:bg-slate-100 transition-all rounded-md"
    :href="route('collections.show', collection.slug)"
  >
    <div
      v-if="approvedProducts(collection.products).length"
      class="flex items-center justify-between"
    >
      <div
        class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
      >
        <img
          :src="approvedProducts(collection.products)[0].image"
          class="w-full h-full object-cover"
        />
      </div>

      <div
        class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
      >
        <img
          :src="approvedProducts(collection.products)[1].image"
          class="w-full h-full object-cover"
        />
      </div>

      <div
        class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
      >
        <img
          :src="approvedProducts(collection.products)[2].image"
          class="w-full h-full object-cover"
        />
      </div>
    </div>

    <p
      class="text-center text-gray-600 group-hover:text-blue-600 text-md font-bold px-3"
    >
      {{ collection.title }}
    </p>

    <p class="text-sm text-center text-secondary-600 my-2">
      {{ approvedProducts(collection.products).length }} products
    </p>
  </Link>
</template>
