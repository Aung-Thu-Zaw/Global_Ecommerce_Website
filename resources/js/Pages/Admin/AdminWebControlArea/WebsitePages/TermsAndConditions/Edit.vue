<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/PageBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { usePage, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref, inject } from "vue";

// Define the props
const props = defineProps({
  termsAndConditions: Object,
});

// Define Variables
const editor = ClassicEditor;
const swal = inject("$swal");
const processing = ref(false);

// Privacy Policy Edit Form Data
const form = useForm({
  title: props.termsAndConditions?.title,
  description: props.termsAndConditions?.description,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Terms And Conditions
const handleEditTermsAndConditions = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_terms_and_conditions");

  processing.value = true;

  form.patch(
    route("admin.pages.terms-and-conditions.update", {
      page: props.termsAndConditions.id,
    }),
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing.value = false;
      },
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          swal({
            icon: "success",
            title: __(usePage().props.flash.successMessage),
          });
        }
      },
    }
  );
};

// Terms And Conditions Edit Permission
const termsAndConditionsEdit = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "page.edit"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('TERMS_AND_CONDITIONS')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb>
          <li>
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
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                >{{ __("TERMS_AND_CONDITIONS") }}</span
              >
            </div>
          </li>
        </Breadcrumb>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditTermsAndConditions">
          <!-- Title Input -->
          <div class="mb-6">
            <InputLabel for="title" :value="__('TITLE') + ' *'" />

            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              required
              :placeholder="__('ENTER_TITLE')"
            />

            <InputError class="mt-2" :message="form.errors.title" />
          </div>

          <!-- Description Editor -->
          <div class="mb-6">
            <InputLabel for="description" :value="__('DESCRIPTION') + ' *'" />

            <ckeditor :editor="editor" v-model="form.description"></ckeditor>

            <InputError class="mt-2" :message="form.errors.description" />
          </div>

          <!-- Edit Button -->
          <div v-if="termsAndConditionsEdit" class="mb-6">
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<style>
.ck-editor__editable_inline {
  min-height: 450px;
  border-radius: 200px;
}

:root {
  --ck-border-radius: 0.375rem;
  --ck-color-focus-border: rgb(209 213 219);
  --ck-font-size-base: 0.7rem;
  --ck-color-shadow-drop: none;
  --ck-color-shadow-inner: none;
}
</style>
