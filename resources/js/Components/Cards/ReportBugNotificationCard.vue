<script setup>
import { Link, router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { computed } from "vue";

dayjs.extend(relativeTime);

const props = defineProps({
  notification: Object,
});

const goToDetailPage = () => {
  router.get(
    route("admin.suggestions.show", props.notification.data.suggestion.id)
  );
};

const handleNotificationReadAt = () => {
  router.post(
    route("admin.notifications.read", props.notification.id),
    {},
    {
      onSuccess: () => {
        goToDetailPage();
      },
    }
  );
};
</script>

<template>
  <div
    @click="handleNotificationReadAt"
    v-if="
      notification.type ===
        'App\\Notifications\\WebsiteSuggestion\\NewSuggestionNotification' &&
      notification.data.suggestion.type === 'report_bug'
    "
    class="flex px-4 py-3 hover:bg-gray-100 cursor-pointer"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-amber-300 text-amber-700 ring-2 ring-amber-500 w-10 h-10 rounded-md flex items-center justify-center p-3 font-bold"
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
        {{ dayjs(notification.created_at).fromNow() }}
      </div>
    </div>
  </div>
</template>
