<script setup>
import QuestionCard from "@/Components/Cards/QuestionCard.vue";
import AnswerCard from "@/Components/Cards/AnswerCard.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import Pagination from "@/Components/Paginations/Pagination.vue";

const props = defineProps({
  product: Object,
  productQuestions: Object,
});

const form = useForm({
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  product_id: props.product.id,
  question_text: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleAskQuestion = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("ask_question");
  submit();
};

const submit = () => {
  form.post(route("product.question.store"), {
    replace: true,
    preserveScroll: true,
    onFinish: () => (form.question_text = ""),
  });
};
</script>

<template>
  <div class="border border-gray-200 shadow-sm rounded bg-white w-full">
    <h3 class="text-lg font-bold text-slate-700 border-b pb-3 mb-3 p-5">
      Ask Questions About This Product
    </h3>

    <div class="w-full">
      <p class="font-bold text-md text-slate-600 px-5 mb-5">
        Total Questions ({{ productQuestions.data.length }})
      </p>

      <div v-if="productQuestions.data.length" class="px-5 w-full">
        <div
          v-for="question in productQuestions.data"
          :key="question.id"
          class="shadow relative border rounded-md p-5 flex flex-col items-start my-5 w-full"
        >
          <div class="flex flex-col items-start w-full">
            <QuestionCard
              :product="product"
              :question="question"
              @isVisible="handleVisible"
            />
            <AnswerCard :question="question" />
          </div>
        </div>

        <!-- Pagination -->
        <div class="my-5">
          <Pagination :links="productQuestions.links" />
        </div>
      </div>
      <div v-else class="px-5 w-full">
        <p class="text-center font-bold text-slate-500 my-6">
          <i class="fa-solid fa-circle-question"></i>
          Questions Not Yet
        </p>
      </div>

      <hr />

      <div
        v-if="
          $page.props.auth.user && $page.props.auth.user.id !== product.user_id
        "
        class="p-5"
      >
        <form @submit.prevent="handleAskQuestion">
          <textarea
            cols="30"
            rows="10"
            class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
            placeholder="Write question what you want to ask about this product"
            v-model="form.question_text"
          ></textarea>
          <button
            class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 my-5"
          >
            Ask Question
          </button>
        </form>
      </div>
      <div v-else-if="!$page.props.auth.user" class="px-5 my-5">
        <p class="font-bold text-sm text-slate-600 text-center">
          If you want to ask questions you need to login first. Here
          <Link :href="route('login')" class="text-blue-600 underline">
            Login
          </Link>
          Or
          <Link :href="route('register')" class="text-blue-600 underline">
            Register
          </Link>
        </p>
      </div>
    </div>
  </div>
</template>
