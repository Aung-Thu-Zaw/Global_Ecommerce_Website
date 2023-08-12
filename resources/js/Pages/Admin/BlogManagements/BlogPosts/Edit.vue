<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogPostBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { usePage, Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref, computed } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  blogPost: Object,
  blogCategories: Object,
});

// Define Variables
const editor = ClassicEditor;
const processing = ref(false);
const previewPhoto = ref("");
const tag = ref("");

const tags = computed(() => props.blogPost.blog_tags.map((tag) => tag.name));

// Handle Preview Image
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

// Blog Post Edit Form Data
const form = useForm({
  blog_category_id: props.blogPost?.blog_category_id,
  author_id:
    usePage().props.auth.user && usePage().props.auth.user.role === "admin"
      ? usePage().props.auth.user.id
      : null,
  title: props.blogPost?.title,
  description: props.blogPost?.description,
  image: props.blogPost?.image,
  tags: [...tags.value],
  captcha_token: null,
});

// Handle Blog Tags
const createTag = (e) => {
  if (e.key === ",") {
    tag.value = tag.value.split(",").join("").toLowerCase();
    form.tags.push(tag.value);
    tag.value = "";
  }
  form.tags = [...new Set(form.tags)];
};

// Handle Remove Blog Tag
const removeTag = (removeTag) => {
  form.tags = form.tags.filter((tag) => {
    return tag !== removeTag;
  });
};

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Blog Post
const handleEditBlogPost = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_blog_post");

  processing.value = true;
  form.post(
    route("admin.blogs.posts.update", {
      blog_post: props.blogPost.slug,
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
    <Head :title="__('EDIT_BLOG_POST')" />
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
                >{{ blogPost.title }}
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
            :href="route('admin.blogs.posts.index')"
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

        <form @submit.prevent="handleEditBlogPost">
          <!-- Blog Post Title Input -->
          <div class="mb-6">
            <InputLabel for="title" :value="__('BLOG_POST_TITLE') + ' *'" />

            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              required
              :placeholder="__('ENTER_BLOG_POST_TITLE')"
            />

            <InputError class="mt-2" :message="form.errors.title" />
          </div>

          <!-- Blog Post Description Editor -->
          <div class="mb-6">
            <InputLabel
              for="description"
              :value="__('BLOG_POST_DESCRIPTION') + ' *'"
            />

            <ckeditor :editor="editor" v-model="form.description"></ckeditor>

            <InputError class="mt-2" :message="form.errors.description" />
          </div>

          <!-- Blog Category Select Box -->
          <div class="mb-6">
            <InputLabel
              for="blog_category"
              :value="__('BLOG_CATEGORY') + ' *'"
            />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.blog_category_id"
            >
              <option value="" selected disabled>
                {{ __("SELECT_BLOG_CATEGORY") }}
              </option>
              <option
                v-for="blogCategory in blogCategories"
                :key="blogCategory"
                :value="blogCategory.id"
                :selected="blogCategory.id === form.blog_category_id"
              >
                {{ blogCategory.name }}
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.blog_category_id" />
          </div>

          <!-- Blog Tag Field -->
          <div class="mb-6">
            <InputLabel for="tag" :value="__('BLOG_TAGS')" />

            <TextInput
              id="tag"
              type="text"
              class="mt-1 block w-full mb-2"
              v-model="tag"
              @keyup="createTag"
              :placeholder="
                __('ENTER_BLOG_TAGS') + '( Eg. Fashion, Travel, Life, etc...)'
              "
            />

            <InputError class="mt-2" :message="form.errors.tags" />
            <span
              v-for="(tag, index) in form.tags"
              :key="index"
              class="bg-blue-600 text-white rounded-sm min-w-[80px] h-auto px-3 py-1 mr-2"
            >
              <span class="text-sm font-blod mr-5">{{ tag }}</span>
              <i
                class="fas fa-xmark text-white arrow-icon cursor-pointer"
                @click="removeTag(tag)"
              ></i>
            </span>
          </div>

          <!-- Blog Post File Input -->
          <div class="mb-6">
            <InputLabel for="image" :value="__('IMAGE') + ' *'" />

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

