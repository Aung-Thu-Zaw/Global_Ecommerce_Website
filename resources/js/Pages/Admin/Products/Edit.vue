<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { Link, useForm, Head, router } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  product: Object,
  brands: Object,
  categories: Object,
  collections: Object,
  vendors: Object,
});

// Define Variables
const processing = ref(false);
const editor = ClassicEditor;
const size = ref("");
const color = ref("");
const previewPhoto = ref("");
const multiPreviewPhotos = ref([]);

const sizes = computed(() => props.product.sizes.map((size) => size.name));
const colors = computed(() => props.product.colors.map((color) => color.name));

// Product Edit Form Data
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
  collection_id: props.product.collection_id,
  user_id: props.product.user_id,
  status: props.product.status,
  hot_deal: props.product.hot_deal,
  special_offer: props.product.special_offer,
  featured: props.product.featured,
  captcha_token: null,
});

// Handle Preview Image
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

// Handle Multi Preview Image
const getMultiPreviewPhotoPath = (paths) => {
  paths.forEach((path) => {
    multiPreviewPhotos.value.push(URL.createObjectURL(path));
  });
};

const handleMultiplePhotoChange = (files) => {
  const paths = Array.from(files);
  getMultiPreviewPhotoPath(paths);
};

// Handle Remove Preview Image
const removeImage = (index) => {
  multiPreviewPhotos.value.splice(index, 1);

  form.multi_image = Array.from(form.multi_image);
  form.multi_image.splice(index, 1);
};

// Handle Size Tags
const createSize = (e) => {
  if (e.key === ",") {
    size.value = size.value.split(",").join("").toLowerCase();
    form.sizes.push(size.value);
    size.value = "";
  }
  form.sizes = [...new Set(form.sizes)];
};

// Handle Remove Size
const removeSize = (removeSize) => {
  form.sizes = form.sizes.filter((size) => {
    return size !== removeSize;
  });
};

// Handle Color Tags
const createColor = (e) => {
  if (e.key === ",") {
    color.value = color.value.split(",").join("").toLowerCase();
    form.colors.push(color.value);
    color.value = "";
  }

  form.colors = [...new Set(form.colors)];
};

// Handle Remove Color
const removeColor = (removeColor) => {
  form.colors = form.colors.filter((color) => {
    return color !== removeColor;
  });
};

// Handle Delete Product Multi Image
const handleDeleteProductMultiImage = (imageId) => {
  router.delete(
    route("admin.image.destroy", {
      product_id: props.product.id,
      image_id: imageId,
    }),
    {
      preserveScroll: true,
    }
  );
};

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Brand
const handleEditProduct = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_product");

  processing.value = true;

  form.post(
    route("admin.products.update", {
      product: props.product.slug,
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
    <Head title="Edit Product" />
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
                >{{ product.name }}</span
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

        <!-- Go Back Button -->
        <div>
          <Link
            :href="route('admin.products.index')"
            :data="{
              page: queryStringParams.page,
              per_page: queryStringParams.per_page,
              sort: queryStringParams.sort,
              direction: queryStringParams.direction,
            }"
            class="goback-btn"
          >
            <span>
              <i class="fa-solid fa-circle-left"></i>
              Go Back
            </span>
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <div class="">
          <!-- Edit Product Form -->
          <form @submit.prevent="handleEditProduct" class="">
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

                <!-- Product Single Image Field -->
                <div class="mb-6">
                  <InputLabel for="image" value="Product Image ( Main ) *" />

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

                <!-- Product Multi Image Field -->
                <div class="mb-6">
                  <InputLabel
                    for="image"
                    value="Product Image ( Optional ) (You can choose multiple image press ctl+click )"
                  />

                  <input
                    class="file-input"
                    type="file"
                    id="multiImage"
                    multiple
                    @input="form.multi_image = $event.target.files"
                    @change="handleMultiplePhotoChange($event.target.files)"
                  />

                  <span class="text-xs text-gray-500">
                    SVG, PNG, JPG, JPEG, WEBP or GIF (Max File size : 5 MB)
                  </span>

                  <InputError class="mt-2" :message="form.errors.multi_image" />
                </div>
              </div>

              <div class="flex flex-col-reverse lg:flex-col">
                <div
                  class="border shadow-md p-6 rounded-md mb-5 min-h-[730px] h-auto"
                >
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

                  <!-- Product Collection Field -->
                  <div class="mb-6">
                    <InputLabel for="collection" value="Collection" />

                    <select
                      v-model="form.collection_id"
                      class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    >
                      <option value="" selected disabled>
                        Select collection
                      </option>
                      <option
                        v-for="collection in collections"
                        :key="collection.id"
                        :value="collection.id"
                        :selected="collection.id === form.collection_id"
                      >
                        {{ collection.title }}
                      </option>
                    </select>

                    <InputError
                      class="mt-2"
                      :message="form.errors.collection_id"
                    />
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

                  <!-- Product Vendor Field -->
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
                    <!-- Product Hot Deal Checkbox Field -->
                    <div
                      class="flex items-center pl-4 border border-gray-200 rounded-md dark:border-gray-700 mb-6"
                    >
                      <input
                        id="bordered-checkbox-2"
                        type="checkbox"
                        name="bordered-checkbox"
                        v-model="form.hot_deal"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
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
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
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
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
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
                  <div v-if="props.product.images.length" class="mb-4">
                    <span class="text-slate-500 text-sm font-bold"
                      >Exisiting Multiple Image</span
                    >
                    <div class="flex flex-wrap space-x-3">
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

                        <button
                          @click="handleDeleteProductMultiImage(image.id)"
                          type="button"
                          class="bg-red-600 rounded-md px-10 py-2 text-sm text-white hover:bg-red-800 transition-all"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Edit Button -->
            <div class="mb-6">
              <button class="save-btn">
                <svg
                  v-if="processing"
                  aria-hidden="true"
                  role="status"
                  class="inline w-4 h-4 mr-3 text-white animate-spin"
                  viewBox="0 0 100 101"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="#E5E7EB"
                  />
                  <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentColor"
                  />
                </svg>
                {{ processing ? "Processing..." : "Update" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


<style>
.ck-editor__editable_inline {
  min-height: 400px;
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
