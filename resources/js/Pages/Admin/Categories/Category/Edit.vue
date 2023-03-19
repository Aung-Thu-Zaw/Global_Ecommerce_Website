<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Categories/Breadcrumb.vue";
import { ref } from "vue";

const props = defineProps({
  paginate: Array,
  category: Object,
});

const previewPhoto = ref("");
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

const form = useForm({
  name: props.category.name,
  slug: props.category.slug,
  status: props.category.status,
  image: props.category.image,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditCatrgory = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_category");
  submit();
};

const submit = () => {
  form.post(
    route("admin.categories.update", {
      category: props.category.id,
      page: props.paginate.page,
      per_page: props.paginate.per_page,
    }),
    {
      onFinish: () => form.reset(),
    }
  );
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Edit Category" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Breadcrumb start -->

      <div class="flex items-center justify-between mb-10">
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
                >Category</span
              >
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
                >Edit</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            :href="route('admin.categories.index')"
            :data="{
              page: props.paginate.page,
              per_page: props.paginate.per_page,
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <div class="mb-6">
          <img
            ref="previewPhoto"
            :src="form.image"
            alt=""
            class="w-[100px] h-[100px] object-cover rounded-full shadow-md my-3 ring-2 ring-slate-300"
          />
        </div>
        <form @submit.prevent="handleEditCatrgory">
          <div class="mb-6">
            <InputLabel for="name" value="Category Name *" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              placeholder="Enter Category Name"
            />

            <InputError class="mt-2" :message="form.errors.name" />
          </div>
          <div class="mb-6">
            <InputLabel for="slug" value="Category Slug *" />

            <TextInput
              id="slug"
              type="text"
              class="mt-1 block w-full"
              v-model="form.slug"
              required
              placeholder="Enter Category Slug"
            />

            <InputError class="mt-2" :message="form.errors.slug" />
          </div>

          <div class="mb-6">
            <InputLabel for="status" value="Status *" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.status"
            >
              <option value="" selected disabled>Select Status</option>
              <option value="show">Show</option>
              <option value="hide">Hide</option>
            </select>

            <InputError class="mt-2" :message="form.errors.status" />
          </div>

          <div class="mb-6">
            <InputLabel for="image" value="Image *" />

            <input
              class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
              type="file"
              id="avatar"
              @input="form.image = $event.target.files[0]"
              @change="getPreviewPhotoPath($event.target.files[0])"
            />

            <span class="text-xs text-gray-500">
              SVG, PNG, JPG, JPEG, WEBP or GIF (MAX. 800x400px)
            </span>

            <InputError class="mt-2" :message="form.errors.image" />
          </div>

          <div class="mb-6">
            <FormButton>Update</FormButton>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


