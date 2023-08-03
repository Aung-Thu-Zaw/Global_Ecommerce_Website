<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

defineProps({
  topQuestions: Object,
  faqSubCategories: Object,
});

const params = reactive({
  search_question: usePage().props.ziggy.query?.search_question,
  page: usePage().props.ziggy.query?.page,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("help-center.questions.search"),
    {
      search_question: params.search_question,
      page: params.page,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search_question = "";
  router.get(
    route("help-center.questions.search"),
    {},
    {
      replace: true,
      preserveState: true,
    }
  );
};
</script>

<template>
  <AppLayout>
    <Head title="Help Center" />

    <div class="min-h-[1700px] h-auto mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl">Global E-commerce Help Center</h1>
      </div>

      <!-- Question Search Input -->
      <div class="mb-5 pt-5 pb-10">
        <img
          src="../../../assets/images/faq.png"
          class="w-full h-[200px] object-contain"
        />
        <div class="container mx-auto flex flex-col items-center">
          <h1 class="font-bold text-dark mb-5 text-3xl">
            Hi, How can we help?
          </h1>
          <div>
            <form
              @submit.prevent="handleSearch"
              class="w-[700px] h-[50px] mx-auto"
            >
              <div class="flex items-center justify-between">
                <div class="relative">
                  <input
                    type="text"
                    class="w-[650px] h-full py-3 rounded-md borde-2 border-slate-400 focus:ring-0 focus:border-slate-400"
                    autofocus
                    placeholder="Search for a question..."
                    v-model="params.search_question"
                  />
                  <i
                    v-if="params.search_question"
                    class="fa-solid fa-xmark remove-search"
                    @click="removeSearch"
                  ></i>
                </div>

                <button
                  class="bg-blue-600 text-white px-6 py-3 h-full rounded-md hover:bg-blue-700 ml-2"
                >
                  <i class="fa-solid fa-magnifying-glass"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Top Questions -->
      <div class="container mx-auto mb-12">
        <div class="flex items-center mb-5 justify-center">
          <h1
            class="font-bold text-gray-600 mb-5 text-xl py-2 inline border-b-2 border-b-slate-500"
          >
            Top Questions
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
            <span class="hover:text-blue-700"> {{ topQuestion.question }}</span>
          </Link>
        </div>
      </div>

      <!-- Question Categories -->
      <div class="container mx-auto mb-12">
        <div class="flex items-center mb-5 justify-center">
          <h1
            class="font-bold text-gray-600 mb-5 text-xl py-2 inline border-b-2 border-b-slate-500"
          >
            Question Categories
          </h1>
        </div>

        <div class="grid grid-cols-4 gap-y-4 px-12">
          <Link
            v-for="faqSubCategory in faqSubCategories"
            :key="faqSubCategory.id"
            :href="route('faqs.index')"
            :data="{
              search_question: $page.props.ziggy.query.search_question,
              category: faqSubCategory.slug,
            }"
            class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
          >
            <span
              class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
            >
              <i v-html="faqSubCategory.icon"></i>
            </span>
            <span class="text-gray-700 font-bold text-sm mt-3">{{
              faqSubCategory.name
            }}</span>
          </Link>
        </div>
      </div>

      <!-- Self Service Tools -->
      <div class="container mx-auto">
        <div class="flex items-center mb-5 justify-center">
          <h1
            class="font-bold text-gray-600 mb-5 text-xl py-2 inline border-b-2 border-b-slate-500"
          >
            Self Service Tools
          </h1>
        </div>

        <div class="grid grid-cols-4 gap-y-4 px-12">
          <Link
            :href="route('my-account.edit')"
            :data="{ tab: 'edit-profile' }"
            class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
          >
            <span
              class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
            >
              <i class="fa-solid fa-user-gear"></i>
            </span>
            <span class="text-gray-700 font-bold text-sm mt-3">My Account</span>
          </Link>

          <Link
            :href="route('my-orders.index')"
            :data="{ tab: 'all-orders' }"
            class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
          >
            <span
              class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
            >
              <i class="fa-solid fa-boxes-packing"></i>
            </span>
            <span class="text-gray-700 font-bold text-sm mt-3">My Orders</span>
          </Link>

          <Link
            :href="route('return-orders.index')"
            :data="{ tab: 'requested-return-orders' }"
            class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
          >
            <span
              class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
            >
              <i class="fa-solid fa-money-check-dollar"></i>
            </span>
            <span class="text-gray-700 font-bold text-sm mt-3"
              >Return Orders And Items</span
            >
          </Link>

          <Link
            :href="route('cancel-orders.index')"
            :data="{ tab: 'requested-cancel-orders' }"
            class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
          >
            <span
              class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
            >
              <i class="fa-solid fa-truck-fast"></i>
            </span>
            <span class="text-gray-700 font-bold text-sm mt-3"
              >Cancel Orders And Items</span
            >
          </Link>
        </div>
      </div>

      <!-- Contact Us -->
      <div class="container mx-auto my-10">
        <p class="text-[.8rem] text-slate-700 text-center font-bold">
          Still looking for answers? Ask anytime, day or night, just click on
          "Chat Now" below to speak with us via live chat daily from 8:00 AM-
          09:30 PM (Monday to Sunday)
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
              <span class="text-lg font-bold">Chat Now</span>
              <span class="text-[.7rem]">8:00 AM- 09:30 PM</span>
            </div>
          </div>

          <span class="font-bold text-slate-700 text-lg">Or</span>

          <!-- Email Card -->
          <div
            class="rounded-md w-[250px] text-white flex items-center bg-blue-700 px-5 py-3"
          >
            <span class="mr-5">
              <i class="fa-solid fa-envelope text-lg"></i>
            </span>
            <div class="flex flex-col items-start justify-center">
              <span class="text-lg font-bold">Send Email</span>
              <span class="text-[.7rem]">You can send mail to our</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

