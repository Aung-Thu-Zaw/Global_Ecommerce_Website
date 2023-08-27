<script setup>
import BlogCommentReplyNotificationCard from "@/Components/Cards/Notifications/BlogCommentReplyNotificationCard.vue";
import ProductQuestionAnswerNotificationCard from "@/Components/Cards/Notifications/ProductQuestionAnswerNotificationCard.vue";
import { usePage, router } from "@inertiajs/vue3";
import { computed, onMounted, onUpdated, ref } from "vue";

const notifications = ref([]);

const totalUnreadNotifications = computed(() =>
  notifications.value.filter((notification) => !notification.read_at)
);

onMounted(() => {
  notifications.value = usePage().props.auth.user.notifications;

  Echo.private(`App.Models.User.${usePage().props.auth.user.id}`).notification(
    (notification) => {
      if (
        notification.type ===
        "App\\Notifications\\Blogs\\BlogCommentReplyFromAuthorNotification"
      ) {
        notifications.value.unshift({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            blog: notification.blog,
            reply: notification.reply,
          },
        });
      } else if (
        notification.type ===
        "App\\Notifications\\ProductQuestions\\ProductQuestionAnswerFromSellerNotification"
      ) {
        notifications.value.unshift({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
            product: notification.product,
            answer: notification.answer,
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
    route("notifications.read-all"),
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
  <div class="relative">
    <button
      id="dropdownNotificationButton"
      data-tooltip-target="notifications"
      data-tooltip-placement="left"
      data-dropdown-toggle="dropdownNotification"
      data-dropdown-placement="left"
      data-dropdown-trigger="hover"
      class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
      type="button"
    >
      <i class="fa-solid fa-bell text-md"></i>

      <div
        v-if="totalUnreadNotifications.length !== 0"
        class="absolute -top-1 -right-1 bg-red-600 w-4 h-4 rounded-full text-[.7rem] flex items-center justify-center"
      >
        <span class="text-[.7rem] font-bold text-white">
          {{ totalUnreadNotifications.length }}
        </span>
      </div>
    </button>
  </div>

  <!-- Dropdown menu -->
  <div
    id="dropdownNotification"
    class="z-50 w-[500px] hidden h-auto max-h-[800px] overflow-auto max-w-sm bg-white divide-y divide-gray-200 rounded-[5px] border-slate-300 shadow border scrollbar"
    aria-labelledby="dropdownNotificationButton"
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
      class="divide-y divide-gray-300 w-full"
    >
      <BlogCommentReplyNotificationCard :notification="notification" />
      <ProductQuestionAnswerNotificationCard :notification="notification" />
    </div>

    <div class="w-full text-center py-3" v-if="!sortedNotifications.length">
      <span class="text-sm text-slate-500 font-bold">
        <i class="fa-solid fa-bell" />
        {{ __("THERE_ARE_NO_NOTIFICATIONS") }}
      </span>
    </div>
  </div>
</template>





