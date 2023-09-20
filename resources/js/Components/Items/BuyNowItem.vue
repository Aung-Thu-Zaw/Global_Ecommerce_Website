<script setup >
import { computed, ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({ product: Object, quantity: Number });

const totalDiscountPrice = computed(
  () => props.quantity * props.product.discount
);
const totalPrice = computed(() => props.quantity * props.product.price);
</script>

<template>
  <div class="flex flex-wrap lg:flex-row gap-5 mb-4 px-3 py-2 lg:py-4 lg:px-5">
    <div class="w-full lg:w-2/5 xl:w-2/4">
      <figure class="flex leading-5">
        <div>
          <div
            class="block w-16 h-16 rounded border border-gray-200 overflow-hidden"
          >
            <img
              :src="product.image"
              :alt="product.name"
              class="h-full object-cover"
            />
          </div>
        </div>
        <figcaption class="ml-3">
          <p>
            <Link
              :href="route('products.show', product.slug)"
              class="hover:text-blue-600 font-semibold text-slate-600"
            >
              {{ product.name }}
            </Link>
          </p>
          <span class="text-[.8rem] text-gray-500">
            <span v-if="product.brand">
              Brand:
              <span class="text-slate-700 font-semibold">
                {{ product.brand.name }}
              </span>
            </span>
            <span v-else>
              Brand:
              <span class="text-slate-700 font-semibold"> No Brand </span>
            </span>
          </span>
          <span v-if="product.sizes.length" class="text-[.8rem] text-gray-500">
            <span class="text-gray-600">|</span>
            Size:
            <span
              v-for="size in product.sizes"
              :key="size.id"
              class="text-slate-700 font-semibold"
            >
              {{ size.name }},
            </span>
          </span>
          <span v-if="product.colors.length" class="text-[.8rem] text-gray-500">
            <span class="text-gray-600">|</span>
            Color:
            <span
              v-for="color in product.colors"
              :key="color.id"
              class="text-slate-700 font-semibold"
            >
              {{ color.name }},
            </span>
          </span>
          <span v-if="product.types.length" class="text-[.8rem] text-gray-500">
            <span class="text-gray-600">|</span>
            Type:
            <span
              v-for="productType in product.types"
              :key="productType.id"
              class="text-slate-700 font-semibold"
            >
              {{ productType.name }},
            </span>
          </span>
          <p class="text-[.8rem] text-red-500 font-bold">
            Only {{ product.qty }} item(s) left
          </p>
        </figcaption>
      </figure>
    </div>

    <div class="">
      <div v-if="product.discount" class="leading-5">
        <p class="font-semibold not-italic">${{ totalDiscountPrice }}</p>
        <small class="text-gray-600 block">
          ${{ product.discount }} / per item
        </small>
        <small class="text-gray-400 block line-through">
          ${{ product.price }} / per item
        </small>
        <small
          class="bg-green-300 text-green-600 px-2 py-1 rounded-full text-[.6rem]"
        >
          {{
            (
              ((product.price - product.discount) / product.price) *
              100
            ).toFixed(1)
          }}% OFF
        </small>
      </div>

      <div v-else class="leading-5">
        <p class="font-semibold not-italic">${{ totalPrice }}</p>
        <small class="text-gray-600 block">
          ${{ product.price }} / per item
        </small>
      </div>
    </div>

    <div class="flex-auto">
      <div class="float-right">
        <p class="text-slate-700 font-semibold">Qty : {{ quantity }}</p>
      </div>
    </div>
  </div>
</template>



