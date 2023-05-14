<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  product: Object,
  question: Object,
});

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
      onFinish: () => (form.question_text = ""),
    }
  );
};
</script>

<template>
  <!-- Modal toggle -->
  <div
    v-if="$page.props.auth.user.id === question.user_id"
    class="flex items-center justify-end"
  >
    <button
      :data-modal-target="'edit-question-modal-' + question.id"
      :data-modal-toggle="'edit-question-modal-' + question.id"
      class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
      type="button"
    >
      <i class="fa-solid fa-edit"></i>
      Edit Questions
    </button>
  </div>

  <!-- Main modal -->
  <div
    :id="'edit-question-modal-' + question.id"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
  >
    <div class="relative w-full max-w-3xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-full">
        <button
          type="button"
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
          :data-modal-hide="'edit-question-modal-' + question.id"
        >
          <svg
            aria-hidden="true"
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>

        <div class="px-6 py-6 lg:px-8">
          <form @submit.prevent="handleQuestionEdit" class="space-y-3 mr-5">
            <textarea
              cols="30"
              rows="10"
              class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
              v-model="form.question_text"
            ></textarea>
            <button
              type="submit"
              :data-modal-hide="'edit-question-modal-' + question.id"
              class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 mb-3"
            >
              Update Answer
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>


