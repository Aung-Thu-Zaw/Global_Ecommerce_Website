<script setup>
import DropdownToolForChatMessage from "@/Components/Dropdowns/Chats/DropdownToolsForChatMessage.vue";
import { computed, ref } from "vue";

const props = defineProps({
  message: Object,
});

const emits = defineEmits(["editMessage", "replyMessage"]);

const editMessage = (message) => {
  emits("editMessage", message);
};

const replyMessage = (message) => {
  emits("replyMessage", message);
};
</script>


<template>
  <div class="flex items-end mb-2">
    <img
      :src="
        $page.url.startsWith('/admin/chats')
          ? message?.user?.avatar
          : message?.agent?.avatar
      "
      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
    />

    <div class="flex items-end justify-start w-full">
      <div class="pr-28">
        <div class="flex items-center justify-start">
          <div
            class="p-3 bg-gray-100 border-2 border-slate-300 rounded-xl rounded-bl-none shadow-md w-auto max-w-[500px] text-sm"
          >
            <div v-if="message.reply_to_message_id">
              <div class="flex items-center text-xs text-slate-500">
                <i class="fa-solid fa-reply mr-2"></i>

                <p class="line-clamp-1">
                  {{ message?.reply_to_message?.message }}
                </p>
              </div>
            </div>
            <p>
              {{ message.message }}
            </p>
          </div>
          <!-- Dropdown  -->
          <DropdownToolForChatMessage
            :message="message"
            @editMessage="editMessage"
            @replyMessage="replyMessage"
          />
        </div>

        <div
          class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-start space-x-4"
        >
          <span v-if="message.is_edited" class="font-bold">
            {{ __("EDITED") }}
          </span>
          <div class="flex items-center justify-end space-x-2 mr-2">
            <span class=""> {{ message.updated_at }} </span>
            <span
              v-if="message.is_read_by_user || message.is_read_by_agent"
              class="text-[.6rem] text-slate-600"
            >
              <i
                v-if="message.is_read_by_user"
                class="fa-solid fa-check text-green-500"
              ></i>
              <i
                v-if="message.is_read_by_agent"
                class="fa-solid fa-check text-green-500"
              ></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

