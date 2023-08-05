<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import QuestionSearchForm from "@/Components/Forms/QuestionSearchForm.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";

const props = defineProps({
  faqs: Object,
});
</script>

<template>
  <AppLayout>
    <Head title="Help Center" />

    <div class="min-h-[2300px] h-auto bg-gray-50 mt-40 w-full">
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
            <QuestionSearchForm />
          </div>
        </div>
      </div>

      <!-- Search Results -->

      <div
        class="container mx-auto border bg-white p-10 rounded-md shadow-lg mb-10"
      >
        <p
          v-if="$page.props.ziggy.query?.search_question"
          class="text-sm font-bold my-5 text-gray-700"
        >
          {{ faqs.total }} {{ __("QUESTION_FOUND_FOR_SEARCH_RESULT") }}
          <span class="text-blue-600"
            >"{{ $page.props.ziggy.query?.search_question }}"</span
          >
        </p>
        <ul class="list-disc">
          <li v-for="faq in faqs.data" :key="faq.id">
            <Link
              :href="route('faqs.show', faq.slug)"
              class="text-md font-bold mb-2 text-blue-600 hover:underline"
            >
              {{ faq.question }}
            </Link>
            <p
              v-html="faq.answer"
              class="line-clamp-2 text-sm text-gray-600 mb-5"
            ></p>
          </li>
        </ul>

        <!-- Question Not Found -->
        <p
          v-if="!faqs.data.length"
          class="my-3 font-bold text-slate-500 text-center"
        >
          {{
            __("WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_SEARCH_TERM")
          }}
        </p>
      </div>

      <!-- Pagination -->
      <div class="mt-10 mb-5">
        <Pagination :links="faqs.links" />
      </div>
    </div>
  </AppLayout>
</template>

