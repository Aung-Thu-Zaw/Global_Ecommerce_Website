<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  product: Object,
  question: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  product_id: props.product.id,
  question_text: props.question.question_text,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleQuestionEdit = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_question");
  submit();
};

const submit = () => {
  form.post(
    route("product.question.update", {
      question_id: props.question.id,
    }),
    {
      replace: true,
      preserveScroll: true,

      onFinish: () => {
        form.question_text = "";
        emit("isVisible", false);
      },
    }
  );
};
</script>


<template>
  <div class="w-full">
    <form @submit.prevent="handleQuestionEdit">
      <textarea
        name=""
        id=""
        cols="30"
        rows="10"
        class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
        v-model="form.question_text"
      ></textarea>
      <button
        type="submit"
        class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 mb-3"
      >
        Update Question
      </button>
    </form>
  </div>
</template>


