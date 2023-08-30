<script setup>
import ShopReviewReplyForm from "@/Components/Forms/Reviews/ShopReviewReplyForm.vue";
import ProductRatingStar from "@/Components/RatingStars/ProductRatingStar.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const isShopReplyFormVisible = ref(false);
const isEditShopReviewFormVisible = ref(false);

const props = defineProps({ paginateShopReview: Object });

const handleDeleteReview = () => {
  router.post(
    route("shop.review.destroy", {
      review_id: props.paginateShopReview.id,
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
  <div
    v-if="paginateShopReview.status !== 'published'"
    class="text-xs font-medium text-green-600 w-full mb-3 text-center"
  >
    <i class="fa-solid fa-spinner animate-spin mr-1"></i>
    <span> {{ __("YOUR_SHOP_REVIEW_IS_AWAITING_MODERATION") }} </span>
  </div>

  <div class="flex items-start w-full">
    <div class="flex flex-col items-center justify-center mr-5">
      <img
        :src="paginateShopReview.user.avatar"
        alt=""
        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
      />

      <ProductRatingStar :rating="paginateShopReview.rating" />
    </div>
    <div class="flex flex-col items-center w-full">
      <div class="flex items-start justify-between w-full mb-1">
        <div class="flex flex-col">
          <h3 class="text-lg font-bold text-slate-700">
            {{ paginateShopReview.user.name }}
          </h3>
          <p class="text-[.8rem] text-slate-400 mb-2">
            Review From {{ paginateShopReview.user.name }}
          </p>
        </div>

        <span class="text-slate-600 text-sm font-bold">
          {{ paginateShopReview.updated_at }}
        </span>
      </div>
      <p class="w-full text-sm font-normal text-slate-900 mb-3">
        {{ paginateShopReview.review_text }}
      </p>

      <div
        v-if="
          !paginateShopReview.reply &&
          $page.props.auth.user &&
          paginateShopReview.shop_id == $page.props.auth.user.id
        "
        class="flex items-center justify-end w-full"
      >
        <button
          @click="isShopReplyFormVisible = !isShopReplyFormVisible"
          class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all mb-3"
        >
          <i class="fa-solid fa-flag"></i>
          {{ __("REPLY_THIS_REVIEW") }}
        </button>
      </div>

      <div v-if="isShopReplyFormVisible" class="w-full">
        <ShopReviewReplyForm
          :paginateShopReview="paginateShopReview"
          @isVisible="isShopReplyFormVisible = false"
        />
      </div>
    </div>
  </div>
</template>
