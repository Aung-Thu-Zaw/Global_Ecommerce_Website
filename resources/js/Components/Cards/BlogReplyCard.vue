<script setup>
import AnswerEditForm from "@/Components/Forms/AnswerEditForm.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  blogCommentReply: Object,
});

// const isEditAnswerFormVisible = ref(false);

// const handleDeleteAnswer = () => {
//   router.post(
//     route("product.question.answer.destroy", {
//       answer_id: props.question.product_answer.id,
//     }),
//     {},
//     {
//       replace: true,
//       preserveScroll: true,
//     }
//   );
// };
</script>


<template>
  <div v-if="blogCommentReply" class="w-[95%] ml-auto">
    <div class="flex items-start justify-between my-3">
      <div class="flex items-center">
        <img
          :src="blogCommentReply.author.avatar"
          class="z-10 w-10 h-10 object-cover rounded-full mr-5 ring-2 ring-orange-300"
        />
        <div>
          <h4 class="text-lg font-bold text-slate-700">
            {{ blogCommentReply.author.name }}
          </h4>
          <p class="text-[.8rem] text-slate-500">Reply From Author</p>
        </div>
      </div>
      <div class="">
        <span class="text-slate-500 text-sm font-bold">
          {{ blogCommentReply.updated_at }}
        </span>
      </div>
    </div>
    <p class="w-[93%] text-sm font-normal text-slate-900 ml-auto">
      {{ blogCommentReply.reply_text }}
    </p>

    <div
      v-if="
        $page.props.auth.user &&
        $page.props.auth.user.id === blogCommentReply.author.id
      "
      class="flex flex-col items-end"
    >
      <div class="my-3">
        <button
          @click="isEditAnswerFormVisible = !isEditAnswerFormVisible"
          class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
        >
          <i class="fa-solid fa-flag"></i>
          Edit Answer
        </button>

        <button
          @click="handleDeleteAnswer"
          class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
          type="button"
        >
          <i class="fa-solid fa-trash"></i>
          Delete Answer
        </button>
      </div>

      <!-- <div v-if="isEditAnswerFormVisible" class="w-full">
        <AnswerEditForm
          :question="question"
          @isVisible="isEditAnswerFormVisible = false"
        />
      </div> -->
    </div>
  </div>
</template>
