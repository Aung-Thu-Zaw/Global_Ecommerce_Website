<script setup>
import AnswerFormModal from "@/Components/Modals/AnswerFormModal.vue";

const props = defineProps({
  product: Object,
  question: Object,
});
</script>


<template>
  <div class="w-full">
    <div class="flex flex-col items-end w-full">
      <div class="flex items-start justify-between w-full mb-1">
        <div class="flex items-center">
          <img
            src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
            alt=""
            class="w-10 h-10 object-cover rounded-full mr-5"
          />
          <div>
            <h4 class="text-lg font-bold text-slate-700">
              {{ question.user.name }}
            </h4>
            <p class="text-[.8rem] text-slate-500">Question From User</p>
          </div>
        </div>

        <span class="text-slate-500 text-sm font-bold">
          {{ question.created_at }}
        </span>
      </div>
      <p class="w-full text-sm font-normal text-slate-900">
        {{ question.question_text }}
      </p>
    </div>

    <AnswerFormModal :product="product" :question="question" />
  </div>
</template>
