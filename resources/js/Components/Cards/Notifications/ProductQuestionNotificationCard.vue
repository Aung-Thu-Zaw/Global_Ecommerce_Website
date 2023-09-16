<script setup>
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { computed } from "vue";

dayjs.extend(relativeTime);

const props = defineProps({
  notification: Object,
});

const goToQuestion = () => {
  router.get(route("products.show", props.notification.data.product));
};

const handleNotificationReadAt = () => {
  router.patch(
    route("seller.notifications.read", props.notification.id),
    {
        notifiable_id: props.notification.notifiable_id,
    },
    {
      onSuccess: () => {
        goToQuestion();
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
      'App\\Notifications\\ProductQuestions\\NewProductQuestionFromUserNotification'
    "
    :href="route('products.show', notification.data.product)"
    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-purple-300 text-purple-700 ring-2 ring-purple-500 w-10 h-10 rounded-md flex items-center justify-center p-3 font-bold"
    >
      <i class="fa-solid fa-question"></i>
    </div>
    <div class="w-full pl-3">
      <div
        class="text-sm mb-1.5"
        :class="{
          'text-gray-600': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        {{ __(notification.data.message) }}

        <span
          class="font-bold text-sm block line-clamp-1"
          :class="{
            'text-slate-600': !notification.read_at,
            'text-gray-500': notification.read_at,
          }"
        >
          {{ notification.data.question }}
        </span>
      </div>
      <div
        class="text-xs font-bold"
        :class="{
          'text-purple-500': !notification.read_at,
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
