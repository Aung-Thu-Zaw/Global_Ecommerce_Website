<script setup>
</script>

<template>
  <div>
    <!-- COMPONENT: PRODUCT CARD -->
    <article class="shadow-sm rounded bg-white border border-gray-200">
      <a href="#" class="relative block p-3">
        <img
          src="https://i.ebayimg.com/images/g/UAAAAOSwzhhjvcsh/s-l225.webp"
          class="mx-auto w-full h-full object-cover"
          style="height: 250px"
          height="250"
          alt="Product title here"
        />
        <span
          class="inline-block px-3 py-1 text-sm bg-green-100 text-green-600 rounded-full absolute left-3 top-3"
        >
          25% OFF
        </span>
      </a>
      <div class="p-4 border-t border-t-gray-200">
        <a
          class="float-right px-3 py-2 text-gray-400 border border-gray-300 rounded-md hover:border-blue-400 hover:text-blue-600"
          href="#"
        >
          <i class="fa fa-heart"></i>
        </a>
        <h6>
          <a href="#" class="text-gray-600 hover:text-blue-500"
            >Product title here</a
          >
        </h6>
        <p class="text-sm text-gray-400">Sizes: S, M, XL</p>
        <span class="font-semibold">$99.50</span>
      </div>
    </article>
    <!-- COMPONENT: PRODUCT CARD //END -->
  </div>
</template>

