<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({ item: Object, order: Object });
</script>

<template>
  <div
    class="flex flex-wrap lg:flex-row justify-between px-3 py-2 lg:py-4 lg:px-5 border-b"
  >
    <div class="w-full lg:w-2/5 xl:w-2/4">
      <figure class="flex leading-5">
        <div>
          <div
            class="block w-16 h-16 rounded border border-gray-200 overflow-hidden"
          >
            <img
              :src="item.product.image"
              :alt="item.product.name"
              class="h-full object-cover"
            />
          </div>
        </div>
        <figcaption class="ml-3">
          <p>
            <Link
              :href="route('products.show', item.product.slug)"
              class="hover:text-blue-600 font-semibold text-slate-600"
            >
              {{ item.product.name }}
            </Link>
          </p>
          <span class="text-[.8rem] text-gray-500">
            <span v-if="item.product.brand">
              Brand:
              <span class="text-slate-700 font-semibold">
                {{ item.product.brand.name }}
              </span>
            </span>
            <span v-else>
              Brand:
              <span class="text-slate-700 font-semibold"> No Brand </span>
            </span>
          </span>
          <span v-if="item.size" class="text-[.8rem] text-gray-500">
            <span class="text-gray-600">|</span>
            Size:
            <span class="text-slate-700 font-semibold"> {{ item.size }}, </span>
          </span>
          <span v-if="item.color" class="text-[.8rem] text-gray-500">
            <span class="text-gray-600">|</span>
            Color:
            <span class="text-slate-700 font-semibold">
              {{ item.color }},
            </span>
          </span>
        </figcaption>
      </figure>
    </div>

    <div class="leading-5">
      <p class="font-semibold not-italic text-slate-700">
        Qty : {{ item.qty }}
      </p>
    </div>

    <div class="leading-5 flex items-start justify-center space-x-3">
      <span class="font-semibold not-italic text-slate-700">
        Total : ${{ item.price }}
      </span>
    </div>
  </div>
</template>


