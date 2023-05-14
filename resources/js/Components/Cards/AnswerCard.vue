<script setup>
import AnswerEditFormModal from "@/Components/Modals/AnswerEditFormModal.vue";
import { router, usePage } from "@inertiajs/vue3";

const props = defineProps({
  question: Object,
});

const handleDeleteAnswer = () => {
  router.post(
    route("product.question.answer.destroy", {
      product_question_id: props.question.id,
      user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
    }),
    {},
    {
      replace: true,
      preserveScroll: true,
    }
  );
};
</script>


<template>
  <div v-if="question.product_answer" class="w-[95%] ml-auto">
    <div class="flex items-start justify-between my-3">
      <div class="flex items-center">
        <img
          :src="question.product_answer.user.avatar"
          alt=""
          class="w-10 h-10 object-cover rounded-full mr-5"
        />
        <div>
          <h4 class="text-lg font-bold text-slate-700">
            {{ question.product_answer.user.shop_name }}
            <span
              class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.7rem] ml-2"
            >
              <i class="fa-solid fa-circle-check"></i>
              Verified
            </span>
          </h4>
          <p class="text-[.8rem] text-slate-500">Answer From Store</p>
        </div>
      </div>
      <div class="">
        <span class="text-slate-500 text-sm font-bold">
          {{ question.product_answer.created_at }}
        </span>
      </div>
    </div>
    <p class="w-[92%] text-sm font-normal text-slate-900 ml-auto">
      {{ question.product_answer.answer_text }}
    </p>

    <div
      v-if="$page.props.auth.user.id === question.product_answer.user.id"
      class="flex items-center justify-end"
    >
      <AnswerEditFormModal :question="question" />

      <button
        @click="handleDeleteAnswer"
        class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 mt-5 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
        type="button"
      >
        Delete Answer
      </button>
    </div>
  </div>
</template>
