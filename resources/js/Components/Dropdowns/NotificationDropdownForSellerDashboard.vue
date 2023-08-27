<script setup>
import FollowedShopNotificationCard from "@/Components/Cards/Notifications/FollowedShopNotificationCard.vue";
import ProductQuestionNotificationCard from "@/Components/Cards/Notifications/ProductQuestionNotificationCard.vue";
import ApprovedCreatedNewProductNotificationCard from "@/Components/Cards/Notifications/ApprovedCreatedNewProductNotificationCard.vue";
import DisapprovedCreatedNewProductNotificationCard from "@/Components/Cards/Notifications/DisapprovedCreatedNewProductNotificationCard.vue";
import { usePage, router } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const notifications = ref([]);

const totalUnreadNotifications = computed(() =>
  notifications.value.filter((notification) => !notification.read_at)
);

onMounted(() => {
  notifications.value = usePage().props.auth.user.notifications;

  Echo.private(`App.Models.User.${usePage().props.auth.user.id}`).notification(
    (notification) => {
      if (
        notification.type === "App\\Notifications\\FollowedShopNotification"
      ) {
        notifications.value.unshift({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            name: notification.name,
          },
        });
      } else if (
        notification.type ===
        "App\\Notifications\\ProductQuestions\\NewProductQuestionFromUserNotification"
      ) {
        notifications.value.unshift({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            product: notification.product,
            question: notification.question,
          },
        });
      } else if (
        notification.type ===
          "App\\Notifications\\Products\\AdminApprovedCreatedNewProductNotification" ||
        notification.type ===
          "App\\Notifications\\Products\\AdminDisapprovedCreatedNewProductNotification"
      ) {
        console.log(notification);
        notifications.value.unshift({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            product: notification.product,
          },
        });
      }
    }
  );
});

const sortedNotifications = computed(() => {
  return notifications.value.sort((a, b) => {
    const aReadAt = new Date(a.read_at);
    const bReadAt = new Date(b.read_at);
    const aCreatedAt = new Date(a.created_at);
    const bCreatedAt = new Date(b.created_at);

    // First, sort by read_at date, with null (unread) values first
    if (aReadAt === null && bReadAt !== null) return -1;
    if (aReadAt !== null && bReadAt === null) return 1;

    // Then, sort by read_at date in ascending order (oldest first)
    if (aReadAt !== null && bReadAt !== null) {
      if (aReadAt > bReadAt) return -1;
      if (aReadAt < bReadAt) return 1;
    }

    // If both are unread or have the same read_at date, sort by created_at date in ascending order (oldest first)
    if (aCreatedAt > bCreatedAt) return -1;
    if (aCreatedAt < bCreatedAt) return 1;

    return 0; // Return 0 if both read_at and created_at dates are the same
  });
});

const handleMarkAllAsRead = () => {
  router.patch(
    route("seller.notifications.read-all"),
    {
      notifications: totalUnreadNotifications.value,
    },
    {
      onSuccess: () => {
        window.location.reload();
      },
    }
  );
};
</script>

<template>
  <button
    id="vendorDropdownNotificationButton"
    data-dropdown-toggle="vendorDropdownNotification"
    data-dropdown-placement="bottom"
    data-dropdown-trigger="hover"
    class="inline-flex items-center justify-center ring-2 ring-slate-300 mx-3 text-sm font-medium w-10 h-10 rounded-full bg-gray-200 text-center text-gray-500 hover:text-gray-900 focus:outline-none"
    type="button"
  >
    <i
      class="fa-solid fa-bell"
      :class="{ 'ml-5': totalUnreadNotifications.length }"
    ></i>
    <span
      v-if="totalUnreadNotifications.length !== 0"
      class="relative -top-4 -right-0 flex items-center justify-center bg-red-600 rounded-full h-5 w-5 p-2"
    >
      <span class="text-[.7rem] font-bold text-white">
        {{ totalUnreadNotifications.length }}
      </span>
    </span>
  </button>

  <!-- Dropdown menu -->
  <div
    id="vendorDropdownNotification"
    class="z-20 w-1/2 hidden h-auto max-h-[800px] overflow-auto max-w-sm bg-white divide-y divide-gray-200 rounded-[5px] border-slate-300 shadow border scrollbar"
    aria-labelledby="vendorDropdownNotificationButton"
  >
    <div
      class="flex items-center justify-between px-4 py-3 font-semibold text-center text-gray-700 rounded-t-lg bg-gray-50"
    >
      <span class="text-lg">
        {{ __("NOTIFICATIONS") }}
      </span>
      <span class="">
        <button
          @click="handleMarkAllAsRead"
          class="text-xs hover:text-blue-600"
        >
          {{ __("MARK_ALL_AS_READ") }}
        </button>
      </span>
    </div>

    <div
      v-for="notification in sortedNotifications"
      :key="notification.id"
      class="divide-y divide-gray-300 dark:divide-gray-700"
    >
      <ApprovedCreatedNewProductNotificationCard :notification="notification" />
      <DisapprovedCreatedNewProductNotificationCard
        :notification="notification"
      />
      <FollowedShopNotificationCard :notification="notification" />

      <!-- <ProductQuestionNotificationCard :notification="notification" /> -->
    </div>

    <div class="w-full text-center py-3" v-if="!notifications.length">
      <span class="text-sm text-slate-500 font-bold">
        <i class="fa-solid fa-bell" />
        {{ __("THERE_ARE_NO_NOTIFICATIONS") }}
      </span>
    </div>
  </div>
</template>
