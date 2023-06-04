<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  paginateShopReview: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  vendor_id: props.paginateShopReview.vendor_id,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  review_text: props.paginateShopReview.review_text,
  rating: props.paginateShopReview.rating,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleShopReviewEdit = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_shop_review");
  submit();
};

const submit = () => {
  form.post(
    route("shop.review.update", {
      review_id: props.paginateShopReview.id,
    }),
    {
      replace: true,
      preserveScroll: true,

      onFinish: () => {
        form.review_text = "";
        emit("isVisible", false);
      },
    }
  );
};
</script>


<template>
  <div class="w-full">
    <form @submit.prevent="handleShopReviewEdit">
      <textarea
        name=""
        id=""
        cols="30"
        rows="10"
        class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
        v-model="form.review_text"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 mb-3"
      >
        Update Review
      </button>
    </form>
  </div>
</template>


