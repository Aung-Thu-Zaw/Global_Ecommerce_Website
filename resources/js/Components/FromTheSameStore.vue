
<script setup>
const props = defineProps({
  specificShopProducts: Object,
});
</script>
<template>
  <aside class="my-5 w-full lg:my-0 lg:w-1/4 px-2">
    <article class="border border-gray-200 shadow-sm rounded bg-white p-4">
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
          <p class="line-clamp-2">
            <a href="#" class="text-gray-600 hover:text-blue-600">{{
              product.name
            }}</a>
          </p>
          <p class="mt-1 font-semibold">${{ product.price }}</p>
        </figcaption>
      </figure>

      <button
        class="bg-blue-600 text-white w-full font-bold py-2 rounded-sm shadow-md hover:bg-blue-700"
      >
        <i class="fas fa-shop mr-1"></i>
        Visit Store
      </button>
    </article>
  </aside>
</template>


