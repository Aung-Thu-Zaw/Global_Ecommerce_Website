<script setup>
import ProductRatingStar from "@/Components/RatingStars/ProductRatingStar.vue";
import { computed } from "vue";

const props = defineProps({
  paginateProductReviews: Object,
  productReview: Object,
});

const filterVerifiedPurchaser = computed(() => {
  const orders = props.paginateProductReviews.data.filter(
    (paginateProductReview) => {
      paginateProductReview.user.orders.filter((order) => {
        order.order_items.filter((orderItem) => {
          orderItem.produt_id === props.paginateProductReviews.product_id &&
            orderItem.vendor_id === props.paginateProductReviews.vendor_id;
        });
      });
    }
  );

  return orders.length ? true : false;
});
</script>

<template>
  <div
    class="shadow w-full border rounded-md p-5 flex flex-col items-start my-3"
  >
    <div class="flex items-start w-full">
      <div class="flex flex-col items-center justify-center mr-5">
        <img
          :src="productReview.user.avatar"
          alt=""
          class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
        />

        <ProductRatingStar :rating="productReview.rating" />
      </div>

      <div class="flex flex-col items-end w-full">
        <div class="flex items-center justify-between w-full mb-1">
          <div class="flex flex-col">
            <h3 class="text-lg font-bold text-slate-700">
              {{ productReview.user.name }}
              <span
                v-if="filterVerifiedPurchaser"
                class="text-green-500 text-[.8rem] font-bold ml-3"
              >
                <i class="fa-solid fa-circle-check"></i>
                Verified Purchaser
              </span>
            </h3>
            <p class="text-[.8rem] text-slate-400 mb-2">
              Review From {{ productReview.user.name }}
            </p>
          </div>

          <span class="text-slate-600 text-sm font-bold">
            {{ productReview.updated_at }}
          </span>
        </div>
        <p class="w-full text-sm font-normal text-slate-900 mb-3">
          {{ productReview.review_text }}
        </p>
        <div class="flex items-center flex-wrap space-x-2 w-full">
          <div
            v-for="image in productReview.images"
            :key="image.id"
            class="mb-2"
          >
            <img
              :src="image.img_path"
              class="h-14 rounded-sm shadow border-2 border-slate-300"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Reply  -->

    <div v-if="productReview.reply" class="w-[95%] ml-auto">
      <hr class="mt-4" />

      <div class="flex items-start justify-between my-3">
        <div class="flex items-center">
          <img
            :src="productReview.reply.seller.avatar"
            alt=""
            class="w-10 h-10 object-cover rounded-full mr-5"
          />
          <div>
            <h4 class="text-lg font-bold text-slate-700">
              {{ productReview.reply.seller.shop_name }}

              <span
                class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.7rem] ml-2"
              >
                <i class="fa-solid fa-circle-check"></i>
                Verified
              </span>
            </h4>
            <p class="text-[.8rem] text-slate-400">Reply From Shop</p>
          </div>
        </div>
        <div class="">
          <span class="text-slate-600 text-sm font-bold">
            {{ productReview.reply.updated_at }}
          </span>
        </div>
      </div>
      <p class="w-[94.3%] text-sm font-normal text-slate-900 ml-auto">
        {{ productReview.reply.reply_text }}
      </p>
    </div>
  </div>
</template>
