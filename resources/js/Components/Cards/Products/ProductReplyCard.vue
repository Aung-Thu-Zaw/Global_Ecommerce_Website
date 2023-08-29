<script setup>
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({ paginateProductReview: Object });

const isEditReplyFormVisible = ref(false);

const handleDeleteReply = () => {
  router.post(
    route("product.review.reply.destroy", {
      reply_id: props.paginateProductReview.reply.id,
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
  <hr v-if="paginateProductReview.reply" />
  <div class="w-[95%] ml-auto">
    <div class="flex items-start justify-between my-3 w-full">
      <div class="flex items-center">
        <img
          :src="paginateProductReview.reply.seller.avatar"
          alt=""
          class="w-10 h-10 object-cover rounded-full mr-5"
        />
        <div class="w-full">
          <h4 class="text-lg font-bold text-slate-700">
            {{ paginateProductReview.reply.seller.shop_name }}
            <span
              class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.7rem] ml-2"
            >
              <i class="fa-solid fa-circle-check"></i>
              Verified
            </span>
          </h4>
          <p class="text-[.7rem] text-slate-400">Reply From Shop</p>
        </div>
      </div>
      <div class="">
        <span class="text-slate-600 text-sm font-bold">
          {{ paginateProductReview.reply.updated_at }}
        </span>
      </div>
    </div>
    <p class="w-[92%] text-sm font-normal text-slate-900 ml-auto">
      {{ paginateProductReview.reply.reply_text }}
    </p>

    <div
      v-if="
        $page.props.auth.user &&
        $page.props.auth.user.id === paginateProductReview.reply.user_id
      "
      class="flex flex-col items-end"
    >
      <div class="my-3">
        <button
          @click="isEditReplyFormVisible = !isEditReplyFormVisible"
          class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
        >
          <i class="fa-solid fa-flag"></i>
          Edit Reply
        </button>

        <button
          @click="handleDeleteReply"
          class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
          type="button"
        >
          <i class="fa-solid fa-trash"></i>
          Delete Reply
        </button>
      </div>
    </div>
  </div>
</template>
