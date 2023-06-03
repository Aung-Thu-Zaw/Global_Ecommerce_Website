<script setup >
import { computed, inject, ref, watch } from "vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({ item: Object });

const swal = inject("$swal");
const quantity = ref(props.item.qty);

const increment = () =>
  quantity.value >= props.item.product.qty
    ? (quantity.value = props.item.product.qty)
    : quantity.value++;

const decrement = () => (quantity.value <= 1 ? 1 : quantity.value--);

watch(
  () => quantity.value,
  () => {
    router.post(
      route("cart-items.update", props.item.id),
      {
        qty: quantity.value,
      },
      {
        preserveScroll: true,
      }
    );
  }
);

const totalDiscountPrice = computed(
  () => quantity.value * props.item.product.discount
);
const totalPrice = computed(() => quantity.value * props.item.product.price);

const moveToWatchlist = async (item) => {
  const result = await swal({
    icon: "warning",
    title: `Move To Watchlist`,
    text: `Item(s) will be moved to watchlist and removed from cart.`,
    showCancelButton: true,
    confirmButtonText: "Yes, move it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("watchlist.store", {
        user_id: usePage().props.auth.user.id,
        product_id: props.item.product.id,
        shop_id: props.item.product.shop.id,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          router.post(route("cart-items.destroy", props.item.id));
          // Success flash message
          if (usePage().props.flash.successMessage) {
            toast.success(usePage().props.flash.successMessage, {
              autoClose: 2000,
            });
          }
        },
      }
    );
  }
};

const removeItem = async (item) => {
  const result = await swal({
    icon: "warning",
    title: `Remove From Shopping Cart`,
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
      route("cart-items.destroy", item),
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

    <div class="flex-auto">
      <div class="float-right">
        <p class="text-slate-700 font-semibold">Qty : {{ item.qty }}</p>
      </div>
    </div>
  </div>
  <hr />
</template>



