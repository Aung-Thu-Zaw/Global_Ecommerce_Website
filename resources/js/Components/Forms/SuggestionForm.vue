<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { useReCaptcha } from "vue-recaptcha-v3";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

defineProps({
  isSuggestionFormOpened: Boolean,
});

const emits = defineEmits();

const closeForm = () => {
  emits("update:isSuggestionFormOpened", false);
};

const processing = ref(false);

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

const form = useForm({
  email: "",
  description: "",
  multi_image: [],
  type: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleSubmitRequestFeature = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("request_feature");
  processing.value = true;
  form.post(route("suggestion.store"), {
    replace: true,
    preserveState: true,
    onFinish: () => {
      processing.value = false;
      multiPreviewPhotos.value = [];
    },
    onSuccess: () => {
      form.reset();
      closeForm();
      if (usePage().props.flash.successMessage) {
        toast.success(__(usePage().props.flash.successMessage), {
          autoClose: 2000,
        });
      }
    },
  });
};
</script>

<template>
  <div
    v-if="isSuggestionFormOpened"
    @click.self="closeForm"
    class="fixed top-0 left-0 right-0 bottom-0 bg-dark bg-opacity-80 z-30 flex items-center justify-center min-h-screen"
  >
    <div
      class="w-full max-w-4xl max-h-full bg-white opacity-100 mt-32 rounded-md"
    >
      <div class="relative bg-white rounded-lg shadow">
        <button
          @click="closeForm"
          type="button"
          class="absolute top-3 right-4 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-2 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
          data-modal-hide="suggestion-modal"
        >
          <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="flex items-start justify-between">
          <div class="px-6 py-6 lg:px-8 w-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
              Write Your Suggestions
            </h3>
            <form
              @submit.prevent="handleSubmitRequestFeature"
              class="space-y-6"
            >
              <div>
                <InputLabel for="type" value="Email *" />

                <TextInput
                  id="email"
                  type="email"
                  class="mt-1 block w-full"
                  v-model="form.email"
                  required
                  placeholder="Enter Your Email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
              </div>

              <div class="mb-6">
                <InputLabel for="type" value="Suggestion Type *" />

                <select
                  class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                  v-model="form.type"
                >
                  <option value="" selected disabled>Select Suggestion</option>
                  <option value="request_feature">Request Features</option>
                  <option value="report_bug">Report Bugs</option>
                </select>

                <InputError class="mt-2" :message="form.errors.type" />
              </div>

              <div>
                <textarea
                  cols="30"
                  rows="10"
                  class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 block w-full p-2.5"
                  placeholder="We take your feedback seriously and even though we may not be able to response personally,consideration is given any submission.If you do wish give us any bugs or problem,please be sure to include any relevant informations. Eg. Order Detail or Product link"
                  v-model="form.description"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.description" />
              </div>

              <div class="mb-6">
                <InputLabel for="type" value="Add Image" />

                <input
                  class="file-input"
                  type="file"
                  id="image"
                  multiple
                  @input="form.multi_image = $event.target.files"
                  @change="handleMultiplePhotoChange($event.target.files)"
                />

                <span class="text-xs text-gray-500">
                  Support Format : PNG, JPG, JPEG (MAX FILE SIZE 2MB).
                </span>

                <InputError class="mt-2" :message="form.errors.multi_image" />
              </div>

              <button
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-3 text-center"
              >
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

                <i v-else class="fa-solid fa-paper-plane"></i>

                {{ processing ? "Processing..." : "Submit" }}
              </button>
            </form>
          </div>

          <div
            class="h-[730px] pb-6 pt-14"
            :class="{ 'w-[350px] px-6': form.multi_image.length > 0 }"
          >
            <div
              class="h-full overflow-auto scrollbar flex items-center justify-center flex-wrap"
              :class="{ 'w-[180px]': form.multi_image.length > 0 }"
            >
              <div
                v-for="(multiPreviewPhoto, index) in multiPreviewPhotos"
                :key="index"
                class="relative w-[150px]"
              >
                <img
                  :src="multiPreviewPhoto"
                  alt=""
                  class="w-full h-full object-cover rounded-sm shadow-md my-3 border-4 border-slate-300"
                />
                <span
                  @click="removeImage(index)"
                  class="absolute top-1 -right-2 bg-slate-300 text-slate-600 w-5 h-5 flex items-center justify-center rounded-full hover:bg-slate-500 hover:text-slate-300 transition-all"
                >
                  <i class="fas fa-xmark text-sm"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
