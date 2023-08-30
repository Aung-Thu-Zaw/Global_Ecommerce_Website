<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({ paginateShopReview: Object });

const isEditShopReplyFormVisible = ref(false);

const handleDeleteReply = () => {
  router.post(
    route("product.review.reply.destroy", {
      reply_id: props.paginateShopReview.reply.id,
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
  <hr v-if="paginateShopReview.reply" />
  <div class="w-[95%] ml-auto">
    <div class="flex items-start justify-between my-3 w-full">
      <div class="flex items-center">
        <img
          :src="paginateShopReview.reply.seller.avatar"
          alt=""
          class="w-10 h-10 object-cover rounded-full mr-5"
        />
        <div class="w-full">
          <h4 class="text-lg font-bold text-slate-700">
            {{ paginateShopReview.reply.seller.shop_name }}
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
          {{ paginateShopReview.reply.updated_at }}
        </span>
      </div>
    </div>
    <p class="w-[92%] text-sm font-normal text-slate-900 ml-auto">
      {{ paginateShopReview.reply.reply_text }}
    </p>
  </div>
</template>
