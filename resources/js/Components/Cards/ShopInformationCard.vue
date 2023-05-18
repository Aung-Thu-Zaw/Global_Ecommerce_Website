
<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import ChatBox from "@/Components/ChatBox.vue";
import { ref } from "vue";

const props = defineProps({
  product: Object,
  conversation: Object,
});

const isVisibleChatbox = ref(false);

const handleCreateConversion = () => {
  router.post(
    route("conversation.store", {
      customer_id: usePage().props.auth.user
        ? usePage().props.auth.user.id
        : null,
      vendor_id: props.product.user_id,
    }),
    {},
    {
      replace: true,
      preserveScroll: true,
      onSuccess: () => {
        isVisibleChatbox.value = true;
      },
    }
  );
};
</script>

<template>
  <div class="border w-[450px] shadow rounded-md mt-5">
    <div
      class="font-bold text-md text-slate-600 w-full border-b px-5 py-3 mb-3"
    >
      Sold By
    </div>

    <!-- <span
                class="px-3 rounded-sm py-1 ml-5 font-bold uppercase text-[0.6rem] text-white bg-fuchsia-700"
              >
                <i class="fas fa-crown"></i>
                Official Store
              </span> -->

    <div class="flex items-center px-5 py-3">
      <img
        :src="product.shop.avatar"
        alt=""
        class="w-14 h-14 rounded-full object-cover ring-2 shadow ring-blue-300 mr-3"
      />
      <div class="flex items-start">
        <Link
          :href="route('shop.index', product.shop.id)"
          class="font-bold w-full text-md text-slate-700 hover:text-blue-600 cursor-pointer mr-1"
        >
          {{ product.shop.shop_name }}
        </Link>

        <span
          class="rounded-full flex items-center justify-center bg-green-200 text-sm text-green-600 font-bold px-3 py-1"
          >Verified
          <i
            class="fas fa-check arrow-icon ml-3 bg-green-500 p-1 rounded-full text-white"
          ></i>
        </span>
      </div>
    </div>

    <div
      class="border-t border-b h-[100px] flex items-center justify-center my-3"
    >
      <div class="p-2 w-full h-full">
        <p class="text-sm font-bold text-slate-600 text-center w-full">
          On Time Delievery
        </p>
        <p class="text-2xl text-slate-800 w-full text-center mt-4">100%</p>
      </div>
      <div class="border-l border-r p-2 w-full h-full">
        <p class="text-sm font-bold text-slate-600 text-center w-full">
          Chat Response Rate
        </p>
        <p class="text-2xl text-slate-800 w-full text-center mt-4">10%</p>
      </div>
      <div class="p-2 w-full h-full">
        <p class="text-sm font-bold text-slate-600 text-center w-full">
          Shop Rating
        </p>
        <p class="text-2xl text-slate-800 w-full text-center mt-4">50%</p>
      </div>
    </div>
    <div
      v-if="
        ($page.props.auth.user && $page.props.auth.user.id) !== product.user_id
      "
      class="flex items-center justify-between my-3 px-5 py-3"
    >
      <Link
        :href="route('shop.index', product.shop.id)"
        class="px-5 py-2 bg-blue-600 w-1/3 rounded-sm font-bold text-white text-sm hover:bg-blue-700 shadow"
      >
        <i class="fas fa-store mr-1"></i>
        Visit Shop
      </Link>
      <button
        @click="handleCreateConversion"
        class="px-5 py-2 bg-yellow-500 w-1/3 rounded-sm font-bold text-white text-sm hover:bg-yellow-700 shadow"
      >
        <i class="fas fa-message mr-1"></i>
        Chat Now
      </button>
    </div>
    <div
      v-else
      class="flex items-center justify-center text-center my-3 px-5 py-3"
    >
      <Link
        :href="route('shop.index', product.shop.id)"
        class="px-5 py-2 bg-blue-600 w-1/2 rounded-sm font-bold text-white text-sm hover:bg-blue-700 shadow"
      >
        <i class="fas fa-store mr-1"></i>
        Go To My Shop
      </Link>
    </div>
  </div>

  <div v-if="isVisibleChatbox">
    <ChatBox
      :conversation="conversation"
      @isVisible="isVisibleChatbox = false"
    />
  </div>
</template>
