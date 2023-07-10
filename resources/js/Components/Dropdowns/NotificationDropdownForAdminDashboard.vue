<script setup>
import RegisteredVendorNotificationCard from "@/Components/Cards/RegisteredVendorNotificationCard.vue";
import RegisteredUserNotificationCard from "@/Components/Cards/RegisteredUserNotificationCard.vue";
import OrderPlacedNotificationCard from "@/Components/Cards/OrderPlacedNotificationCard.vue";
import DeletedUserNotificationCard from "@/Components/Cards/DeletedUserNotificationCard.vue";
import DeletedVendorNotificationCard from "@/Components/Cards/DeletedVendorNotificationCard.vue";
import NewsletterSubscribedNotificationCard from "@/Components/Cards/NewsletterSubscribedNotificationCard.vue";
import NewSuggestionNotificationCard from "@/Components/Cards/NewSuggestionNotificationCard.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const notifications = ref([]);

const totalUnreadNotification = computed(() =>
  notifications.value.filter((notification) => !notification.read_at)
);

onMounted(() => {
  notifications.value = usePage().props.auth.user.notifications;

  Echo.private(`App.Models.User.${usePage().props.auth.user.id}`).notification(
    (notification) => {
      if (notification.type === "App\\Notifications\\OrderPlacedNotification") {
        notifications.value.push({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            order_id: notification.order_id,
            order_no: notification.order_no,
          },
        });
      } else if (
        notification.type ===
          "App\\Notifications\\AccountRegistered\\RegisteredUserNotification" ||
        notification.type ===
          "App\\Notifications\\AccountDeleted\\UserAccountDeletedNotification"
      ) {
        notifications.value.push({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            user: notification.user,
          },
        });
      } else if (
        notification.type === "App\\Notifications\\FollowedShopNotification"
      ) {
        notifications.value.push({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
          },
        });
      } else if (
        notification.type ===
        "App\\Notifications\\SubscribedNewsletter\\NewsletterSubscribedNotification"
      ) {
        notifications.value.push({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            subscriber: notification.subscriber,
          },
        });
      } else if (
        notification.type ===
        "App\\Notifications\\WebsiteSuggestion\\NewSuggestionNotification"
      ) {
        notifications.value.push({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            suggestion: notification.suggestion,
          },
        });
      }
    }
  );
});
</script>

<template>
  <button
    id="dropdownNotificationButton"
    data-dropdown-toggle="dropdownNotification"
    data-dropdown-placement="bottom"
    data-dropdown-trigger="hover"
    class="inline-flex items-center justify-center ring-2 ring-slate-300 mx-3 text-sm font-medium w-10 h-10 rounded-full bg-gray-200 text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400"
    type="button"
  >
    <i
      class="fa-solid fa-bell"
      :class="{ 'ml-5': totalUnreadNotification.length }"
    ></i>
    <span
      v-if="totalUnreadNotification.length !== 0"
      class="relative -top-4 -right-0 flex items-center justify-center bg-red-600 rounded-full h-5 w-5 p-2"
    >
      <span class="text-[.7rem] font-bold text-white">
        {{ totalUnreadNotification.length }}
      </span>
    </span>
  </button>

  <!-- Dropdown menu -->
  <div
    id="dropdownNotification"
    class="z-20 w-1/2 hidden h-auto max-h-[800px] overflow-auto max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow border scrollbar"
    aria-labelledby="dropdownNotificationButton"
  >
    <div
      class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50"
    >
      {{ __("NOTIFICATIONS") }}
    </div>

    <div
      v-for="notification in notifications"
      :key="notification.id"
      class="divide-y divide-gray-300"
    >
      <RegisteredVendorNotificationCard :notification="notification" />
      <RegisteredUserNotificationCard :notification="notification" />
      <DeletedVendorNotificationCard :notification="notification" />
      <DeletedUserNotificationCard :notification="notification" />
      <NewsletterSubscribedNotificationCard :notification="notification" />
      <NewSuggestionNotificationCard :notification="notification" />
      <OrderPlacedNotificationCard :notification="notification" />
    </div>

    <div class="w-full text-center py-3" v-if="!notifications.length">
      <span class="text-sm text-slate-500 font-bold">
        <i class="fa-solid fa-bell" />
        {{ __("THERE_ARE_NO_NOTIFICATIONS") }}
      </span>
    </div>
  </div>
</template>
