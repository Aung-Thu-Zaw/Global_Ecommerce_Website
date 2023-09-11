<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

// Define the props
const props = defineProps({
  isCreateFolderFormVisibled: Boolean,
});

const emits = defineEmits(["closeForm"]);

const closeCreateForm = () => {
  closeCreateForm;
  emits("closeForm", false);
};

// Folder Create Form Data
const form = useForm({
  name: "",
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Create Chat Folder
const handleCreateFolder = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_chat_folder");

  form.post(route("admin.live-chats.folders.store"), {
    replace: true,
    preserveState: true,
    onSuccess: () => {
      closeCreateForm();
      form.name = "";
    },
  });
};
</script>

<template>
  <div
    v-if="isCreateFolderFormVisibled"
    @click.self="closeCreateForm"
    class="bg-dark bg-opacity-50 fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center"
  >
    <div
      class="border w-[500px] bg-white border-slate-300 shadow p-5 rounded-md"
    >
      <form @submit.prevent="handleCreateFolder">
        <div class="flex flex-col items-start mb-5">
          <label for="name" class="text-gray-700 text-md font-bold mb-2">
            Folder Name
          </label>
          <input
            type="text"
            class="w-full border-0 border-b-2 border-b-slate-300 focus:ring-0 focus:border-b-slate-400 text-sm"
            placeholder="Enter folder name"
            v-model="form.name"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="flex items-center justify-end space-x-3">
          <button
            type="button"
            @click="closeCreateForm"
            class="px-5 py-2 border text-sm rounded-md border-gray-300 text-slate-600 shadow-md hover:bg-gray-200 transition-all"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="px-5 py-2 border text-sm rounded-md bg-blue-600 text-white shadow-md hover:bg-blue-700 transition-all"
          >
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

