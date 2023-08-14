<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FaqCategoryBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  faqCategories: Object,
  faqSubCategory: Object,
});

// Define Variables
const processing = ref(false);

// Faq Category Edit Form Data
const form = useForm({
  icon: props.faqSubCategory?.icon,
  faq_category_id: props.faqSubCategory?.faq_category_id,
  name: props.faqSubCategory?.name,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Faq Category
const handleEditFaqSubCategory = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_faq_sub_category");

  processing.value = true;
  form.patch(
    route("admin.faq-categories.sub-categories.update", {
      faq_sub_category: props.faqSubCategory.slug,
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
    <Head :title="__('EDIT_FAQ_SUBCATEGORY')" />
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
                {{ __("SUBCATEGORIES") }}
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
                >{{ faqSubCategory.name }}
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
                >{{ __("EDIT") }}</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <Link
            as="button"
            :href="route('admin.faq-categories.sub-categories.index')"
            :data="{
              page: queryStringParams.page,
              per_page: queryStringParams.per_page,
              sort: queryStringParams.sort,
              direction: queryStringParams.direction,
            }"
          >
            <GoBackButton />
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditFaqSubCategory">
          <!-- Icon Input -->
          <div class="mb-6">
            <InputLabel for="icon" :value="__('ICON') + ' *'" />

            <TextInput
              id="icon"
              type="text"
              class="mt-1 block w-full"
              v-model="form.icon"
              required
              :placeholder="__('ENTER_FONTAWESOME_ICON')"
            />

            <InputError class="mt-2" :message="form.errors.icon" />
          </div>

          <!-- Faq SubCategory Name Input -->
          <div class="mb-6">
            <InputLabel for="name" :value="__('FAQ_SUBCATEGORY_NAME') + ' *'" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              :placeholder="__('ENTER_SUBCATEGORY_NAME')"
            />

            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Faq Category Select Box -->
          <div class="mb-6">
            <InputLabel for="faq_category" :value="__('FAQ_CATEGORY') + ' *'" />

            <select
              v-model="form.faq_category_id"
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            >
              <option value="" selected disabled>
                {{ __("SELECT_FAQ_CATEGORY") }}
              </option>
              <option
                v-for="faqCategory in faqCategories"
                :key="faqCategory.id"
                :value="faqCategory.id"
                :selected="faqCategory.id === form.faq_category_id"
              >
                {{ faqCategory.name }}
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.faq_category_id" />
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


