<script setup>
import DropdownToolForChatMessage from "@/Components/Dropdowns/Chats/DropdownToolsForChatMessage.vue";
import { computed, ref } from "vue";

defineProps({
  message: Object,
});
</script>


<template>
  <div class="mb-5">
    <div class="flex items-end justify-end">
      <div class="flex items-center justify-end">
        <div class="pl-28">
          <div class="flex items-center justify-end">
            <DropdownToolForChatMessage :message="message" />

            <p
              class="p-3 bg-slate-50 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
            >
              {{ message.message }}
            </p>
          </div>
          <div
            class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-end space-x-4"
          >
            <span class="font-bold">{{ __("EDITED") }}</span>
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
      <img
        :src="message.user?.avatar"
        class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
      />
    </div>
  </div>
</template>

