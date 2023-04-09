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
      <div class="p-4 border-t border-t-gray-200">
        <span
          v-if="product.brand"
          class="text-[.7rem] text-secondary-500 font-semibold uppercase"
        >
          {{ product.brand.name }}
        </span>
        <span v-else class="text-sm text-secondary-500 font-semibold uppercase"
          >No Brand</span
        >

        <h6 class="text-md">
          <a href="#" class="text-gray-600 hover:text-blue-500">
            {{ product.name }}
          </a>
        </h6>

        <div class="my-2">
          <span class="font-semibold text-slate-600 mr-3">
            ${{ product.price }}
          </span>
          <span class="text-[.8rem] text-secondary-600 line-through">
            ${{ product.price }}
          </span>
        </div>

        <!-- Rating  -->

        <div class="flex items-center">
          <svg
            aria-hidden="true"
            class="w-4 h-4 text-yellow-400"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <title>First star</title>
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            ></path>
          </svg>
          <svg
            aria-hidden="true"
            class="w-4 h-4 text-yellow-400"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <title>Second star</title>
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            ></path>
          </svg>
          <svg
            aria-hidden="true"
            class="w-4 h-4 text-yellow-400"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <title>Third star</title>
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            ></path>
          </svg>
          <svg
            aria-hidden="true"
            class="w-4 h-4 text-yellow-400"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <title>Fourth star</title>
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            ></path>
          </svg>
          <svg
            aria-hidden="true"
            class="w-4 h-4 text-gray-300 dark:text-gray-500"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <title>Fifth star</title>
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            ></path>
          </svg>
        </div>

        <div class="flex items-center justify-between">
          <button
            class="px-4 py-2 mt-3 bg-blue-500 text-white text-sm font-semibold rounded-sm hover:shadow-md hover:bg-blue-600 hover:animate-bounce transition-all"
          >
            <i class="w-5 fa fa-shopping-cart"></i>
            Add to Cart
          </button>
          <button
            class="mt-3 text-white text-sm font-semibold px-4 py-2 md:px-2 md:py-2 rounded-sm bg-blue-500 hover:shadow-md hover:bg-blue-600 hover:animate-bounce transition-all"
          >
            <i class="w-5 fa fa-heart"></i>
            <span class="md:hidden">Add to Whilist</span>
          </button>
        </div>
      </div>
    </article>
    <!-- COMPONENT: PRODUCT CARD //END -->
  </div>
</template>

