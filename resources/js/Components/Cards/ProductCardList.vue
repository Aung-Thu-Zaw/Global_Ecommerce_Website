<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  product: Object,
});
</script>

<template>
  <div v-if="product" class="w-full">
    <a
      href="#"
      class="border hover:shadow-md rounded-sm bg-white p-5 w-full h-[280px] flex items-start justify-between"
    >
      <div class="flex flex-col items-start w-[500px] mr-3">
        <img
          :src="product.image"
          alt=""
          class="h-[180px] object-contain rounded-md shadow border-2 border-slate-400"
        />

        <div
          class="flex items-center space-x-1 mt-2 w-[250px] overflow-auto pb-1"
        >
          <img
            v-for="image in product.images"
            :key="image.id"
            :src="image.img_path"
            alt=""
            class="h-[50px] object-contain rounded-md shadow border-2 border-slate-400"
          />
        </div>
      </div>

      <div class="w-full">
        <h1 class="line-clamp-1 font-semibold text-slate-600 text-md mb-3">
          <Link
            :href="route('products.show', product.slug)"
            class="text-gray-600 line-clamp-2"
          >
            {{ product.name }}
          </Link>
        </h1>
        <p class="text-sm text-slate-500 line-clamp-6 mb-5">
          {{ product.description }}
        </p>

        <!-- ================================ -->

        <div class="flex items-start justify-between w-full">
          <div class="my-2">
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
          </div>

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
        </div>
      </div>
    </a>
  </div>
</template>

