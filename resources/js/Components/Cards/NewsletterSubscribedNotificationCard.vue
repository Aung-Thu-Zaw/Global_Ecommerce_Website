<script setup>
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { computed } from "vue";

dayjs.extend(relativeTime);

const props = defineProps({
  notification: Object,
});

const formattedTime = computed(() =>
  props.notification.created_at
    ? dayjs(props.notification.created_at).fromNow()
    : ""
);
</script>

<template>
  <Link
    v-if="
      notification.type ===
      'App\\Notifications\\SubscribedNewsletter\\NewsletterSubscribedNotification'
    "
    href="#"
    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-emerald-300 text-emerald-700 ring-2 ring-emerald-400 w-10 h-10 rounded-full flex items-center justify-center p-3 font-bold"
    >
      <i class="fa-solid fa-envelope-circle-check"></i>
    </div>
    <div class="w-full pl-3">
      <div
        class="text-sm mb-1.5"
        :class="{
          'text-emerald-600': !notification.read_at,
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
          >Subscribe Mail : {{ notification.data.subscriber.email }}</span
        >
      </div>
      <div
        class="text-xs font-bold dark:text-blue-500"
        :class="{
          'text-gray-500': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        <i
          v-if="!notification.read_at"
          class="fa-solid fa-circle animate-pulse text-[.6rem]"
        ></i>
        {{ formattedTime }}
      </div>
    </div>
  </Link>
</template>
