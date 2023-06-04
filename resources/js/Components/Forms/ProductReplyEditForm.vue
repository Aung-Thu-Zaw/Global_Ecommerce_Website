<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  paginateProductReview: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  product_review_id: props.paginateProductReview.reply.product_review_id,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  reply_text: props.paginateProductReview.reply.reply_text,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleProductReplyEdit = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_product_reply");
  submit();
};

const submit = () => {
  form.post(
    route("product.review.reply.update", {
      reply_id: props.paginateProductReview.reply.id,
    }),
    {
      replace: true,
      preserveScroll: true,

      onFinish: () => {
        form.reply_text = "";
        emit("isVisible", false);
      },
    }
  );
};
</script>


<template>
  <!-- {{ paginateProductReview.reply.reply_text }} -->
  <div class="w-full">
    <form @submit.prevent="handleProductReplyEdit">
      <textarea
        name=""
        id=""
        cols="30"
        rows="10"
        class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
        v-model="form.reply_text"
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


