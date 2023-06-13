<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/en";
import { Link } from "@inertiajs/vue3";

dayjs.extend(relativeTime);
dayjs.locale("en");

defineProps({
  notification: Object,
});
</script>

<template>
  <Link
    v-if="notification.type === 'App\\Notifications\\OrderPlacedNotification'"
    :href="
      route('admin.orders.pending.show', {
        id: notification.data.order_id,
        noti_id: notification.id,
      })
    "
    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-sky-300 text-sky-700 ring-2 ring-sky-400 w-10 h-10 rounded-full flex items-center justify-center p-3 font-bold"
    >
      <i class="fa-solid fa-cart-plus"></i>
    </div>
    <div class="w-full pl-3">
      <div
        class="text-sm mb-1.5"
        :class="{
          'text-gray-600': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        {{ notification.data.message }}

        <span
          class="font-bold text-sm"
          :class="{
            'text-slate-600': !notification.read_at,
            'text-gray-500': notification.read_at,
          }"
          >Order No : {{ notification.data.order_no }}</span
        >
      </div>
      <div
        class="text-xs font-bold dark:text-sky-500"
        :class="{
          'text-sky-500': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        <i
          v-if="!notification.read_at"
          class="fa-solid fa-circle animate-pulse text-[.6rem]"
        ></i>
        {{
          notification.created_at
            ? dayjs(notification.created_at).fromNow()
            : ""
        }}
      </div>
    </div>
  </Link>
</template>
