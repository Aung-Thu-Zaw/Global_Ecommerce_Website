<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
  specificShopProducts: Object,
});
</script>
<template>
  <aside
    v-if="specificShopProducts.length"
    class="my-5 w-full lg:my-0 lg:w-1/4 px-2"
  >
    <article
      class="border border-gray-200 shadow-sm rounded bg-white w-full p-4"
    >
      <h3 class="mb-5 text-lg font-semibold capitalize">from the same store</h3>

      <figure
        v-for="product in specificShopProducts"
        :key="product.id"
        class="flex flex-row mb-4"
      >
        <div>
          <a
            href="#"
            class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
          >
            <img
              :src="product.image"
              class="h-full object-cover"
              :alt="product.name"
            />
          </a>
        </div>
        <figcaption class="ml-3">
          <Link
            :href="route('products.show', product.slug)"
            class="text-gray-600 line-clamp-2"
          >
            {{ product.name }}
          </Link>
          <p class="mt-1 font-semibold">${{ product.price }}</p>
        </figcaption>
      </figure>

      <Link
        as="button"
        :href="
          route('shop.index', { shop_id: specificShopProducts[0].user_id })
        "
        class="bg-blue-600 text-white w-full font-bold py-2 rounded-sm shadow-md hover:bg-blue-700"
      >
        <i class="fas fa-shop mr-1"></i>
        Visit Shop
      </Link>
    </article>
  </aside>
</template>


