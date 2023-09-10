<script setup>
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
  liveChat: Object,
});

const handlePinnedChatConversation = () => {
  router.patch(route("admin.live-chats.pinned", props.liveChat.id), {
    pinned: props.liveChat.pinned === 1 ? 0 : 1,
  });
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
          <div class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-box-archive mr-1"></i>
            {{ __("ARCHIVE") }}
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
        <li>
          <div class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-folder-plus mr-1"></i>
            {{ __("ADD_TO_FOLDER") }}
          </div>
        </li>

        <li>
          <div class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-trash-can mr-1"></i>
            {{ __("DELETE_CHAT") }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

