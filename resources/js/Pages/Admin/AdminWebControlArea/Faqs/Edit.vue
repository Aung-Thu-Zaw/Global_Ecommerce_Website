<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FaqBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  faqSubCategories: Object,
  faq: Object,
});

// Define Variables
const processing = ref(false);
const editor = ClassicEditor;

// Faq Category Edit Form Data
const form = useForm({
  faq_sub_category_id: props.faq?.faq_sub_category_id,
  question: props.faq?.question,
  answer: props.faq?.answer,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Faq
const handleEditFaq = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_faq");

  processing.value = true;
  form.patch(
    route("admin.faqs.update", {
      faq: props.faq.slug,
      page: props.queryStringParams.page,
      per_page: props.queryStringParams.per_page,
      sort: props.queryStringParams.sort,
      direction: props.queryStringParams.direction,
    }),
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing.value = false;
      },
    }
  );
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('EDIT_FAQ')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
              >
                {{ faq.question }}
              </span>
            </div>
          </li>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
              >
                {{ __("EDIT") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <GoBackButton
            href="admin.faqs.index"
            :queryStringParams="queryStringParams"
          />
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditFaq">
          <!-- Faq Question Input -->
          <div class="mb-6">
            <InputLabel for="question" :value="__('QUESTION') + ' *'" />

            <TextInput
              id="question"
              type="text"
              class="mt-1 block w-full"
              v-model="form.question"
              required
              :placeholder="__('ENTER_QUESTION')"
            />

            <InputError class="mt-2" :message="form.errors.question" />
          </div>

          <!-- Faq Answer Editor -->
          <div class="mb-6">
            <InputLabel for="answer" :value="__('ANSWER') + ' *'" />

            <ckeditor :editor="editor" v-model="form.answer"></ckeditor>

            <InputError class="mt-2" :message="form.errors.answer" />
          </div>

          <!-- Faq SubCategory Select Box -->
          <div class="mb-6">
            <InputLabel
              for="faq_sub_category"
              :value="__('FAQ_SUBCATEGORY') + ' *'"
            />

            <select
              v-model="form.faq_sub_category_id"
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            >
              <option value="" selected disabled>
                {{ __("SELECT_FAQ_SUBCATEGORY") }}
              </option>
              <option
                v-for="faqSubCategory in faqSubCategories"
                :key="faqSubCategory.id"
                :value="faqSubCategory.id"
                :selected="faqSubCategory.id === form.faq_sub_category_id"
              >
                {{ faqSubCategory.name }}
              </option>
            </select>

            <InputError
              class="mt-2"
              :message="form.errors.faq_sub_category_id"
            />
          </div>

          <!-- Save Button -->
          <div class="mb-6">
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
