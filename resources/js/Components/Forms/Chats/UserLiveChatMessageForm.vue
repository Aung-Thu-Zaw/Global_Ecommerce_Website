<script setup>
import EmojiPicker from "vue3-emoji-picker";
import "vue3-emoji-picker/css";
import { useReCaptcha } from "vue-recaptcha-v3";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";

const props = defineProps({
  liveChat: Object,
  messageToEdit: Object,
  messageToReply: Object,
});

const emits = defineEmits(["cancelEditMessage", "cancelReplyMessage"]);

const multiPreviewFiles = ref([]);
const emojiPickerVisibleForMainInput = ref(false);
const emojiPickerVisibleForPreviewFileBox = ref(false);

const cancelEditingMessage = () => {
  emits("cancelEditMessage");
};

const cancelReplyMessage = () => {
  emits("cancelReplyMessage");
};

watch(
  () => props.messageToEdit,
  (newMessageToEdit) => {
    form.message = newMessageToEdit?.message || null;
  }
);

watch(
  () => props.messageToReply,
  (newMessageToReply) => {
    form.reply_to_message_id = newMessageToReply?.id || null;
  }
);

const onSelectEmoji = (emoji) => {
  form.message += emoji.i;
};

const getMultiPreviewFilePathAndName = (files) => {
  files.forEach((file) => {
    multiPreviewFiles.value.push({
      name: file.name,
      type: file.type,
      path: URL.createObjectURL(file),
    });
  });
};

const handleMultipleFileChange = (previewFiles) => {
  const files = Array.from(previewFiles);

  getMultiPreviewFilePathAndName(files);
};

const removeFile = (fileToRemove) => {
  multiPreviewFiles.value = multiPreviewFiles.value.filter(
    (file) => file !== fileToRemove
  );

  form.files = Array.from(form.files);
  form.files = form.files.filter((file) => file.name !== fileToRemove.name);
};

const isImage = (file) => {
  return file.type.includes("image");
};

const isVideo = (file) => {
  return file.type.includes("video");
};

const isApplication = (file) => {
  return file.type.includes("application");
};

const handleClose = () => {
  multiPreviewFiles.value = [];
};

const filteredImageAndVideoMultiPreviewFiles = computed(() => {
  return multiPreviewFiles.value.filter((file) => {
    return isImage(file) || isVideo(file);
  });
});

const filteredApplicationMultiPreviewFiles = computed(() => {
  return multiPreviewFiles.value.filter((file) => {
    return isApplication(file);
  });
});

const form = useForm({
  live_chat_id: props.liveChat?.id,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  agent_id: null,
  message: props.messageToEdit?.message,
  files: [],
  reply_to_message_id: props.messageToReply ? props.messageToReply.id : null,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleCreateLiveChatMessage = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("live_chat_message");

  props.messageToEdit ? updateMessage() : storeMessage();
};

const storeMessage = () => {
  form.post(route("live-chat.message.store"), {
    onFinish: () => {
      form.message = "";
      multiPreviewFiles.value = [];
    },
    onSuccess: () => {
      cancelReplyMessage();
    },
  });
};

const updateMessage = () => {
  form.patch(route("live-chat.message.update", props.messageToEdit.id), {
    onSuccess: () => {
      cancelEditingMessage();
    },
  });
};
</script>

<template>
  <!-- Emoji Picker For Input Message Form -->
  <div
    v-if="emojiPickerVisibleForMainInput"
    class="absolute bottom-32 px-5 z-50"
  >
    <EmojiPicker :native="true" @select="onSelectEmoji" />
  </div>

  <!-- File Preview Message Form Box Start  -->
  <div
    v-if="multiPreviewFiles.length"
    class="fixed z-50 top-0 bottom-0 right-0 left-0 bg-dark bg-opacity-60 flex items-center justify-center"
  >
    <div
      class="border border-gray-500 w-[500px] bg-white shadow-xl rounded-md p-5 pt-0"
    >
      <!-- Form Close Button -->
      <button
        @click="handleClose"
        class="bg-slate-300 w-5 h-5 rounded-md flex items-center justify-center hover:bg-slate-400 transition-all mt-5 ml-auto cursor-pointer"
      >
        <i class="fa-solid fa-xmark text-[.7rem]"></i>
      </button>

      <!-- Preview Files Start -->
      <div class="max-h-[420px] overflow-auto scrollbar mt-5">
        <div class="h-auto grid grid-cols-3 gap-1 mb-5">
          <div
            v-for="(
              multiPreviewFile, index
            ) in filteredImageAndVideoMultiPreviewFiles"
            :key="index"
          >
            <div v-if="multiPreviewFile">
              <!-- Image File -->
              <div v-if="isImage(multiPreviewFile)">
                <div class="relative">
                  <img
                    :src="multiPreviewFile.path"
                    class="w-48 h-48 border object-cover rounded-md shadow"
                  />
                  <span
                    @click="removeFile(multiPreviewFile)"
                    class="absolute top-3 right-3 text-xs bg-dark bg-opacity-50 w-6 h-6 rounded-sm p-2 flex items-center justify-center text-white cursor-pointer hover:bg-opacity-80"
                  >
                    <i class="fa-solid fa-trash"></i>
                  </span>
                </div>
              </div>

              <!-- Video File -->
              <div v-else-if="isVideo(multiPreviewFile)">
                <div class="relative">
                  <video
                    :src="multiPreviewFile.path"
                    controls
                    class="w-48 h-48 border object-cover rounded-md shadow"
                  ></video>
                  <span
                    @click="removeFile(multiPreviewFile)"
                    class="absolute top-3 right-3 text-xs bg-dark bg-opacity-50 w-6 h-6 rounded-sm p-2 flex items-center justify-center text-white cursor-pointer hover:bg-opacity-80"
                  >
                    <i class="fa-solid fa-trash"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- File -->
        <div class="h-auto grid grid-cols-1 gap-1">
          <div
            v-for="(
              multiPreviewFile, index
            ) in filteredApplicationMultiPreviewFiles"
            :key="index"
          >
            <div
              v-if="isApplication(multiPreviewFile)"
              class="flex items-center justify-between"
            >
              <div class="border p-2 rounded-md flex items-center w-full">
                <div
                  class="text-gray-700 bg-gray-200 text-sm w-8 h-8 flex items-center justify-center rounded-full border mr-2 border-slate-300"
                >
                  <i class="fa-solid fa-file-zipper"></i>
                </div>

                <h4 class="font-semibold text-sm text-slate-600">
                  {{ multiPreviewFile.name }}
                </h4>
              </div>

              <div class="mx-3">
                <span
                  @click="removeFile(multiPreviewFile)"
                  class="text-xs bg-dark bg-opacity-50 w-6 h-6 rounded-sm p-2 flex items-center justify-center text-white cursor-pointer hover:bg-opacity-80"
                >
                  <i class="fa-solid fa-trash"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Preview Files End -->

      <h5 class="text-sm font-bold text-slate-600 my-5">
        {{ multiPreviewFiles.length }} {{ __("FILE_SELECTED") }}
      </h5>

      <!-- Emoji Picker For File Preview Box Message Form -->
      <div
        v-if="emojiPickerVisibleForPreviewFileBox"
        class="absolute top-[350px] z-50"
      >
        <EmojiPicker :native="true" @select="onSelectEmoji" />
      </div>

      <div class="flex items-center space-x-3">
        <form @submit.prevent="handleCreateLiveChatMessage" class="w-full">
          <div class="flex items-center">
            <!-- Emoji Icon -->
            <div
              @click="
                emojiPickerVisibleForPreviewFileBox =
                  !emojiPickerVisibleForPreviewFileBox
              "
              class="text-gray-600 hover:text-gray-700 cursor-pointer"
            >
              <i class="fa-solid fa-face-smile"></i>
            </div>

            <!-- Message Input -->
            <input
              @focus="emojiPickerVisibleForPreviewFileBox = false"
              type="text"
              class="bg-transparent border-0 w-full ring-0 focus:ring-0 text-sm text-slate-700 py-2.5 border-b-2 focus:border-b-2 border-b-slate-300 hover:border-b-slate-300 focus:border-0"
              :placeholder="__('TYPE_A_MESSAGE')"
              v-model="form.message"
            />
          </div>

          <div class="flex items-center space-x-2 mt-5 mb-3">
            <!-- File Attachment -->
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
                @change="handleMultipleFileChange($event.target.files)"
              />
            </label>

            <!-- Send Message Button -->
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
  <!-- File Preview Message Form Box End  -->

  <!-- Main Messge Send Form -->
  <div class="relative z-40 w-full bg-white border-t shadow px-5 py-3">
    <!-- Edit Mesage -->
    <div v-if="messageToEdit" class="mb-5 text-xs flex flex-col items-start">
      <div class="flex items-center font-bold text-blue-600 mb-2">
        <i class="fa-solid fa-edit mr-2"></i>
        <span>{{ __("EDIT_MESSAGE") }}</span>
      </div>
      <div class="w-full flex items-center justify-between">
        <p class="w-full pl-5 line-clamp-1">
          {{ messageToEdit?.message }}
        </p>

        <span
          @click="cancelEditingMessage"
          class="text-lg font-bold w-6 h-6 flex items-center justify-center text-slate-500 ml-3 cursor-pointer hover:text-slate-600"
        >
          <i class="fa-solid fa-xmark"></i>
        </span>
      </div>
    </div>

    <!-- Reply Mesage -->
    <div v-if="messageToReply" class="mb-5 text-xs flex flex-col items-start">
      <div class="flex items-center font-bold text-blue-600 mb-2">
        <i class="fa-solid fa-reply mr-2"></i>
        <span>{{ __("REPLY") }}</span>
      </div>
      <div class="w-full flex items-center justify-between">
        <div class="flex flex-col items-start pl-5 w-full">
          <h6 class="font-semibold text-sm text-slate-700">
            {{
              messageToReply.user
                ? messageToReply?.user?.name
                : messageToReply?.agent?.name
            }}
          </h6>
          <p class="w-full line-clamp-1">
            {{ messageToReply?.message }}
          </p>
        </div>

        <span
          @click="cancelReplyMessage"
          class="text-lg font-bold w-6 h-6 flex items-center justify-center text-slate-500 ml-3 cursor-pointer hover:text-slate-600"
        >
          <i class="fa-solid fa-xmark"></i>
        </span>
      </div>
    </div>
    <form
      @submit.prevent="handleCreateLiveChatMessage"
      class="w-full flex items-center justify-between py-0.5 px-5 pr-10 space-x-3 bg-slate-100 rounded-full"
    >
      <div class="flex items-center space-x-4">
        <!-- Emoji Icon With Tooltip Start -->
        <div
          @click="
            emojiPickerVisibleForMainInput = !emojiPickerVisibleForMainInput
          "
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
        <!-- Emoji Icon With Tooltip End -->

        <!-- Attachment Icon With Tooltip Start -->
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
              @change="handleMultipleFileChange($event.target.files)"
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
        <!-- Attachment Icon With Tooltip End -->
      </div>

      <!-- Message Input -->
      <div class="w-full">
        <input
          type="text"
          class="bg-transparent w-full border-0 focus:ring-0 text-sm text-slate-700 py-2.5"
          :placeholder="__('TYPE_A_MESSAGE')"
          @focus="emojiPickerVisibleForMainInput = false"
          v-model="form.message"
        />
      </div>

      <!-- Message Send Button -->
      <div>
        <button
          class="text-gray-400"
          :class="{
            'text-gray-700': form.message,
            'text-gray-400': !form.message,
          }"
          :disabled="!form.message"
        >
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </form>
  </div>
</template>


