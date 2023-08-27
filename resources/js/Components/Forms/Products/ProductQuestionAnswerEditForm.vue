<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  question: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  product_question_id: props.question.id,
  seller_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  answer_text: props.question.product_answer.answer_text,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleAnswerEdit = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_product_question_answer");
  form.patch(
    route("product.questions.answer.update", {
      product_answer: props.question.product_answer.id,
    }),
    {
      replace: true,
      preserveScroll: true,
      preserveState: true,
      onFinish: () => {
        form.answer_text = "";
        emit("isVisible", false);
      },
    }
  );
};
</script>


<template>
  <div class="w-full">
    <form @submit.prevent="handleAnswerEdit">
      <div>
        <textarea
          name=""
          id=""
          cols="30"
          rows="10"
          class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
          v-model="form.answer_text"
        ></textarea>
      </div>

      <InputError class="mt-2" :message="form.errors.answer_text" />


      <div class="flex items-center justify-end">
      <button
        type="submit"
        class="bg-blue-600 font-medium text-sm text-white min-w-[100px] max-w-[300px] py-2 rounded-sm hover:bg-blue-700 mb-3"
      >
        {{ __("UPDATE") }}
      </button>
      </div>
    </form>
  </div>
</template>


