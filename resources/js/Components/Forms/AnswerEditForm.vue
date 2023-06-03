<script setup>
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  question: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  product_question_id: props.question.id,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  answer_text: props.question.product_answer.answer_text,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleAnswerEdit = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_answer");
  submit();
};

const submit = () => {
  form.post(
    route("product.question.answer.update", {
      answer_id: props.question.product_answer.id,
    }),
    {
      replace: true,
      preserveScroll: true,
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
      <textarea
        name=""
        id=""
        cols="30"
        rows="10"
        class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
        v-model="form.answer_text"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 mb-3"
      >
        Update Answer
      </button>
    </form>
  </div>
</template>


