<script setup>
import ProductQuestionCard from "@/Components/Cards/Products/ProductQuestionCard.vue";
import ProductQuestionAnswerCard from "@/Components/Cards/Products/ProductQuestionAnswerCard.vue";
import ProductQuestionCreateForm from "@/Components/Forms/Products/ProductQuestionCreateForm.vue";
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import Pagination from "@/Components/Paginations/Pagination.vue";

const props = defineProps({
  product: Object,
  productQuestions: Object,
});
</script>

<template>
  <div class="border border-gray-200 shadow-sm rounded bg-white w-full">
    <h3 class="text-lg font-bold text-slate-700 border-b pb-3 mb-3 p-5">
      {{ __("ASK_QUESTIONS_ABOUT_THIS_PRODCUT") }}
    </h3>
    <div class="w-full">
      <p class="font-bold text-md text-slate-600 px-5 mb-5">
        {{ __("TOTAL_QUESTIONS") }} ({{ productQuestions.total }})
      </p>

      <div v-if="productQuestions.data.length" class="px-5 w-full">
        <div
          v-for="question in productQuestions.data"
          :key="question.id"
          class="shadow relative border rounded-md p-5 flex flex-col items-start my-5 w-full"
        >
          <div class="flex flex-col items-start w-full">
            <ProductQuestionCard
              :product="product"
              :question="question"
              @isVisible="handleVisible"
            />
            <ProductQuestionAnswerCard :question="question" />
          </div>
        </div>

        <!-- Pagination -->
        <div class="my-5">
          <Pagination :links="productQuestions.links" />
        </div>
      </div>
      <div v-else class="px-5 w-full">
        <p class="text-center font-bold text-slate-500 my-6">
          <i class="fa-solid fa-circle-question"></i>
          {{ __("QUESTIONS_NOT_YET") }}
        </p>
      </div>

      <hr />

      <!-- Question Form For Authenticated User -->
      <div
        v-if="
          $page.props.auth.user &&
          $page.props.auth.user.id !== product.seller_id
        "
        class="p-5"
      >
        <ProductQuestionCreateForm :product="product" />
      </div>
      <!-- Links For Unauthenticated User -->
      <div v-else-if="!$page.props.auth.user" class="px-5 my-5">
        <p class="font-bold text-sm text-slate-600 text-center">
          {{ __("IF_YOU_WANT_TO_ASK_QUESTIONS_YOU_NEED_TO_LOGIN_FIRST_HERE") }}
          <Link :href="route('login')" class="text-blue-600 underline">
            {{ __("SIGN_IN") }}
          </Link>
          {{ __("Or") }}
          <Link :href="route('register')" class="text-blue-600 underline">
            {{ __("SIGN_UP") }}
          </Link>
        </p>
      </div>
    </div>
  </div>
</template>
