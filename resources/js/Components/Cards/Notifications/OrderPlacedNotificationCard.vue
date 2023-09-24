<script setup>
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const props = defineProps({
  notification: Object,
});

const goToDetailPage = () => {
  router.get(
    route("admin.orders.pending.show", props.notification.data.order_id)
  );
};

const handleNotificationReadAt = () => {
  router.patch(
    route("admin.notifications.read", props.notification.id),
    {
      notifiable_id: props.notification.notifiable_id,
    },
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
    v-if="notification.type === 'App\\Notifications\\OrderPlacedNotification'"
    :href="
      route('admin.orders.pending.show', {
        id: notification.data.order_id,
        noti_id: notification.id,
      })
    "
    @click="handleNotificationReadAt"
    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-sky-300 text-sky-700 ring-2 ring-sky-500 w-10 h-10 rounded-md flex items-center justify-center p-3 font-bold"
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
        {{ __(notification.data.message) }}

        <span
          class="font-bold text-sm block"
          :class="{
            'text-slate-600': !notification.read_at,
            'text-gray-500': notification.read_at,
          }"
        >
          {{ __("ORDER_NO") }} : {{ notification.data.order_no }}
        </span>
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
        {{ dayjs(notification.created_at).fromNow() }}
      </div>
    </div>
  </div>
</template>
