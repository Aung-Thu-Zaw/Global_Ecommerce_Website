<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { router, useForm } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

// Define the props
const props = defineProps({
  folders: Object,
  isDeleteFolderFormVisibled: Boolean,
});

const emits = defineEmits(["closeForm"]);

const closeDeleteForm = () => {
  closeDeleteForm;
  emits("closeForm", false);
};

const handleDeleteFolder = (folderId) => {
  router.delete(
    route("admin.live-chats.folders.destroy", {
      chat_folder: folderId,
    }),
    {
      onSuccess: () => {
        if (props.folders.length === 0) closeDeleteForm();
      },
    }
  );
};
</script>

<template>
  <div
    v-if="isDeleteFolderFormVisibled"
    @click.self="closeDeleteForm"
    class="bg-dark bg-opacity-50 fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center"
  >
    <div
      class="border w-[400px] bg-white border-slate-300 shadow p-5 rounded-md"
    >
      <div class="mb-5 flex items-center justify-between">
        <div>
          <h5 class="font-bold text-slate-700 text-md">
            {{ __("CHAT_FOLDERS") }}
          </h5>
        </div>
        <div
          @click="closeDeleteForm"
          class="rounded-md bg-gray-300 text-slate-600 w-6 h-6 flex items-center justify-center text-xs cursor-pointer hover:bg-gray-500 hover:text-white transition-all"
        >
          <i class="fa-solid fa-xmark"></i>
        </div>
      </div>

      <div
        class="flex flex-col items-center space-y-2 overflow-auto h-auto max-h-[800px] p-3 scrollbar"
      >
        <!-- Folder Card  -->
        <div
          v-for="folder in folders"
          :key="folder.id"
          class="flex items-center w-full space-x-5"
        >
          <div
            class="border border-slate-300 shadow p-4 rounded-md text-slate-600 text-xs font-medium w-full"
          >
            <div class="w-full flex items-center">
              <i class="fa-solid fa-folder mr-2"></i>
              <span class="">{{ folder.name }}</span>
            </div>
          </div>

          <div
            @click="handleDeleteFolder(folder.id)"
            class="text-red-600 hover:text-red-700 cursor-pointer"
          >
            <i class="fa-solid fa-trash-can"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
