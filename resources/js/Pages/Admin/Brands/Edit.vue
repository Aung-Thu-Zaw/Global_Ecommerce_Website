<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BrandBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  brand: Object,
  categories: Object,
});

// Define Variables
const editor = ClassicEditor;
const processing = ref(false);
const previewPhoto = ref("");

// Handle Preview Image
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

// Brand Edit Form Data
const form = useForm({
  name: props.brand?.name,
  image: props.brand?.image,
  category_id: props.brand?.category_id,
  description: props.brand?.description,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Brand
const handleEditBrand = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_brand");

  processing.value = true;
  form.post(
    route("admin.brands.update", {
      brand: props.brand.slug,
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
    <Head :title="__('EDIT_BRAND')" />
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
                {{ brand.name }}
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
          <Link
            as="button"
            :href="route('admin.brands.index')"
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
        <!-- Preview Image -->
        <div class="mb-6">
          <img ref="previewPhoto" :src="form.image" class="preview-img" />
        </div>

        <form @submit.prevent="handleEditBrand">
          <!-- Brand Name Input -->
          <div class="mb-6">
            <InputLabel for="name" :value="__('BRAND_NAME') + ' *'" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              :placeholder="__('ENTER_BRAND_NAME')"
            />

            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Brand Description Editor -->
          <div class="mb-6">
            <InputLabel
              for="description"
              :value="__('BRAND_DESCRIPTION') + ' *'"
            />

            <ckeditor :editor="editor" v-model="form.description"></ckeditor>

            <InputError class="mt-2" :message="form.errors.description" />
          </div>

          <!-- Brand Select Box -->
          <div class="mb-6">
            <InputLabel for="category" :value="__('CATEGORY')" />

            <select class="select-box" v-model="form.category_id">
              <option value="" selected disabled>
                {{ __("SELECT_CATEGORY") }}
              </option>
              <option
                v-for="category in categories"
                :key="category"
                :value="category.id"
                :selected="category.id === form.category_id"
              >
                {{ category.name }}
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.category_id" />
          </div>

          <div class="mb-6">
            <InputLabel for="image" :value="__('IMAGE') + ' *'" />

            <!-- Brand File Input -->
            <input
              class="file-input"
              type="file"
              id="image"
              @input="form.image = $event.target.files[0]"
              @change="getPreviewPhotoPath($event.target.files[0])"
            />

            <span class="text-xs text-gray-500">
              SVG, PNG, JPG, JPEG, WEBP or GIF (Max File size : 5 MB)
            </span>

            <InputError class="mt-2" :message="form.errors.image" />
          </div>

          <!-- Save Button -->
          <div class="mb-6">
            <SaveButton v-if="processing">
              {{ processing ? __("PROCESSING") : __("UPDATE") }}
            </SaveButton>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<style>
.ck-editor__editable_inline {
  min-height: 250px;
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

