<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  product: Object,
});

const form = useForm({
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  product_id: props.product?.id,
  seller_id: props.product?.seller_id,
  question_text: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleAskQuestion = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_product_question");
  form.post(route("product.questions.store"), {
    replace: true,
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => (form.question_text = ""),
  });
};
</script>


<template>
  <form @submit.prevent="handleAskQuestion">
    <div>
      <textarea
        cols="30"
        rows="10"
        class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
        :placeholder="
          __('WRITE_QUESTION_WHAT_YOU_WANT_TO_ASK_ABOUT_THIS_PRODUCT')
        "
        v-model="form.question_text"
      ></textarea>
    </div>

    <InputError class="mt-2" :message="form.errors.question_text" />

    <button
      class="font-bold text-white w-full py-2 rounded-sm my-5"
      :class="{
        'bg-gray-400': !form.question_text,
        'bg-blue-600 hover:bg-blue-700': form.question_text,
      }"
      :disabled="!form.question_text"
    >
      {{ __("ASK_QUESTION") }}
    </button>
  </form>
</template>


