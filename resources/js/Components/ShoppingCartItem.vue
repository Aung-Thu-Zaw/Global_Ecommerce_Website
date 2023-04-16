<script setup >
import { computed, ref } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({ item: Object });

const quantity = ref(props.item.qty);

const increment = () =>
  quantity.value >= props.item.product.qty
    ? (quantity.value = props.item.product.qty)
    : quantity.value++;

const decrement = () => (quantity.value <= 1 ? 1 : quantity.value--);

const totalDiscountPrice = computed(
  () => quantity.value * props.item.product.discount
);
const totalPrice = computed(() => quantity.value * props.item.product.price);

const removeItem = (item) => {
  router.post(
    route("cart-items.destroy", item),
    {},
    {
      preserveScroll: true,
      onSuccess: () => {
        toast.warning(usePage().props.flash.successMessage, {
          autoClose: 2000,
        });
      },
    }
  );
};
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
          <span
            v-if="item.product.sizes.length"
            class="text-[.8rem] text-gray-500"
          >
            <span class="text-gray-600">|</span>
            Size:
            <span
              v-for="size in item.product.sizes"
              :key="size.id"
              class="text-slate-700 font-semibold"
            >
              {{ size.name }},
            </span>
          </span>
          <span
            v-if="item.product.colors.length"
            class="text-[.8rem] text-gray-500"
          >
            <span class="text-gray-600">|</span>
            Color:
            <span
              v-for="color in item.product.colors"
              :key="color.id"
              class="text-slate-700 font-semibold"
            >
              {{ color.name }},
            </span>
          </span>
          <p class="text-[.8rem] text-red-500 font-bold">
            Only {{ item.product.qty }} item(s) left
          </p>
        </figcaption>
      </figure>
    </div>

    <div class="">
      <div v-if="item.product.discount" class="leading-5">
        <p class="font-semibold not-italic">${{ totalDiscountPrice }}</p>
        <small class="text-gray-600 block">
          ${{ item.product.discount }} / per item
        </small>
        <small class="text-gray-400 block line-through">
          ${{ item.product.price }} / per item
        </small>
        <small
          class="bg-green-300 text-green-600 px-2 py-1 rounded-full text-[.6rem]"
        >
          {{
            (
              ((item.product.price - item.product.discount) /
                item.product.price) *
              100
            ).toFixed(1)
          }}% OFF
        </small>
      </div>

      <div v-else class="leading-5">
        <p class="font-semibold not-italic">${{ totalPrice }}</p>
        <small class="text-gray-600 block">
          ${{ item.product.price }} / per item
        </small>
      </div>
    </div>

    <div class="">
      <!-- selection -->
      <div class="w-auto relative">
        <div>
          <span
            class="px-3 py-2 bg-slate-500 hover:bg-slate-600 rounded-sm cursor-pointer"
            @click="increment"
          >
            <i class="fa-solid fa-plus text-white"></i>
          </span>

          <input
            type="number"
            class="border-2 text-center border-slate-500 outline-none focus:outline-none focus:ring-0 w-[50px] h-full mx-1 rounded-sm"
            v-model="quantity"
          />
          <span
            class="px-3 py-2 bg-slate-500 hover:bg-slate-600 mr-2 rounded-sm cursor-pointer"
            @click="decrement"
          >
            <i class="fa-solid fa-minus text-white"></i>
          </span>
        </div>
      </div>
    </div>

    <div class="flex-auto">
      <div class="float-right">
        <a
          class="px-4 py-2 inline-block text-blue-600 bg-white shadow-sm border border-gray-200 rounded-md ml-3 hover:bg-blue-600 hover:text-white transition-all"
          href="#"
        >
          <i class="fa fa-heart"></i>
        </a>
        <button
          class="px-4 py-2 inline-block text-red-600 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-red-600 hover:text-white transition-all ml-3"
          @click="removeItem(item.id)"
        >
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>
  </div>
  <hr />
</template>



