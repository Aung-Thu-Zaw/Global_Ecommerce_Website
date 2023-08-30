<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  paginateShopReview: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  shop_review_id: props.paginateShopReview.id,
  seller_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  reply_text: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleReply = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("reply_review");
  submit();
};

const submit = () => {
  form.post(route("shop.reviews.reply.store"), {
    replace: true,
    preserveScroll: true,

    onFinish: () => {
      form.reply_text = "";
      emit("isVisible", false);
    },
  });
};
</script>


<template>
  <div class="w-full flex items-center justify-end">
    <form @submit.prevent="handleReply" class="w-full">
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
        Submit Reply
      </button>
    </form>
  </div>
</template>


