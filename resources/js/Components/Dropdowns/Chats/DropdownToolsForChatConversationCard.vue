<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";

const props = defineProps({
  liveChat: Object,
  folders: Object,
});

const handlePinnedChatConversation = () => {
  router.patch(route("admin.live-chats.pinned", props.liveChat.id), {
    pinned: props.liveChat.pinned === 1 ? 0 : 1,
  });
};

const handleArchivedChatConversation = () => {
  router.patch(route("admin.live-chats.archived", props.liveChat.id), {
    archived: props.liveChat.archived === 1 ? 0 : 1,
  });
};

const handleDeleteChatForMyself = () => {
  router.patch(route("admin.live-chats.delete-for-myself", props.liveChat.id), {
    is_deleted_by_agent: 1,
    tab: usePage().props.ziggy.query?.tab,
  });
};

const handleDeleteChatForBoth = () => {
  router.delete(
    route("admin.live-chats.destroy", {
      live_chat: props.liveChat.id,
      tab: usePage().props.ziggy.query?.tab,
    })
  );
};

const handleChatWithFolder = (folderId = null) => {
  router.patch(
    route("admin.live-chats.handle-chat-with-folder", props.liveChat.id),
    {
      chat_folder_id: folderId,
    }
  );
};
</script>

<template>
  <div class="font-bold text-slate-600 hover:text-slate-800">
    <button
      id="messageDropdown"
      :data-dropdown-toggle="'messageDropdownDots' + liveChat.id"
      data-dropdown-placement="left-start"
      type="button"
      class="p-2"
    >
      <svg
        class="w-3 h-3"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 16 3"
      >
        <path
          d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
        />
      </svg>
    </button>

    <!-- Dropdown menu -->
    <div
      :id="'messageDropdownDots' + liveChat.id"
      class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
    >
      <ul
        class="py-2 text-sm text-gray-600 font-normal"
        aria-labelledby="messageDropdown"
      >
        <li>
          <div
            @click="handleArchivedChatConversation"
            class="block px-4 py-2 hover:bg-gray-100"
          >
            <i class="fa-solid fa-box-archive mr-1"></i>
            {{ liveChat.archived === 1 ? __("UNARCHIVE") : __("ARCHIVE") }}
          </div>
        </li>
        <li>
          <div
            @click="handlePinnedChatConversation"
            class="block px-4 py-2 hover:bg-gray-100"
          >
            <i class="fa-solid fa-thumbtack mr-1"></i>
            {{
              liveChat.pinned === 1 ? __("UNPIN_FROM_TOP") : __("PIN_TO_TOP")
            }}
          </div>
        </li>
        <li>
          <Link
            :href="route('admin.live-chats.show', { live_chat: liveChat.uuid })"
            :data="{
              search: $page.props.ziggy.query?.search,
              tab: $page.props.ziggy.query?.tab,
            }"
            class="block px-4 py-2 hover:bg-gray-100"
          >
            <i class="fa-solid fa-eye mr-1"></i>
            {{ __("VIEW_CHAT") }}
          </Link>
        </li>
        <li v-if="folders.length && !liveChat.chat_folder_id">
          <button
            id="doubleDropdownButton"
            :data-dropdown-toggle="'doubleDropdown' + liveChat.id"
            data-dropdown-placement="right-start"
            type="button"
            class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
          >
            <i class="fa-solid fa-folder-plus mr-1"></i>
            {{ __("ADD_TO_FOLDER") }}
            <svg
              class="w-2.5 h-2.5 ml-2.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 9 4-4-4-4"
              />
            </svg>
          </button>
          <div
            :id="'doubleDropdown' + liveChat.id"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
          >
            <ul
              class="py-2 text-xs font-medium text-gray-600 dark:text-gray-200"
              aria-labelledby="doubleDropdownButton"
            >
              <li v-for="folder in folders" :key="folder.id">
                <div
                  @click="handleChatWithFolder(folder.id)"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                >
                  <i class="fa-solid fa-folder mr-1"></i>
                  {{ folder.name }}
                </div>
              </li>
            </ul>
          </div>
        </li>
        <li v-else>
          <div
            @click="handleChatWithFolder()"
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center"
          >
            <i class="fa-solid fa-folder-minus mr-1"></i>
            <span class="line-clamp-1 w-full">
              {{ __("REMOVE_FROM_FOLDER") }}
            </span>
          </div>
        </li>

        <hr />

        <li>
          <div
            @click="handleDeleteChatForMyself"
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center"
          >
            <i class="fa-solid fa-trash-can mr-1"></i>
            <span class="line-clamp-1 w-full">
              {{ __("DELETE_CHAT_FOR_MYSELF") }}
            </span>
          </div>
        </li>

        <li>
          <div
            @click="handleDeleteChatForBoth"
            class="px-4 py-2 text-red-600 hover:bg-gray-100 cursor-pointer flex items-center"
          >
            <i class="fa-solid fa-trash-can mr-1"></i>
            <span class="line-clamp-1 w-full">
              {{ __("DELETE_CHAT_FOR_BOTH") }}
            </span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

