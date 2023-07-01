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
        'App\\Notifications\\WebsiteSuggestion\\NewSuggestionNotification' &&
      notification.data.suggestion.type === 'report_bug'
    "
    href="#"
    class="flex px-4 py-3 hover:bg-gray-100"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-amber-300 text-amber-700 ring-2 ring-amber-400 w-10 h-10 rounded-full flex items-center justify-center p-3 font-bold"
    >
      <i
        class="fa-solid fa-bug"
        :class="{
          'animate-pulse': !notification.read_at,
        }"
      ></i>
    </div>

    <div class="w-full pl-3">
      <div
        class="text-sm mb-1.5"
        :class="{
          'text-gray-700': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        {{ notification.data.message }}

        <span
          class="font-bold text-sm block"
          :class="{
            'text-slate-600': !notification.read_at,
            'text-gray-500': notification.read_at,
          }"
          >From : {{ notification.data.suggestion.email }}
        </span>
      </div>
      <div
        class="text-xs font-bold dark:text-blue-500"
        :class="{
          'text-amber-500': !notification.read_at,
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
