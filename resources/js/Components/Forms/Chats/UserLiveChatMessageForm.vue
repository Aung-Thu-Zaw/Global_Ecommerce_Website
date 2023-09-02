<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  liveChat: Object,
});
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

const form = useForm({
  live_chat_id: props.liveChat?.id,
  user_id: props.liveChat.user?.id,
  agent_id: props.liveChat.agent?.id,
  message: "",
  files: [],
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleCreateLiveChatMessage = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_live_chat_message");
  form.post(route("live-chat.message.store"), {
    onFinish: () => {
      form.message = "";
      multiPreviewFiles.value = [];
    },
  });
};
</script>

<template>
  <!-- Preview Image Box Message Form  -->
  <div
    v-if="multiPreviewFiles.length"
    class="fixed z-50 top-0 bottom-0 right-0 left-0 bg-dark bg-opacity-60 flex items-center justify-center"
  >
    <div
      class="border border-gray-500 w-[500px] bg-white shadow-xl rounded-md p-5 pt-0"
    >
      <span
        @click="handleClose"
        class="bg-slate-300 w-5 h-5 rounded-md flex items-center justify-center hover:bg-slate-400 transition-all mt-5 ml-auto cursor-pointer"
      >
        <i class="fa-solid fa-xmark text-[.7rem]"></i>
      </span>

      <div
        class="h-auto max-h-[420px] overflow-auto preview-container scrollbar mt-5 grid grid-cols-3 gap-1"
      >
        <div
          v-for="(multiPreviewFile, index) in multiPreviewFiles"
          :key="index"
        >
          <div v-if="multiPreviewFile">
            <div v-if="isImage(form.files[index])">
              <div class="relative">
                <img
                  :src="multiPreviewFile"
                  class="w-48 h-48 border object-cover rounded-md shadow"
                />
                <span
                  @click="removeImage(index)"
                  class="absolute top-3 right-3 text-xs bg-dark bg-opacity-50 w-6 h-6 rounded-sm p-2 flex items-center justify-center text-white cursor-pointer hover:bg-opacity-80"
                >
                  <i class="fa-solid fa-trash"></i>
                </span>
              </div>
            </div>
            <div v-else-if="isVideo(form.files[index])">
              <div class="relative">
                <video
                  :src="multiPreviewFile"
                  controls
                  class="w-48 h-48 border object-cover rounded-md shadow"
                ></video>
                <span
                  @click="removeImage(index)"
                  class="absolute top-3 right-3 text-xs bg-dark bg-opacity-50 w-6 h-6 rounded-sm p-2 flex items-center justify-center text-white cursor-pointer hover:bg-opacity-80"
                >
                  <i class="fa-solid fa-trash"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <h5 class="text-sm font-bold text-slate-600 my-5">
        {{ multiPreviewFiles.length }} {{ __("FILE_SELECTED") }}
      </h5>

      <div class="flex items-center space-x-3">
        <form @submit.prevent="handleCreateLiveChatMessage" class="w-full">
          <div class="flex items-center">
            <div class="text-gray-600 hover:text-gray-700 cursor-pointer">
              <i class="fa-solid fa-face-smile"></i>
            </div>
            <input
              type="text"
              class="bg-transparent border-0 w-full ring-0 focus:ring-0 text-sm text-slate-700 py-2.5 border-b-2 focus:border-b-2 border-b-slate-300 hover:border-b-slate-300 focus:border-0"
              :placeholder="__('TYPE_A_MESSAGE')"
              v-model="form.message"
            />
          </div>

          <div class="flex items-center space-x-2 mt-5 mb-3">
            <label for="input-file">
              <div
                class="bg-yellow-500 text-sm rounded-sm px-3 py-[15px] font-semibold text-white w-[50px] hover:bg-yellow-600 cursor-pointer flex items-center justify-center"
              >
                <i class="fa-solid fa-paperclip"></i>
              </div>
              <input
                id="input-file"
                type="file"
                class="hidden"
                multiple
                @input="form.files = $event.target.files"
                @change="handleMultiplePhotoChange($event.target.files)"
              />
            </label>
            <button
              class="bg-blue-600 text-sm rounded-sm p-3 font-semibold text-white w-full hover:bg-blue-700"
            >
              <i class="fa-solid fa-paper-plane"></i>
              {{ __("SEND") }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer Message Form -->
  <div class="relative z-40 w-full bg-white border-t shadow px-5 py-3">
    <form
      @submit.prevent="handleCreateLiveChatMessage"
      class="w-full flex items-center justify-between py-0.5 px-5 pr-10 space-x-3 bg-slate-100 rounded-full"
    >
      <div class="flex items-center space-x-4">
        <div
          data-tooltip-target="emoji-tooltip"
          class="text-gray-600 cursor-pointer"
        >
          <i class="fa-solid fa-face-smile"></i>
        </div>

        <div
          id="emoji-tooltip"
          role="tooltip"
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
        >
          {{ __("EMOJI") }}
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>

        <div class="flex items-center justify-center w-full">
          <label for="input-file">
            <div
              data-tooltip-target="file-tooltip"
              class="text-gray-600 hover:text-gray-700 cursor-pointer"
            >
              <i class="fa-solid fa-paperclip"></i>
            </div>
            <input
              id="input-file"
              type="file"
              class="hidden"
              multiple
              @input="form.files = $event.target.files"
              @change="handleMultiplePhotoChange($event.target.files)"
            />
          </label>

          <div
            id="file-tooltip"
            role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
          >
            {{ __("IMAGE") }} / {{ __("VIDEO") }} / {{ __("FILE") }}
            <div class="tooltip-arrow" data-popper-arrow></div>
          </div>
        </div>
      </div>
      <div class="w-full">
        <input
          type="text"
          class="bg-transparent w-full border-0 focus:ring-0 text-sm text-slate-700 py-2.5"
          :placeholder="__('TYPE_A_MESSAGE')"
          v-model="form.message"
        />
      </div>
      <div>
        <button
          class="text-gray-400"
          :class="{
            'text-gray-700': form.message.length > 0,
            'text-gray-400': !form.message.length,
          }"
          :disabled="!form.message.length"
        >
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </form>
  </div>
</template>


