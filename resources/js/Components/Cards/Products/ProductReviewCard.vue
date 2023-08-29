<script setup>
import ProductReviewReplyForm from "@/Components/Forms/Reviews/ProductReviewReplyForm.vue";
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import ProductRatingStar from "@/Components/RatingStars/ProductRatingStar.vue";

const isReplyFormVisible = ref(false);
const isEditProductReviewFormVisible = ref(false);

const props = defineProps({ paginateProductReview: Object });

const filterVerifiedPurchaser = computed(() => {
  const orders = props.paginateProductReview.user.orders.filter((order) =>
    order.order_items.filter(
      (orderItem) =>
        orderItem.produt_id === props.paginateProductReview.product_id &&
        orderItem.vendor_id === props.paginateProductReview.vendor_id
    )
  );

  return orders.length ? true : false;
});

const handleDeleteReview = () => {
  router.post(
    route("product.review.destroy", {
      review_id: props.paginateProductReview.id,
    }),
    {},
    {
      replace: true,
      preserveScroll: true,
    }
  );
};
</script>


<template>
  <div class="flex items-start w-full">
    <div class="flex flex-col items-center justify-center mr-5">
      <img
        :src="paginateProductReview.user.avatar"
        alt=""
        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
      />

      <ProductRatingStar :rating="paginateProductReview.rating" />
    </div>
    <div class="flex flex-col items-center w-full">
      <div class="flex items-start justify-between w-full mb-1">
        <div class="flex flex-col">
          <h3 class="text-lg font-bold text-slate-700">
            {{ paginateProductReview.user.name }}
            <span
              v-if="filterVerifiedPurchaser"
              class="text-green-500 text-[.8rem] font-bold ml-3"
            >
              <i class="fa-solid fa-circle-check"></i>
              Verified Purchaser
            </span>
          </h3>
          <p class="text-[.7rem] text-slate-400 mb-2">
            Review From {{ paginateProductReview.user.name }}
          </p>
        </div>

        <span class="text-slate-600 text-sm font-bold">
          {{ paginateProductReview.updated_at }}
        </span>
      </div>
      <p class="w-full text-sm font-normal text-slate-900 mb-3">
        {{ paginateProductReview.review_text }}
      </p>

      <div class="flex items-center flex-wrap space-x-2 w-full">
        <div
          v-for="image in paginateProductReview.images"
          :key="image.id"
          class="mb-2"
        >
          <img
            :src="image.img_path"
            class="h-14 rounded-sm shadow border-2 border-slate-300"
          />
        </div>
      </div>

      <div
        v-if="
          !paginateProductReview.reply &&
          $page.props.auth.user &&
          paginateProductReview.seller_id == $page.props.auth.user.id
        "
        class="flex items-center justify-end w-full"
      >
        <button
          @click="isReplyFormVisible = !isReplyFormVisible"
          class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all mb-3"
        >
          <i class="fa-solid fa-flag"></i>
          Reply
        </button>
      </div>

      <div v-if="isReplyFormVisible" class="w-full">
        <ProductReviewReplyForm
          :paginateProductReview="paginateProductReview"
          @isVisible="isReplyFormVisible = false"
        />
      </div>
    </div>
  </div>
</template>
