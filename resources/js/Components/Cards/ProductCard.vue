<script setup>
defineProps({
  product: Object,
});
</script>

<template>
  <div v-if="product">
    <!-- COMPONENT: PRODUCT CARD -->
    <article
      class="shadow-sm rounded bg-white border border-gray-200 p-2 overflow-hidden"
    >
      <a href="#" class="relative block h-[250px]">
        <img
          :src="product.image"
          class="mx-auto h-full object-cover"
          alt="Product title here"
        />
        <span
          v-if="product.discount"
          class="inline-block px-2 text-center py-1 text-[.6rem] font-bold w-[100px] bg-green-200 bg-opacity-90 text-green-600 absolute -right-8 top-2 rotate-45"
        >
          25% OFF
        </span>
      </a>
      <div
        class="p-4 border-t border-t-gray-200 flex items-start justify-between"
      >
        <div>
          <h6 class="text-md">
            <a href="#" class="text-gray-600 hover:text-blue-500">
              {{ product.name }}
            </a>
          </h6>
          <span class="font-semibold text-secondary-900"
            >${{ product.price }}</span
          >
        </div>
        <a
          class="px-2 py-1 text-gray-400 border border-gray-300 rounded-md hover:border-blue-400 hover:text-blue-600 ml-1"
          href="#"
        >
          <i class="fa fa-heart text-sm"></i>
        </a>
      </div>
    </article>
    <!-- COMPONENT: PRODUCT CARD //END -->
  </div>
</template>

