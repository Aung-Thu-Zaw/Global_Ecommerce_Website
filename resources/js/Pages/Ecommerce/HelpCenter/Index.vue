<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import QuestionCategoryCard from "@/Components/Cards/QuestionCategoryCard.vue";
import SelfServiceToolCards from "@/Components/Cards/SelfServiceToolCards.vue";
import QuestionSearchForm from "@/Components/Forms/QuestionSearchForm.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  topQuestions: Object,
  faqSubCategories: Object,
});
</script>

<template>
  <AppLayout>
    <Head title="Help Center" />

    <div class="min-h-[1700px] h-auto mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl">
          Global E-commerce {{ __("HELP_CENTER") }}
        </h1>
      </div>

      <!-- Question Search Input -->
      <div class="mb-5 pt-5 pb-10">
        <img
          src="../../../assets/images/faq.png"
          class="w-full h-[200px] object-contain"
        />
        <div class="container mx-auto flex flex-col items-center">
          <h1 class="font-bold text-dark mb-5 text-3xl">
            {{ __("HI_HOW_CAN_WE_HELP") }}
          </h1>
          <div>
            <QuestionSearchForm />
          </div>
        </div>
      </div>

      <!-- Top Questions -->
      <div class="container mx-auto mb-12">
        <div class="flex items-center mb-5 justify-center">
          <h1
            class="font-bold text-gray-600 mb-5 text-xl py-2 inline border-b-2 border-b-slate-500"
          >
            {{ __("TOP_QUESTIONS") }}
          </h1>
        </div>

        <div class="grid grid-cols-3 gap-y-3 text-sm text-slate-800">
          <Link
            v-for="topQuestion in topQuestions"
            :key="topQuestion.id"
            class="flex items-center justify-start"
            :href="route('faqs.show', topQuestion.slug)"
          >
            <i class="fa-solid fa-circle mr-2 text-[.5rem]"></i>
            <span class="hover:text-blue-700 hover:underline font-medium"> {{ topQuestion.question }}</span>
          </Link>
        </div>
      </div>

      <!-- Question Categories -->
      <div class="container mx-auto mb-12">
        <div class="flex items-center mb-5 justify-center">
          <h1
            class="font-bold text-gray-600 mb-5 text-xl py-2 inline border-b-2 border-b-slate-500"
          >
            {{ __("QUESTION_CATEGORIES") }}
          </h1>
        </div>

        <div class="grid grid-cols-4 gap-y-4 px-12">
          <div
            v-for="faqSubCategory in faqSubCategories"
            :key="faqSubCategory.id"
          >
            <QuestionCategoryCard :faqSubCategory="faqSubCategory" />
          </div>
        </div>
      </div>

      <!-- Self Service Tools -->
      <div class="container mx-auto">
        <div class="flex items-center mb-5 justify-center">
          <h1
            class="font-bold text-gray-600 mb-5 text-xl py-2 inline border-b-2 border-b-slate-500"
          >
            {{ __("SELF_SERVICE_TOOLS") }}
          </h1>
        </div>

        <div class="grid grid-cols-4 gap-y-4 px-12">
          <SelfServiceToolCards />
        </div>
      </div>

      <!-- Contact Us -->
      <div class="container mx-auto my-10">
        <p class="text-[.8rem] text-slate-700 text-center font-bold">
          {{ __("STILL_LOOKING_FOR_ANSWERS") }}
        </p>

        <div class="flex items-center justify-center space-x-10 mt-10">
          <!-- Chat Now Card -->
          <div
            class="rounded-md w-[250px] text-white flex items-center bg-orange-600 px-5 py-3"
          >
            <span class="mr-5">
              <i class="fa-solid fa-message text-lg"></i>
            </span>
            <div class="flex flex-col items-start justify-center">
              <span class="text-lg font-bold">{{ __("CHAT_NOW") }}</span>
              <span class="text-[.7rem]">8:00 AM - 09:30 PM</span>
            </div>
          </div>

          <!-- Email Card -->
          <Link
            as="button"
            href="#"
            class="rounded-md w-[250px] text-white flex items-center bg-blue-700 px-5 py-3"
          >
            <span class="mr-5">
              <i class="fa-solid fa-phone text-lg"></i>
            </span>
            <div class="flex flex-col items-start justify-center">
              <span class="text-lg font-bold">{{ __("PHONE_CALL") }}</span>
              <span class="text-[.7rem]">8:00 AM - 09:30 PM</span>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

