<script setup>
import FolderCreateForm from "@/Components/Forms/Chats/FolderCreateForm.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
  folders: Object,
});

const emits = defineEmits(["selectedFolder"]);

const isCreateFolderFormVisibled = ref(false);

const selectedFolder = ref(null);

const handleFolderSelect = (folder) => {
  selectedFolder.value = folder;
  emits("selectedFolder", folder);
};
</script>

<template>
  <div
    class="border-r border-gray-300 shadow bg-gray-50 w-[70px] h-[815px] flex flex-col p-2 text-xs items-center space-y-5 overflow-auto scrollbar"
  >
    <Link
      :href="route('admin.live-chats.index')"
      :data="{
        tab: 'all-chats',
      }"
      data-tooltip-target="chat-tooltip"
      data-tooltip-placement="right"
      class="flex items-center justify-center borer ring-2 ring-green-300 min-w-[40px] min-h-[40px] rounded-sm bg-green-600 text-white hover:bg-green-700"
    >
      <i class="fa-solid fa-home"></i>

      <div
        id="chat-tooltip"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
      >
        {{ __("ALL_CHATS") }}

        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </Link>
    <div
      data-tooltip-target="trash-tooltip"
      data-tooltip-placement="right"
      class="flex items-center justify-center borer ring-2 ring-red-300 min-w-[40px] min-h-[40px] rounded-sm bg-red-600 text-white hover:bg-red-700"
    >
      <i class="fa-solid fa-trash-can"></i>

      <div
        id="trash-tooltip"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
      >
        {{ __("TRASH") }}
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>
    <div
      data-tooltip-target="setting-tooltip"
      data-tooltip-placement="right"
      class="flex items-center justify-center borer ring-2 ring-neutral-300 min-w-[40px] min-h-[40px] rounded-sm bg-neutral-600 text-white hover:bg-neutral-700"
    >
      <i class="fa-solid fa-gear"></i>

      <div
        id="setting-tooltip"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
      >
        {{ __("SETTING") }}
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>
    <div
      data-tooltip-target="bookmark-tooltip"
      data-tooltip-placement="right"
      class="flex items-center justify-center borer ring-2 ring-primary-300 min-w-[40px] min-h-[40px] rounded-sm bg-primary-600 text-white hover:bg-primary-700"
    >
      <i class="fa-solid fa-bookmark"></i>
      <div
        id="bookmark-tooltip"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
      >
        {{ __("BOOKMARK") }}
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>
    <div
      data-tooltip-target="bookmark-tooltip"
      data-tooltip-placement="right"
      class="flex items-center justify-center borer ring-2 ring-warning-300 min-w-[40px] min-h-[40px] rounded-sm bg-warning-600 text-white hover:bg-warning-700"
    >
      <i class="fa-solid fa-archive"></i>
      <div
        id="bookmark-tooltip"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
      >
        {{ __("ARCHIVE") }}
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>

    <div
      @click="isCreateFolderFormVisibled = true"
      data-tooltip-target="create-folder-tooltip"
      data-tooltip-placement="right"
      class="flex items-center justify-center borer bg-blue-600 ring-2 ring-blue-300 text-white min-w-[40px] min-h-[40px] rounded-sm hover:bg-blue-700"
    >
      <i class="fa-solid fa-folder-plus"></i>
      <div
        id="create-folder-tooltip"
        role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
      >
        {{ __("CREATE_NEW_FOLDER") }}
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>

    <span
      v-if="folders.length"
      class="font-bold text-slate-600 pt-3 border-t border-slate-300 flex flex-col items-center justify-center"
    >
      <span> Chat </span>
      <span>
        {{ __("FOLDERS") }}
      </span>
    </span>

    <div
      v-for="folder in folders"
      :key="folder.id"
      :data-tooltip-target="'folder-tooltip' + folder.id"
      data-tooltip-placement="right"
    >
      <div
        @click="handleFolderSelect(folder)"
        class="flex items-center justify-center borer ring-2 ring-gray-300 text-white min-w-[40px] min-h-[40px] rounded-sm hover:bg-gray-600 cursor-pointer"
        :class="{
          'bg-gray-700': selectedFolder && selectedFolder.id === folder.id,
          'bg-gray-500': !selectedFolder || selectedFolder.id !== folder.id,
        }"
      >
        <i class="fa-solid fa-folder"></i>
        <div
          :id="'folder-tooltip' + folder.id"
          role="tooltip"
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border capitalize"
        >
          {{ folder.name }}
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
    </div>
  </div>

  <FolderCreateForm
    :isCreateFolderFormVisibled="isCreateFolderFormVisibled"
    @closeForm="isCreateFolderFormVisibled = false"
  />
</template>
