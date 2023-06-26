<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
  productsFromShop: Object,
});
</script>

<template>
  <aside
    v-if="productsFromShop.length"
    class="my-5 w-full lg:my-0 lg:w-1/4 px-2"
  >
    <article
      class="border border-gray-200 shadow-sm rounded bg-white w-full p-4"
    >
      <h3 class="mb-5 text-lg font-semibold capitalize">from the same store</h3>

      <figure
        v-for="product in productsFromShop"
        :key="product.id"
        class="flex flex-row mb-4 border p-3 shadow rounded-md"
      >
        <div>
          <Link
            :href="route('products.show', product.slug)"
            class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
          >
            <img
              :src="product.image"
              class="w-full h-full object-cover"
              :alt="product.name"
            />
          </Link>
        </div>
        <figcaption class="ml-3">
          <Link
            :href="route('products.show', product.slug)"
            class="text-gray-600 line-clamp-2"
          >
            {{ product.name }}
          </Link>

          <div v-if="product.discount">
            <span class="font-semibold text-slate-600 block">
              ${{ product.discount }}
            </span>
            <span class="text-[.8rem] text-secondary-600 line-through mr-5">
              ${{ product.price }}
            </span>
            <span
              v-if="product.discount"
              class="text-[.6rem] px-2 py-1 bg-green-200 rounded-full text-green-600 font-bold"
            >
              {{
                (
                  ((product.price - product.discount) / product.price) *
                  100
                ).toFixed(1)
              }}% OFF
            </span>
          </div>
          <div v-else>
            <span class="font-semibold text-slate-600 mr-3">
              ${{ product.price }}
            </span>
          </div>
        </figcaption>
      </figure>
      <Link
        as="button"
        :href="route('shop.show', { shop_id: productsFromShop[0].shop.uuid })"
        :data="{ tab: 'home' }"
        class="bg-blue-600 text-white w-full font-bold py-2 rounded-sm shadow-md hover:bg-blue-700"
      >
        <i class="fas fa-shop mr-1"></i>
        Visit Shop
      </Link>
    </article>
  </aside>
</template>


