<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  paginateProductReview: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  product_review_id: props.paginateProductReview.id,
  shop_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  reply_text: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleReply = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_product_review_reply");
  form.post(route("product.reviews.reply.store"), {
    replace: true,
    preserveScroll: true,
    preserveState: true,
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
      <div>
        <textarea
          name=""
          id=""
          cols="30"
          rows="10"
          class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
          v-model="form.reply_text"
        ></textarea>

        <InputError class="mt-2" :message="form.errors.reply_text" />
      </div>
      <div class="flex items-center justify-end">
        <button
          type="submit"
          class="bg-blue-600 font-medium text-sm text-white min-w-[100px] max-w-[300px] py-2 rounded-sm hover:bg-blue-700 mb-3"
        >
          {{ __("SUBMIT") }}
        </button>
      </div>
    </form>
  </div>
</template>


