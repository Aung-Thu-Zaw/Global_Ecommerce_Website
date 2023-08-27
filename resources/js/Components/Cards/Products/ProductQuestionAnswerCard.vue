<script setup>
import ProductQuestionAnswerEditForm from "@/Components/Forms/Products/ProductQuestionAnswerEditForm.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  question: Object,
});

const isEditAnswerFormVisible = ref(false);

const handleDeleteAnswer = () => {
  router.delete(
    route("product.questions.answer.destroy", {
      product_answer: props.question.product_answer.id,
    }),
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
          :src="question.product_answer?.seller?.avatar"
          class="z-10 w-10 h-10 object-cover rounded-full mr-5 ring-2 ring-gray-200 shadow"
        />
        <div>
          <h4
            class="text-lg font-bold text-slate-700 max-w-[400px] line-clamp-1"
          >
            {{ question.product_answer?.seller?.shop_name }}
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
          {{ question.product_answer?.updated_at }}
        </span>
      </div>
    </div>
    <p class="w-[93%] text-sm font-normal text-slate-900 ml-auto">
      {{ question.product_answer?.answer_text }}
    </p>

    <div
      v-if="
        $page.props.auth.user &&
        $page.props.auth.user.id === question.product_answer?.seller?.id
      "
      class="flex flex-col items-end"
    >
      <div class="my-3">
        <!-- Edit Button -->
        <button
          @click="isEditAnswerFormVisible = !isEditAnswerFormVisible"
          class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
        >
          <i class="fa-solid fa-flag"></i>
          {{ __("EDIT_ANSWER") }}
        </button>

        <!-- Delete Button -->
        <button
          @click="handleDeleteAnswer"
          class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
          type="button"
        >
          <i class="fa-solid fa-trash"></i>
          {{ __("DELETE_ANSWER") }}
        </button>
      </div>

      <div v-if="isEditAnswerFormVisible" class="w-full">
        <ProductQuestionAnswerEditForm
          :question="question"
          @isVisible="isEditAnswerFormVisible = false"
        />
      </div>
    </div>
  </div>
</template>
