<script setup>
import SellerDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { usePage, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref } from "vue";

// Define the props
const props = defineProps({
  per_page: String,
  brands: Object,
  categories: Object,
  collections: Object,
  sellers: Object,
});

// Define Variables
const editor = ClassicEditor;
const processing = ref(false);
const previewPhoto = ref("");
const size = ref("");
const color = ref("");
const type = ref("");
const multiPreviewPhotos = ref([]);

// Product Create Form Data
const form = useForm({
  name: "",
  sizes: [],
  colors: [],
  types: [],
  description: "",
  image: "",
  multi_image: [],
  price: "",
  discount: "",
  code: "",
  qty: "",
  brand_id: "",
  category_id: "",
  seller_id: usePage().props.auth.user?.id,
  status: "pending",
  return_policy: "",
  special_offer: false,
  featured: false,
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

// Handle Type Tags
const createType = (e) => {
  if (e.key === ",") {
    type.value = type.value.split(",").join("").toLowerCase();
    form.types.push(type.value);
    type.value = "";
  }

  form.types = [...new Set(form.types)];
};

// Handle Remove Type
const removeType = (removeType) => {
  form.types = form.types.filter((type) => {
    return type !== removeType;
  });
};

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Create Product
const handleCreateProduct = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_product");

  processing.value = true;

  form.post(
    route("seller.products.store", {
      page: 1,
      per_page: props.per_page,
      sort: "id",
      direction: "desc",
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
  <SellerDashboardLayout>
    <Head :title="__('CREATE_PRODUCT')" />

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
                {{ __("CREATE") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <div>
          <GoBackButton
            href="seller.products.index"
            :queryStringParams="{
              page: 1,
              per_page: props.per_page,
              sort: 'id',
              direction: 'desc',
            }"
          />
        </div>
      </div>

      <div class="border shadow-md p-10">
        <div class="">
          <form @submit.prevent="handleCreateProduct" class="">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
              <div class="py-6">
                <!-- Product Name Field -->
                <div class="mb-6">
                  <InputLabel for="name" :value="__('PRODUCT_NAME') + ' *'" />

                  <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    :placeholder="__('ENTER_PRODUCT_NAME')"
                  />

                  <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <!-- Product Size Field -->
                <div class="mb-6">
                  <InputLabel for="size" :value="__('PRODUCT_SIZES')" />

                  <TextInput
                    id="size"
                    type="text"
                    class="mt-1 block w-full mb-2"
                    v-model="size"
                    @keyup="createSize"
                    :placeholder="
                      __('ENTER_PRODUCT_SIZES') +
                      '( Eg. XS, S, M, L, Xl, XXL, 6 inches etc...)'
                    "
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
                  <InputLabel for="color" :value="__('PRODUCT_COLORS')" />

                  <TextInput
                    id="color"
                    type="text"
                    class="mt-1 block w-full mb-2"
                    v-model="color"
                    @keyup="createColor"
                    :placeholder="
                      __('ENTER_PRODUCT_COLORS') +
                      '( Eg. White, Red, Gray, Blue, etc...)'
                    "
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

                <!-- Product Type Field -->
                <div class="mb-6">
                  <InputLabel for="type" :value="__('PRODUCT_TYPES')" />

                  <TextInput
                    id="type"
                    type="text"
                    class="mt-1 block w-full mb-2"
                    v-model="type"
                    @keyup="createType"
                    :placeholder="
                      __('ENTER_PRODUCT_TYPES') +
                      '( Eg. Jeans, Leather, Material, Steel, etc...)'
                    "
                  />

                  <InputError class="mt-2" :message="form.errors.types" />

                  <span
                    v-for="(type, index) in form.types"
                    :key="index"
                    class="bg-blue-600 text-white rounded-sm min-w-[80px] h-auto px-3 py-1 mr-2"
                  >
                    <span class="text-sm font-blod mr-5">{{ type }}</span>
                    <i
                      class="fas fa-xmark text-white arrow-icon cursor-pointer"
                      @click="removeType(type)"
                    ></i>
                  </span>
                </div>

                <!-- Product Description Field -->
                <div class="mb-6">
                  <InputLabel
                    for="description"
                    :value="__('PRODUCT_DESCRIPTION') + ' *'"
                  />

                  <ckeditor
                    :editor="editor"
                    v-model="form.description"
                  ></ckeditor>

                  <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <!-- Product Single Image Field -->
                <div class="mb-6">
                  <InputLabel
                    for="image"
                    :value="
                      __('PRODUCT_IMAGE') + ' (' + __('MAIN') + ')' + ' *'
                    "
                  />

                  <input
                    class="file-input"
                    type="file"
                    id="image"
                    required
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
                    :value="
                      __('PRODUCT_IMAGE') +
                      ' (' +
                      __('OPTIONAL') +
                      ')' +
                      ' (' +
                      __('YOU_CAN_CHOOSE_MULTIPLE_IMAGE_PRESS_CLT_CLICK') +
                      ')'
                    "
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
                      <InputLabel
                        for="price"
                        :value="__('PRODUCT_PRICE') + ' *'"
                      />

                      <TextInput
                        id="price"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.price"
                        required
                        :placeholder="__('ENTER_PRODUCT_PRICE')"
                      >
                        <template v-slot:icon>
                          <span class="text-slate-500"> $ </span>
                        </template>
                      </TextInput>

                      <InputError class="mt-2" :message="form.errors.price" />
                    </div>

                    <!-- Product Discount Price Field -->
                    <div class="mb-6">
                      <InputLabel
                        for="discount"
                        :value="__('DISCOUNT_PRICE')"
                      />

                      <TextInput
                        id="discount"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.discount"
                        :placeholder="__('ENTER_PRODUCT_DISCOUNT_PRICE')"
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
                      <InputLabel
                        for="code"
                        :value="__('PRODUCT_CODE') + ' *'"
                      />

                      <TextInput
                        id="code"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.code"
                        required
                        :placeholder="__('ENTER_PRODUCT_CODE')"
                      />

                      <InputError class="mt-2" :message="form.errors.code" />
                    </div>

                    <!-- Product Quantity Field -->
                    <div class="mb-6">
                      <InputLabel
                        for="quantity"
                        :value="__('PRODUCT_QUANTITY') + ' *'"
                      />

                      <TextInput
                        id="quantity"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.qty"
                        required
                        :placeholder="__('ENTER_PRODUCT_QUANTITY')"
                      />

                      <InputError class="mt-2" :message="form.errors.qty" />
                    </div>
                  </div>

                  <!-- Product Return Policy Field -->
                  <div class="mb-6">
                    <InputLabel
                      for="return_policy"
                      :value="__('RETURN_POLICY')"
                    />

                    <select
                      v-model="form.return_policy"
                      class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    >
                      <option value="" selected disabled>
                        {{ __("SELECT_RETURN_DAYS") }}
                      </option>
                      <option value="7days">7 Days</option>
                      <option value="10days">10 Days</option>
                      <option value="14days">14 Days</option>
                    </select>

                    <InputError
                      class="mt-2"
                      :message="form.errors.return_policy"
                    />
                  </div>

                  <!-- Product Brand Field -->
                  <div class="mb-6">
                    <InputLabel for="brand" :value="__('PRODUCT_BRAND')" />

                    <select
                      v-model="form.brand_id"
                      class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    >
                      <option value="" selected disabled>
                        {{ __("SELECT_BRAND") }}
                      </option>
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
                    <InputLabel for="category" :value="__('CATEGORY') + ' *'" />

                    <select
                      v-model="form.category_id"
                      class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                    >
                      <option value="" selected disabled>
                        {{ __("SELECT_CATEGORY") }}
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

                  <div class="grid grid-cols-2 gap-3">
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
                        >{{ __("SPECIAL_OFFER") }}</label
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
                        >{{ __("FEATURED") }}</label
                      >
                    </div>
                  </div>
                </div>

                <!-- Product Image Preview Field -->
                <div
                  class="mb-5 flex flex-col items-start flex-wrap border shadow-md p-5 rounded-md h-auto"
                >
                  <div class="mb-4">
                    <span class="text-slate-500 text-sm font-bold">{{
                      __("MAIN_IMAGE")
                    }}</span>
                    <img
                      ref="previewPhoto"
                      src="https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns="
                      class="preview-img"
                    />
                  </div>
                  <div v-if="multiPreviewPhotos.length" class="mb-4">
                    <span class="text-slate-500 text-sm font-bold">{{
                      __("MULTIPLE_IMAGE")
                    }}</span>

                    <div class="flex flex-wrap space-x-3">
                      <div
                        class="relative"
                        v-for="(multiPreviewPhoto, index) in multiPreviewPhotos"
                        :key="index"
                      >
                        <img
                          :src="multiPreviewPhoto"
                          class="h-[100px] object-cover rounded-sm shadow-md my-3 border-2 border-gray-300 mr-2"
                        />
                        <span
                          class="absolute top-1 right-1 bg-slate-300 text-slate-600 w-4 h-4 flex items-center justify-center rounded-full hover:bg-slate-500 hover:text-slate-300 transition-all"
                          @click="removeImage(index)"
                        >
                          <i class="fas fa-xmark text-xs"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Save Button -->
            <div class="mb-6">
              <SaveButton :processing="processing" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </SellerDashboardLayout>
</template>
