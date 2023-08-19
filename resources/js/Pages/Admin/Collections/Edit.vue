<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CollectionBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  collection: Object,
});

// Define Variables
const processing = ref(false);

// Collection Edit Form Data
const form = useForm({
  title: props.collection?.title,
  description: props.collection?.description,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Brand
const handleEditCollection = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_collection");

  processing.value = true;
  form.patch(
    route("admin.collections.update", {
      collection: props.collection.slug,
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
    <Head :title="__('EDIT_COLLECTION')" />
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
                >{{ collection.title }}
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
            href="admin.collections.index"
            :queryStringParams="queryStringParams"
          />
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditCollection">
          <!-- Collection Title Input -->
          <div class="mb-6">
            <InputLabel for="title" :value="__('COLLECTION_TITLE') + ' *'" />

            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              required
              :placeholder="__('ENTER_COLLECTION_TITLE')"
            />

            <InputError class="mt-2" :message="form.errors.title" />
          </div>

          <!-- Collection Description Input -->
          <div class="mb-6">
            <InputLabel
              for="description"
              :value="__('COLLECTION_DESCRIPTION') + ' *'"
            />

            <TextInput
              id="description"
              type="text"
              class="mt-1 block w-full"
              v-model="form.description"
              required
              :placeholder="__('ENTER_COLLECTION_DESCRIPTION')"
            />

            <InputError class="mt-2" :message="form.errors.description" />
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
