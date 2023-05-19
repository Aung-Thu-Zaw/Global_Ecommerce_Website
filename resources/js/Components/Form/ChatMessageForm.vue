<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, onBeforeMount, ref, watch } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  conversation: Object,
});

// Handle Mulit Preview Photo
const multiPreviewFiles = ref([]);
const getMultiPreviewPhotoPath = (paths) => {
  paths.forEach((path) => {
    multiPreviewFiles.value.push(URL.createObjectURL(path));
  });
};

const handleMultiplePhotoChange = (files) => {
  const paths = Array.from(files);
  getMultiPreviewPhotoPath(paths);
};

// Handle Multipreview Photo Remove
const removeImage = (index) => {
  multiPreviewFiles.value.splice(index, 1);

  form.files = Array.from(form.files);
  form.files.splice(index, 1);
};

const isImage = (file) => {
  return file.type.includes("image");
};

const isVideo = (file) => {
  return file.type.includes("video");
};

const handleClose = () => {
  multiPreviewFiles.value = [];
};

const imgIndex = ref(null);

const getIndex = (index) => {
  imgIndex.value = index;
};

const isDisabled = computed(() => (form.files.length ? true : false));

watch(
  () => props.conversation,
  () => {
    form.conversation_id = props.conversation.id;
  }
);

const form = useForm({
  conversation_id: props.conversation.id,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  message: "",
  files: [],
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleCreateMessage = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_message");
  submit();
};

const submit = () => {
  form.post(route("message.store"), {
    onFinish: () => {
      form.message = "";
      multiPreviewFiles.value = [];
    },
  });
};
</script>

<template>
  <div
    v-if="multiPreviewFiles.length"
    class="border-2 border-slate-400 absolute z-30 top-20 right-24 w-[400px] bg-white shadow-xl rounded-md p-5 pt-0"
  >
    <span
      @click="handleClose"
      class="bg-slate-300 w-5 h-5 rounded-full flex items-center justify-center hover:bg-slate-400 transition-all my-3 ml-auto"
    >
      <i class="fa-solid fa-xmark text-[.7rem]"></i>
    </span>

    <div class="h-auto max-h-[420px] overflow-auto preview-container">
      <div
        v-for="(multiPreviewFile, index) in multiPreviewFiles"
        :key="index"
        class="grid grid-cols-1 mb-4"
      >
        <div v-if="multiPreviewFile">
          <div v-if="isImage(form.files[index])" class="">
            <img :src="multiPreviewFile" alt="" class="rounded-sm border" />
            <button
              class="w-full bg-red-600 py-1 font-bold text-[.7rem] text-white rounded-sm hover:bg-red-700"
              @click="removeImage(index)"
            >
              <i class="fa-solid fa-trash"></i>
              Remove
            </button>
          </div>
          <div v-else-if="isVideo(form.files[index])" class="">
            <video :src="multiPreviewFile" controls></video>

            <button
              class="w-full bg-red-600 py-1 font-bold text-[.7rem] text-white rounded-sm hover:bg-red-700"
              @click="removeImage(index)"
            >
              <i class="fa-solid fa-trash"></i>
              Remove
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    class="w-[599px] overflow-hidden fixed bottom-0 border-t-2 border-t-slate-300 py-3 bg-slate-100"
  >
    <form
      @submit.prevent="handleCreateMessage"
      class="w-full flex items-center justify-end px-5"
    >
      <div class="mr-5">
        <label
          for="fileInput"
          class="inline-block cursor-pointer bg-slate-400 text-white hover:bg-slate-600 rounded-full px-3 py-2"
        >
          <i class="fa-solid fa-paperclip"></i>
        </label>
        <input
          id="fileInput"
          type="file"
          class="hidden"
          multiple
          @input="form.files = $event.target.files"
          @change="handleMultiplePhotoChange($event.target.files)"
        />
      </div>
      <div
        class="border-2 border-slate-400 w-[95%] flex items-center justify-between rounded-full px-4 bg-gray-50"
      >
        <input
          type="text"
          class="border-0 bg-gray-50 focus:ring-0 focus:border-0 w-full"
          v-model="form.message"
          :disabled="isDisabled"
        />
        <button
          v-if="form.message || form.files.length"
          class="px-3 py-2 text-slate-600"
        >
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </form>
  </div>
</template>

<style>
.preview-container {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.preview-container::-webkit-scrollbar {
  width: 6px;
}

.preview-container::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.preview-container::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>


