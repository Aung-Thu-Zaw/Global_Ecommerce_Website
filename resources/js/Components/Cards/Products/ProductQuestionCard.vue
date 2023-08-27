<script setup>
import ProductQuestionAnswerForm from "@/Components/Forms/Products/ProductQuestionAnswerForm.vue";
import ProductQuestionEditForm from "@/Components/Forms/Products/ProductQuestionEditForm.vue";
import { usePage, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  product: Object,
  question: Object,
});

const isEditQuestionFormVisible = ref(false);
const isAnswerFormVisible = ref(false);
const authenticatedUser = ref(
  usePage().props.auth.user ? usePage().props.auth.user : null
);

const handleDeleteQuestion = () => {
  router.delete(
    route("product.questions.destroy", {
      product_question: props.question?.id,
    }),
    {
      replace: true,
      preserveScroll: true,
    }
  );
};
</script>


<template>
  <div class="relative w-full">
    <div class="flex flex-col items-end w-full">
      <div class="flex items-start justify-between w-full mb-1">
        <div class="flex items-start">
          <img
            :src="question.user?.avatar"
            class="z-10 w-10 h-10 object-cover rounded-full mr-5 ring-2 ring-gray-200 shadow"
          />
          <div>
            <h4 class="text-lg font-bold text-slate-700">
              {{ question.user?.name }}
            </h4>
            <p class="text-[.8rem] text-slate-500">Question From User</p>
          </div>
        </div>

        <span class="text-slate-500 text-sm font-bold">
          {{ question.updated_at }}
        </span>
      </div>

      <p class="w-[93%] text-sm font-normal text-slate-900 ml-auto mb-3">
        {{ question.question_text }}
      </p>
    </div>

    <!-- Answer Button For Seller -->
    <div
      v-if="
        !question.product_answer &&
        authenticatedUser &&
        product.seller_id === authenticatedUser.id
      "
      class="my-3 flex items-center justify-end w-full"
    >
      <button
        @click="isAnswerFormVisible = !isAnswerFormVisible"
        class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
      >
        <i class="fa-solid fa-flag"></i>
        {{ __("ANSWER_THIS_QUESTION") }}
      </button>
    </div>

    <!-- Edit Question Button And Delete Question Button For Customer -->
    <div
      v-if="authenticatedUser && authenticatedUser.id === question.user_id"
      class="mb-3 flex items-center justify-end w-full"
    >
      <button
        v-if="!question.product_answer"
        @click="isEditQuestionFormVisible = !isEditQuestionFormVisible"
        class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
      >
        <i class="fa-solid fa-flag"></i>
        {{ __("EDIT_QUESTION") }}
      </button>

      <button
        @click="handleDeleteQuestion"
        class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
        type="button"
      >
        <i class="fa-solid fa-trash mr-1"></i>
        {{ __("DELETE_QUESTION") }}
      </button>
    </div>

    <!-- Edit Question Form For Customer -->
    <div v-if="isEditQuestionFormVisible" class="w-full">
      <ProductQuestionEditForm
        :question="question"
        :product="product"
        @isVisible="isEditQuestionFormVisible = false"
      />
    </div>

    <!-- Answer Question Form For Seller -->
    <div v-if="isAnswerFormVisible" class="w-full">
      <ProductQuestionAnswerForm
        :product="product"
        :question="question"
        @isVisible="isAnswerFormVisible = false"
      />
    </div>

    <hr v-if="question.product_answer" class="my-3" />
  </div>
</template>
