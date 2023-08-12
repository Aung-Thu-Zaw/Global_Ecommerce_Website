<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogCategoryBreadcrumb.vue";
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
  blogCategory: Object,
});

// Define Variables
const processing = ref(false);
const previewPhoto = ref("");

// Handle Preview Image
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

// Blog Category Edit Form Data
const form = useForm({
  name: props.blogCategory?.name,
  status: props.blogCategory?.status,
  image: props.blogCategory?.image,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Blog Category
const handleEditBlogCatrgory = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_blog_category");

  processing.value = true;
  form.post(
    route("admin.blogs.categories.update", {
      blog_category: props.blogCategory.slug,
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
    <Head :title="__('EDIT_BLOG_CATEGORY')" />
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
                >{{ blogCategory.name }}
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
            :href="route('admin.blogs.categories.index')"
            :data="{
              page: props.queryStringParams.page,
              per_page: props.queryStringParams.per_page,
              sort: props.queryStringParams.sort,
              direction: props.queryStringParams.direction,
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

        <form @submit.prevent="handleEditBlogCatrgory">
          <!-- Blog Category Name Input -->
          <div class="mb-6">
            <InputLabel for="name" :value="__('BLOG_CATEGORY_NAME') + ' *'" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              :placeholder="__('ENTER_CATEGORY_NAME')"
            />

            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Status Select Box -->
          <div class="mb-6">
            <InputLabel for="status" :value="__('STATUS') + ' *'" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.status"
            >
              <option value="" selected disabled>
                {{ __("SELECT_STATUS") }}
              </option>
              <option value="show" :selected="form.status === 'show'">
                Show
              </option>
              <option value="hide" :selected="form.status === 'hide'">
                Hide
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.status" />
          </div>

          <!-- Blog Category File Input -->
          <div class="mb-6">
            <InputLabel for="image" :value="__('IMAGE')" />

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
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


