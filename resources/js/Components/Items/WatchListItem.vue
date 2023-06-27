<script setup>
import { inject } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({ watchlist: Object });

const swal = inject("$swal");

// Handle Watchlist Product Add To Cart
const addToCart = () => {
  router.post(
    route("cart-items.store", {
      cart_id: usePage().props.auth.user.cart
        ? usePage().props.auth.user.cart.id
        : null,
      product_id: props.watchlist.product.id,
      shop_id: props.watchlist.product.shop.id,
      qty: 1,
      total_price: props.watchlist.product.discount
        ? props.watchlist.product.discount
        : props.watchlist.product.price,
    }),
    {},
    {
      preserveScroll: true,
      onSuccess: () => {
        toast.success(usePage().props.flash.successMessage, {
          autoClose: 2000,
        });
      },
    }
  );
};

// Handle Remove Watchlist Product
const removeWatchlistItem = async (item) => {
  const result = await swal({
    icon: "warning",
    title: `Remove From Watchlist`,
    text: `Are you sure you want to remove this item(s)?`,
    showCancelButton: true,
    confirmButtonText: "Yes, remove it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("watchlist.destroy", item),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        },
      }
    );
  }
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
              :src="watchlist.product.image"
              :alt="watchlist.product.name"
              class="w-full h-full object-cover"
            />
          </div>
        </div>
        <figcaption class="ml-3">
          <p>
            <Link
              :href="route('products.show', watchlist.product.slug)"
              class="hover:text-blue-600 font-semibold text-slate-600"
            >
              {{ watchlist.product.name }}
            </Link>
          </p>
          <span class="text-[.8rem] text-gray-500">
            <span v-if="watchlist.product.brand">
              Brand:
              <span class="text-slate-700 font-semibold">
                {{ watchlist.product.brand.name }}
              </span>
            </span>
            <span v-else>
              Brand:
              <span class="text-slate-700 font-semibold"> No Brand </span>
            </span>
          </span>
          <span
            v-if="watchlist.product.sizes.length"
            class="text-[.8rem] text-gray-500"
          >
            <span class="text-gray-600">|</span>
            Size:
            <span
              v-for="size in watchlist.product.sizes"
              :key="size.id"
              class="text-slate-700 font-semibold"
            >
              {{ size.name }},
            </span>
          </span>
          <span
            v-if="watchlist.product.colors.length"
            class="text-[.8rem] text-gray-500"
          >
            <span class="text-gray-600">|</span>
            Color:
            <span
              v-for="color in watchlist.product.colors"
              :key="color.id"
              class="text-slate-700 font-semibold"
            >
              {{ color.name }},
            </span>
          </span>
          <p class="text-[.8rem] text-red-500 font-bold">
            Only {{ watchlist.product.qty }} item(s) left
          </p>
        </figcaption>
      </figure>
    </div>

    <div class="">
      <div v-if="watchlist.product.discount" class="leading-5">
        <p class="font-semibold not-italic">
          ${{ watchlist.product.discount }}
        </p>

        <small class="text-gray-400 block line-through">
          ${{ watchlist.product.price }} / per item
        </small>
        <small
          class="bg-green-300 text-green-600 px-2 py-1 rounded-full text-[.6rem]"
        >
          {{
            (
              ((watchlist.product.price - watchlist.product.discount) /
                watchlist.product.price) *
              100
            ).toFixed(1)
          }}% OFF
        </small>
      </div>

      <div v-else class="leading-5">
        <p class="font-semibold not-italic">${{ watchlist.product.price }}</p>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex-auto">
      <div class="float-right">
        <button
          class="px-4 py-2 inline-block text-blue-600 bg-white shadow-sm border border-gray-200 rounded-md ml-3 hover:bg-blue-600 hover:text-white transition-all"
          @click="addToCart"
        >
          <i class="fa-solid fa-cart-shopping"></i>
          Add to cart
        </button>
        <button
          class="px-4 py-2 inline-block text-red-600 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-red-600 hover:text-white transition-all ml-3"
          @click="removeWatchlistItem(watchlist.id)"
        >
          <i class="fa fa-trash"></i>
          Remove
        </button>
      </div>
    </div>
  </div>
  <hr />
</template>


