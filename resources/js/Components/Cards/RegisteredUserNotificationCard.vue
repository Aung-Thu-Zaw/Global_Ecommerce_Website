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
    v-if="
      notification.type ===
        'App\\Notifications\\Registered\\RegisteredUserNotification' &&
      notification.data.user &&
      notification.data.user.role === 'user'
    "
    :href="
      route('admin.users.register.show', {
        user: notification.data.user.id,
        noti_id: notification.id,
      })
    "
    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-red-300 text-red-700 ring-2 ring-red-400 w-10 h-10 rounded-full flex items-center justify-center p-3 font-bold"
    >
      <i class="fa-solid fa-user"></i>
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
          >User Email : {{ notification.data.user.email }}</span
        >
      </div>
      <div
        class="text-xs font-bold dark:text-blue-500"
        :class="{
          'text-red-500': !notification.read_at,
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
