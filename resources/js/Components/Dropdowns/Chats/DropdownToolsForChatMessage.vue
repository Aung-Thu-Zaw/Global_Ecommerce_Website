<script setup>
import { toast } from "vue3-toastify";
import { __ } from "@/Translations/translations-inside-setup.js";
import "vue3-toastify/dist/index.css";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  message: Object,
});

const emits = defineEmits(["replyMessage"]);

const startReply = () => {
  emits("replyMessage", props.message);
};

const copyMessage = () => {
  if (navigator.clipboard) {
    const messageText = props.message.message;

    navigator.clipboard
      .writeText(messageText)
      .then(() => {
        toast.success(__("COPIED_TO_CLIPBOARD"), {
          autoClose: 2000,
        });
        console.log("Message copied to clipboard:", messageText);
      })
      .catch((error) => {
        console.error("Error copying message:", error);
      });
  } else {
    console.error("Clipboard API is not supported in this browser.");
  }
};

const handleDeleteMessageForMyself = (
  deletedByAgent = 0,
  deletedByUser = 0
) => {
  router.patch(
    route("live-chat.message.delete-for-myself", props.message.id),
    {
      is_deleted_by_user: deletedByUser,
      is_deleted_by_agent: deletedByAgent,
    },
    {
      preserveScroll: true,
    }
  );
};

const handleDeleteMessageForBoth = () => {
  router.delete(route("live-chat.message.destroy", props.message.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <div class="font-bold text-slate-500 hover:text-slate-800">
    <button
      id="messageDropdown"
      :data-dropdown-toggle="'messageDropdownDots' + message.id"
      :data-dropdown-placement="
        ($page.url.startsWith('/support-service/live-chats') &&
          message.user_id) ||
        ($page.url.startsWith('/admin/live-chats') && message.agent_id)
          ? 'left-start'
          : 'right-start'
      "
      type="button"
      class="p-2"
    >
      <svg
        class="w-4 h-4"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        viewBox="0 0 4 15"
      >
        <path
          d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
        />
      </svg>
    </button>

    <!-- Dropdown menu -->
    <div
      :id="'messageDropdownDots' + message.id"
      class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
    >
      <ul
        class="py-2 text-sm text-gray-600 font-normal"
        aria-labelledby="messageDropdown"
      >
        <li
          v-if="
            $page.props.auth.user &&
            (message.user_id === $page.props.auth.user.id ||
              message.agent_id === $page.props.auth.user.id)
          "
        >
          <div class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">
            <i class="fa-solid fa-circle-check mr-1"></i>
            {{ __("SELECT") }}
          </div>
        </li>
        <li>
          <div
            @click="startReply"
            class="block px-4 py-2 hover:bg-gray-100 cursor-pointer"
          >
            <i class="fa-solid fa-reply mr-1"></i>
            {{ __("REPLY") }}
          </div>
        </li>
        <li v-if="message.message">
          <div
            @click="copyMessage"
            class="block px-4 py-2 hover:bg-gray-100 cursor-pointer"
          >
            <i class="fa-solid fa-copy mr-1"></i>
            {{ __("COPY_TEXT") }}
          </div>
        </li>
        <li v-if="message.chat_file_attachments.length">
          <div class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">
            <i class="fa-solid fa-download mr-1"></i>
            {{ __("DOWNLOAD") }}
          </div>
        </li>
        <!-- v-if="
            $page.props.auth.user &&
            (message.user_id !== $page.props.auth.user.id ||
              message.agent_id !== $page.props.auth.user.id)
          " -->
        <li
          @click="
            handleDeleteMessageForMyself(
              $page.url.startsWith('/admin/live-chats') && !message.agent_id
                ? 1
                : 0,
              $page.url.startsWith('/support-service/live-chats') &&
                !message.user_id
                ? 1
                : 0
            )
          "
          v-if="
            ($page.props.auth.user &&
              $page.url.startsWith('/admin/live-chats') &&
              $page.props.auth.user.id !== message.agent_id) ||
            ($page.url.startsWith('/support-service/live-chats') &&
              $page.props.auth.user.id !== message.user_id)
          "
        >
          <div class="block px-4 py-2 hover:bg-gray-100 cursor-pointer">
            <i class="fa-solid fa-trash-can mr-1"></i>
            {{ __("DELETE") }}
          </div>
        </li>
        <hr
          v-if="
            $page.props.auth.user &&
            (message.user_id === $page.props.auth.user.id ||
              message.agent_id === $page.props.auth.user.id)
          "
        />
        <li
          v-if="
            $page.props.auth.user &&
            (message.user_id === $page.props.auth.user.id ||
              message.agent_id === $page.props.auth.user.id)
          "
        >
          <div
            @click="
              handleDeleteMessageForMyself(
                $page.url.startsWith('/admin/live-chats') && message.agent_id
                  ? 1
                  : 0,
                $page.url.startsWith('/support-service/live-chats') &&
                  message.user_id
                  ? 1
                  : 0
              )
            "
            class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center"
          >
            <i class="fa-solid fa-trash-can mr-1"></i>
            <span class="line-clamp-1 w-full">
              {{ __("DELETE_FOR_MYSELF") }}
            </span>
          </div>
        </li>
        <li
          v-if="
            $page.props.auth.user &&
            (message.user_id === $page.props.auth.user.id ||
              message.agent_id === $page.props.auth.user.id)
          "
        >
          <div
            @click="handleDeleteMessageForBoth"
            class="px-4 py-2 text-red-600 hover:bg-gray-100 cursor-pointer flex items-center"
          >
            <i class="fa-solid fa-trash-can mr-1"></i>
            <span class="line-clamp-1 w-full">
              {{ __("DELETE_FOR_BOTH") }}
            </span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

