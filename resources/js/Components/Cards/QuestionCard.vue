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
        <div class="flex items-start">
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

        <div class="flex items-center">
          <span class="text-slate-500 text-sm font-bold">
            {{ question.created_at }}
          </span>
          <button
            :id="'dropdownMenuIconButton' + question.id"
            :data-dropdown-toggle="'dropdownDot' + question.id"
            class="inline-flex items-center text-sm text-center text-gray-700 bg-white focus:outline-none ml-5"
            type="button"
          >
            <svg
              class="w-5 h-5"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"
              ></path>
            </svg>
          </button>
        </div>

        <!-- Dropdown menu -->
        <div
          :id="'dropdownDot' + question.id"
          class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
        >
          <ul
            class="py-2 text-sm text-gray-700 dark:text-gray-200"
            :aria-labelledby="'dropdownMenuIconButton' + question.id"
          >
            <li>
              <a
                href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
              >
                Hide Question
              </a>
            </li>
            <li>
              <a
                href="#"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
              >
                Delete Question
              </a>
            </li>
          </ul>
        </div>
      </div>
      <p class="w-full text-sm font-normal text-slate-900">
        {{ question.question_text }}
      </p>
    </div>

    <AnswerFormModal :product="product" :question="question" />
  </div>
</template>
