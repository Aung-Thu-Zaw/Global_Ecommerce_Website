
<script setup>
import ChatMessageForm from "@/Components/Form/ChatMessageForm.vue";

defineProps({
  conversation: Object,
});
</script>
<template>
  <div
    v-if="
      $page.props.auth.user &&
      $page.props.auth.user.id !== conversation.customer_id
    "
    class="border-b-2 border-b-slate-300 shadow-md py-3 flex items-center px-3"
  >
    <img
      :src="conversation.customer.avatar"
      alt=""
      class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
    />
    <h1 class="text-left text-lg font-semibold text-slate-700">
      {{ conversation.customer.name }}
    </h1>
  </div>

  <div
    v-else-if="
      $page.props.auth.user &&
      $page.props.auth.user.id !== conversation.vendor_id
    "
    class="border-b-2 border-b-slate-300 shadow-md py-3 flex items-center px-3"
  >
    <img
      :src="conversation.vendor.avatar"
      alt=""
      class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
    />
    <h1 class="text-left text-md font-semibold text-slate-700">
      {{ conversation.vendor.shop_name }}
      <span class="text-green-500 text-sm font-bold">
        <i class="fa-solid fa-circle-check"></i>
      </span>
    </h1>
  </div>

  <div class="overflow-auto w-full h-[565px] py-5">
    <div class="w-full h-auto px-3 mb-5">
      <!-- left text  -->

      <div
        v-for="message in conversation.messages"
        :key="message.id"
        class="w-full"
      >
        <!-- Right Side  -->
        <div v-if="message.user_id === $page.props.auth.user.id" class="mb-2">
          <p class="text-center text-sm text-slate-500 font-bold mb-2">
            {{ message.created_at }}
          </p>
          <div class="flex items-end justify-end">
            <div class="flex items-center justify-end mb-3">
              <div class="pl-28">
                <p
                  class="p-3 border-2 border-slate-300 rounded-lg rounded-br-none shadow-md w-auto"
                >
                  {{ message.message }}
                </p>
              </div>
            </div>
            <img
              :src="message.user.avatar"
              alt=""
              class="w-8 h-8 object-cover rounded-full ring-2 ring-blue-400 ml-3"
            />
          </div>
        </div>

        <!-- left Side -->
        <div v-else class="mb-2">
          <div>
            <p class="text-center text-sm text-slate-500 font-bold mb-2">
              {{ message.created_at }}
            </p>
            <div class="flex items-end">
              <img
                :src="message.user.avatar"
                alt=""
                class="w-8 h-8 object-cover rounded-full ring-2 ring-blue-400 mr-3"
              />

              <div class="flex items-end justify-start mb-3 w-full">
                <div class="pr-28">
                  <p
                    class="p-3 border-2 border-slate-300 rounded-lg rounded-bl-none shadow-md w-auto"
                  >
                    {{ message.message }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <ChatMessageForm :conversation="conversation" />
</template>


