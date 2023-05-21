<script setup>
import VendorDashboardLayout from "@/Layouts/VendorDashboardLayout.vue";
import { Link, useForm, Head, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Banners/Breadcrumb.vue";
import { ref } from "vue";

const props = defineProps({
  paginate: Array,
  vendorProductBanner: Object,
});

const previewPhoto = ref("");
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

const form = useForm({
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  url: props.vendorProductBanner.url,
  image: props.vendorProductBanner.image,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditVendorProductBanner = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_product_banner");
  submit();
};

const submit = () => {
  form.post(
    route("vendor.product-banners.update", {
      vendor_product_banner: props.vendorProductBanner.id,
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
  <VendorDashboardLayout>
    <Head title="Edit Product Banner" />
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
                >Product Banners</span
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
            :href="route('vendor.product-banners.index')"
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
            class="h-[100px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300"
          />
        </div>
        <form @submit.prevent="handleEditVendorProductBanner">
          <div class="mb-6">
            <InputLabel for="url" value="URL *" />

            <TextInput
              id="url"
              type="text"
              class="mt-1 block w-full"
              v-model="form.url"
              required
              placeholder="Enter Banner URL"
            />

            <InputError class="mt-2" :message="form.errors.url" />
          </div>

          <div class="mb-6">
            <InputLabel for="image" value="Image *" />

            <input
              class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
              type="file"
              id="image"
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
  </VendorDashboardLayout>
</template>


