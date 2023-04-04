<script setup>
defineProps({
  product: Object,
});
</script>

<template>
  <div v-if="product">
    <!-- COMPONENT: PRODUCT CARD -->
    <article class="shadow-sm rounded bg-white border border-gray-200">
      <a href="#" class="relative block p-3 h-[250px]">
        <img
          :src="product.image"
          class="mx-auto w-full h-full object-cover"
          height="250"
          alt="Product title here"
        />
        <!-- <span
          class="inline-block px-2 py-1 text-sm font-bold bg-green-100 text-green-600 rounded-full absolute left-4 top-4"
        >
          25% OFF
        </span> -->
      </a>
      <div class="p-4 border-t border-t-gray-200">
        <a
          class="float-right px-2 py-1 text-gray-400 border border-gray-300 rounded-md hover:border-blue-400 hover:text-blue-600"
          href="#"
        >
          <i class="fa fa-heart text-sm"></i>
        </a>
        <h6>
          <a href="#" class="text-gray-600 hover:text-blue-500">
            {{ product.name }}
          </a>
        </h6>
        <span class="font-semibold text-secondary-900">${{ product.price }}</span>
      </div>
    </article>
    <!-- COMPONENT: PRODUCT CARD //END -->
  </div>
</template>

