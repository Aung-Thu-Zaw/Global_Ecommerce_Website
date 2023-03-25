<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Products/Breadcrumb.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { computed, ref } from "vue";

const props = defineProps({
  per_page: String,
  brands: Object,
  categories: Object,
  subCategories: Object,
  vendors: Object,
});

const editor = ClassicEditor;

const previewPhoto = ref("");
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

const multiPreviewPhotos = ref([]);
const getMultiPreviewPhotoPath = (paths) => {
  paths.forEach((path) => {
    multiPreviewPhotos.value.push(URL.createObjectURL(path));
  });
};

const handleMultiplePhotoChange = (files) => {
  const paths = Array.from(files);
  getMultiPreviewPhotoPath(paths);
};

const form = useForm({
  name: "",
  tags: [],
  sizes: [],
  colors: [],
  description: "",
  image: "",
  multiImage: [],
  price: "",
  discount: "",
  code: "",
  qty: "",
  brand_id: "",
  category_id: "",
  sub_category_id: "",
  user_id: "",
  hot_deal: false,
  special_offer: false,
  featured: false,
  status: "",
  captcha_token: null,
});

// computed: {
//   filteredSubCategories() {
//     if (!this.form.category_id) {
//       // If no category is selected, return all subcategories
//       return this.subCategories;
//     }
//     // Filter subcategories based on selected category's ID
//     return this.subCategories.filter(
//       subCategory => subCategory.category_id === this.form.category_id
//     );
//   }
// }

const filterSubCategories = computed(() => {
  if (!form.category_id) {
    return props.subCategories;
  }

  return props.subCategories.filter(
    (subCategory) => subCategory.category_id === form.category_id
  );
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleCreateProduct = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_product");
  submit();
};

const submit = () => {
  form.post(
    route("admin.products.store", {
      per_page: props.per_page,
    }),
    {
      onFinish: () => form.reset(),
    }
  );
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Create Product" />
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
                >Create</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            :href="route('admin.products.index')"
            :data="{
              per_page: props.per_page,
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <div class="">
          <div class="mb-6 flex items-center flex-wrap">
            <img
              ref="previewPhoto"
              src="https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns="
              alt=""
              class="w-[100px] h-[100px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300 mr-4"
            />

            <img
              v-for="(multiPreviewPhoto, index) in multiPreviewPhotos"
              :key="index"
              :src="multiPreviewPhoto"
              alt=""
              class="w-[100px] h-[100px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300 mr-4"
            />
          </div>

          <form @submit.prevent="handleCreateProduct" class="">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
              <div class="py-6">
                <div class="mb-6">
                  <InputLabel for="name" value="Product Name *" />

                  <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    placeholder="Enter Product Name"
                  />

                  <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-6">
                  <InputLabel for="size" value="Product Sizes" />

                  <TextInput
                    id="size"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.sizes"
                    placeholder="Enter Product Sizes ( Eg. XS, S, M, L, Xl, XXL, 6 inches etc...)"
                  />

                  <InputError class="mt-2" :message="form.errors.sizes" />
                </div>
                <div class="mb-6">
                  <InputLabel for="color" value="Product Colors *" />

                  <TextInput
                    id="color"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.colors"
                    placeholder="Enter Product Colors ( Eg. White, Red, Gray, Blue, etc...)"
                  />

                  <InputError class="mt-2" :message="form.errors.colors" />
                </div>
                <div class="mb-6">
                  <InputLabel for="description" value="Product Description *" />

                  <ckeditor
                    :editor="editor"
                    v-model="form.description"
                  ></ckeditor>

                  <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="mb-6">
                  <InputLabel for="status" value="Status *" />

                  <select
                    class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    v-model="form.status"
                  >
                    <option value="" selected disabled>Select Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.status" />
                </div>

                <div class="mb-6">
                  <InputLabel for="image" value="Product Image ( Main ) *" />

                  <input
                    class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                    type="file"
                    id="image"
                    required
                    @input="form.image = $event.target.files[0]"
                    @change="getPreviewPhotoPath($event.target.files[0])"
                  />

                  <span class="text-xs text-gray-500">
                    SVG, PNG, JPG, JPEG, WEBP or GIF (MAX. 800x400px)
                  </span>

                  <InputError class="mt-2" :message="form.errors.image" />
                </div>

                <div class="mb-6">
                  <InputLabel
                    for="image"
                    value="Product Image ( Optional You can choose multiple image ctl+click ) *"
                  />

                  <input
                    class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                    type="file"
                    id="multiImage"
                    multiple
                    required
                    @input="form.multiImage = $event.target.files"
                    @change="handleMultiplePhotoChange($event.target.files)"
                  />

                  <span class="text-xs text-gray-500">
                    SVG, PNG, JPG, JPEG, WEBP or GIF (MAX. 800x400px)
                  </span>

                  <InputError class="mt-2" :message="form.errors.multiImage" />
                </div>
              </div>
              <div class="border shadow-md p-6 rounded-md mb-5 h-[630px]">
                <div class="grid grid-cols-2 gap-3">
                  <div class="mb-6">
                    <InputLabel for="price" value="Product Price *" />

                    <TextInput
                      id="price"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.price"
                      required
                      placeholder="Enter Product Price"
                    />

                    <InputError class="mt-2" :message="form.errors.price" />
                  </div>

                  <div class="mb-6">
                    <InputLabel for="discount" value="Discount Price" />

                    <TextInput
                      id="discount"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.discount"
                      required
                      placeholder="Enter Product Discount"
                    />

                    <InputError class="mt-2" :message="form.errors.discount" />
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div class="mb-6">
                    <InputLabel for="code" value="Product Code *" />

                    <TextInput
                      id="code"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.code"
                      required
                      placeholder="Enter Product Code"
                    />

                    <InputError class="mt-2" :message="form.errors.code" />
                  </div>
                  <div class="mb-6">
                    <InputLabel for="name" value="Product Quantity *" />

                    <TextInput
                      id="quantity"
                      type="text"
                      class="mt-1 block w-full"
                      v-model="form.qty"
                      required
                      placeholder="Enter Product Quantity"
                    />

                    <InputError class="mt-2" :message="form.errors.qty" />
                  </div>
                </div>
                <div class="mb-6">
                  <InputLabel for="name" value="Product Brand *" />

                  <select
                    v-model="form.brand_id"
                    class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                  >
                    <option value="" selected disabled>Select Brand</option>
                    <option
                      v-for="brand in brands"
                      :key="brand.id"
                      :value="brand.id"
                    >
                      {{ brand.name }}
                    </option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.brand_id" />
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div class="mb-6">
                    <InputLabel for="category" value="Category *" />

                    <select
                      v-model="form.category_id"
                      class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    >
                      <option value="" selected disabled>
                        Select Category
                      </option>
                      <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                      >
                        {{ category.name }}
                      </option>
                    </select>

                    <InputError
                      class="mt-2"
                      :message="form.errors.category_id"
                    />
                  </div>
                  <div class="mb-6">
                    <InputLabel for="name" value="SubCategory *" />

                    <select
                      v-model="form.sub_category_id"
                      class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    >
                      <option value="" selected disabled>
                        Select SubCategory
                      </option>
                      <option
                        v-for="subCategory in filterSubCategories"
                        :key="subCategory.id"
                        :value="subCategory.id"
                      >
                        {{ subCategory.name }}
                      </option>
                    </select>

                    <InputError
                      class="mt-2"
                      :message="form.errors.sub_category_id"
                    />
                  </div>
                </div>
                <div class="mb-6">
                  <InputLabel for="name" value="Vendor *" />

                  <select
                    v-model="form.user_id"
                    class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                  >
                    <option value="" selected disabled>Select Vendor</option>
                    <option
                      v-for="vendor in vendors"
                      :key="vendor.id"
                      :value="vendor.id"
                    >
                      {{ vendor.name }}
                    </option>
                  </select>

                  <InputError class="mt-2" :message="form.errors.user_id" />
                </div>

                <div class="grid grid-cols-3 gap-3">
                  <div
                    class="flex items-center pl-4 border border-gray-200 rounded-md dark:border-gray-700 mb-6"
                  >
                    <input
                      checked
                      id="bordered-checkbox-2"
                      type="checkbox"
                      name="bordered-checkbox"
                      v-model="form.hot_deal"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="bordered-checkbox-2"
                      class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                      >Hot Deal</label
                    >
                  </div>
                  <div
                    class="flex items-center pl-4 border border-gray-200 rounded-md dark:border-gray-700 mb-6"
                  >
                    <input
                      checked
                      id="bordered-checkbox-2"
                      type="checkbox"
                      v-model="form.special_offer"
                      name="bordered-checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="bordered-checkbox-2"
                      class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                      >Special Offer</label
                    >
                  </div>
                  <div
                    class="flex items-center pl-4 border border-gray-200 rounded-md dark:border-gray-700 mb-6"
                  >
                    <input
                      checked
                      id="bordered-checkbox-2"
                      type="checkbox"
                      v-model="form.featured"
                      name="bordered-checkbox"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                      for="bordered-checkbox-2"
                      class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                      >Featured</label
                    >
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-6">
              <FormButton>Save</FormButton>
            </div>
          </form>
        </div>
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
