<script setup>
import VendorDashboardLayout from "@/Layouts/VendorDashboardLayout.vue";
import { Link, useForm, Head, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { computed, ref } from "vue";

const props = defineProps({
  paginate: Array,
  product: Object,
  brands: Object,
  categories: Object,
});

const sizes = computed(() => props.product.sizes.map((size) => size.name));

const colors = computed(() => props.product.colors.map((color) => color.name));

const form = useForm({
  name: props.product.name,
  sizes: [...sizes.value],
  colors: [...colors.value],
  description: props.product.description,
  image: props.product.image,
  multi_image: [],
  price: props.product.price,
  discount: props.product.discount,
  code: props.product.code,
  qty: props.product.qty,
  brand_id: props.product.brand_id,
  category_id: props.product.category_id,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  hot_deal: props.product.hot_deal,
  special_offer: props.product.special_offer,
  featured: props.product.featured,
  status: props.product.status,
  captcha_token: null,
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

const removeImage = (index) => {
  multiPreviewPhotos.value.splice(index, 1);

  form.multi_image = Array.from(form.multi_image);
  form.multi_image.splice(index, 1);
};

const size = ref("");
const createSize = (e) => {
  if (e.key === ",") {
    size.value = size.value.split(",").join("").toLowerCase();
    form.sizes.push(size.value);
    size.value = "";
  }
  form.sizes = [...new Set(form.sizes)];
};
const removeSize = (removeSize) => {
  form.sizes = form.sizes.filter((size) => {
    return size !== removeSize;
  });
};

const color = ref("");
const createColor = (e) => {
  if (e.key === ",") {
    color.value = color.value.split(",").join("").toLowerCase();
    form.colors.push(color.value);
    color.value = "";
  }

  form.colors = [...new Set(form.colors)];
};
const removeColor = (removeColor) => {
  form.colors = form.colors.filter((color) => {
    return color !== removeColor;
  });
};

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditCatrgory = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_product");
  submit();
};

const submit = () => {
  form.post(
    route("vendor.products.update", {
      product: props.product.slug,
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
    <Head title="Edit Product" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
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
                >Edit</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            :href="route('vendor.products.index')"
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
        <div class="">
          <!-- Edit Product Form -->
          <form @submit.prevent="handleEditCatrgory" class="">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
              <div class="py-6">
                <!-- Product Name Field -->
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

                <!-- Product Size Field -->
                <div class="mb-6">
                  <InputLabel for="size" value="Product Sizes" />

                  <TextInput
                    id="size"
                    type="text"
                    class="mt-1 block w-full mb-2"
                    v-model="size"
                    @keyup="createSize"
                    placeholder="Enter Product Sizes ( Eg. XS, S, M, L, Xl, XXL, 6 inches etc...)"
                  />

                  <InputError class="mt-2" :message="form.errors.sizes" />
                  <span
                    v-for="(size, index) in form.sizes"
                    :key="index"
                    class="bg-blue-600 text-white rounded-sm min-w-[80px] h-auto px-3 py-1 mr-2"
                  >
                    <span class="text-sm font-blod mr-5">{{ size }}</span>
                    <i
                      class="fas fa-xmark text-white arrow-icon cursor-pointer"
                      @click="removeSize(size)"
                    ></i>
                  </span>
                </div>

                <!-- Product Color Field -->
                <div class="mb-6">
                  <InputLabel for="color" value="Product Colors *" />

                  <TextInput
                    id="color"
                    type="text"
                    class="mt-1 block w-full mb-2"
                    v-model="color"
                    @keyup="createColor"
                    placeholder="Enter Product Colors ( Eg. White, Red, Gray, Blue, etc...)"
                  />

                  <InputError class="mt-2" :message="form.errors.colors" />

                  <span
                    v-for="(color, index) in form.colors"
                    :key="index"
                    class="bg-blue-600 text-white rounded-sm min-w-[80px] h-auto px-3 py-1 mr-2"
                  >
                    <span class="text-sm font-blod mr-5">{{ color }}</span>
                    <i
                      class="fas fa-xmark text-white arrow-icon cursor-pointer"
                      @click="removeColor(color)"
                    ></i>
                  </span>
                </div>

                <!-- Product Description Field -->
                <div class="mb-6">
                  <InputLabel for="description" value="Product Description *" />

                  <ckeditor
                    :editor="editor"
                    v-model="form.description"
                  ></ckeditor>

                  <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <!-- Product Status Field -->
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

                <!-- Product Single Image Field -->
                <div class="mb-6">
                  <InputLabel for="image" value="Product Image ( Main ) *" />

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

                <!-- Product Multi Image Field -->
                <div class="mb-6">
                  <InputLabel
                    for="image"
                    value="Product Image ( Optional ) (You can choose multiple image press ctl+click )"
                  />

                  <input
                    class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                    type="file"
                    id="multiImage"
                    multiple
                    @input="form.multi_image = $event.target.files"
                    @change="handleMultiplePhotoChange($event.target.files)"
                  />

                  <span class="text-xs text-gray-500">
                    SVG, PNG, JPG, JPEG, WEBP or GIF (MAX. 800x400px)
                  </span>

                  <InputError class="mt-2" :message="form.errors.multi_image" />
                </div>
              </div>

              <div class="flex flex-col-reverse lg:flex-col">
                <div class="border shadow-md p-6 rounded-md mb-5 h-[550px]">
                  <div class="grid grid-cols-2 gap-3">
                    <!-- Product Price Field -->
                    <div class="mb-6">
                      <InputLabel for="price" value="Product Price *" />

                      <TextInput
                        id="price"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.price"
                        required
                        placeholder="Enter Product Price"
                      >
                        <template v-slot:icon>
                          <span class="text-slate-500"> $ </span>
                        </template>
                      </TextInput>

                      <InputError class="mt-2" :message="form.errors.price" />
                    </div>

                    <!-- Product Discount Price Field -->
                    <div class="mb-6">
                      <InputLabel for="discount" value="Discount Price" />

                      <TextInput
                        id="discount"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.discount"
                        placeholder="Enter Product Discount"
                      >
                        <template v-slot:icon>
                          <span class="text-slate-500"> $ </span>
                        </template>
                      </TextInput>

                      <InputError
                        class="mt-2"
                        :message="form.errors.discount"
                      />
                    </div>
                  </div>
                  <div class="grid grid-cols-2 gap-3">
                    <!-- Product Code Field -->
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

                    <!-- Product Quantity Field -->
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

                  <!-- Product Brand Field -->
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

                  <!-- Product Category Field -->
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
                        :selected="category.id === form.category_id"
                      >
                        {{ category.name }}
                      </option>
                    </select>

                    <InputError
                      class="mt-2"
                      :message="form.errors.category_id"
                    />
                  </div>

                  <div class="grid grid-cols-3 gap-3">
                    <!-- Product Hot Deal Checkbox Field -->
                    <div
                      class="flex items-center pl-4 border border-gray-200 rounded-md dark:border-gray-700 mb-6"
                    >
                      <input
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

                    <!-- Product Special Offer Checkbox Field -->
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
                    <!-- Product Featured Checkbox Field -->
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

                <!-- Product Image Preview Field -->
                <div
                  class="mb-5 flex flex-col items-start flex-wrap border shadow-md p-5 rounded-md h-auto"
                >
                  <div class="mb-4">
                    <span class="text-slate-500 text-sm font-bold"
                      >Main Image</span
                    >

                    <img
                      ref="previewPhoto"
                      :src="form.image"
                      alt=""
                      class="h-[120px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300 mx-2"
                    />
                  </div>

                  <div v-if="multiPreviewPhotos.length" class="mb-4">
                    <span class="text-slate-500 text-sm font-bold"
                      >New Multiple Image</span
                    >
                    <div class="flex flex-wrap">
                      <div
                        class="relative"
                        v-for="(multiPreviewPhoto, index) in multiPreviewPhotos"
                        :key="index"
                      >
                        <img
                          :src="multiPreviewPhoto"
                          alt=""
                          class="h-[120px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300 mr-6"
                        />
                        <span
                          class="absolute top-0 right-4 bg-slate-300 text-slate-600 w-5 h-5 flex items-center justify-center rounded-full hover:bg-slate-500 hover:text-slate-300 transition-all"
                          @click="removeImage(index)"
                        >
                          <i class="fas fa-xmark text-sm"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <!-- {{ props.product.images }} -->
                  <div v-if="props.product.images" class="mb-4">
                    <span class="text-slate-500 text-sm font-bold"
                      >Exisiting Multiple Image</span
                    >
                    <div class="flex flex-wrap">
                      <div
                        v-for="image in props.product.images"
                        :key="image.id"
                        class="flex flex-col items-center justify-center"
                      >
                        <img
                          :src="image.img_path"
                          alt=""
                          class="h-[120px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300 mx-2"
                        />

                        <Link
                          :href="
                            route('vendor.image.destroy', {
                              product_id: props.product.id,
                              image_id: image.id,
                            })
                          "
                          method="delete"
                          as="button"
                          class="bg-red-600 rounded-md px-10 py-2 text-sm text-white hover:bg-red-800 transition-all"
                        >
                          Delete
                        </Link>
                      </div>
                    </div>
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
  </VendorDashboardLayout>
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
