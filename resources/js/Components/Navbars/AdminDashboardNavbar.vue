<script setup>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import RegisteredVendorNotificationCard from "@/Components/Cards/RegisteredVendorNotificationCard.vue";
import RegisteredUserNotificationCard from "@/Components/Cards/RegisteredUserNotificationCard.vue";
import OrderPlacedNotificationCard from "@/Components/Cards/OrderPlacedNotificationCard.vue";
import FollowedShopNotificationCard from "@/Components/Cards/FollowedShopNotificationCard.vue";
import { Link, usePage } from "@inertiajs/vue3";
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
        "App\\Notifications\\Registered\\RegisteredUserNotification"
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
        console.log(notification);

        notifications.value.push({
          id: notification.id,
          type: notification.type,
          data: {
            message: notification.message,
          },
        });
      }
    }
  );
});
</script>

<template>
  <nav
    class="absolute top-0 left-0 w-full z-3 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 bg-blue-500"
  >
    <div
      class="w-full mx-auto items-center flex justify-end md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <Link
        :href="route('admin.dashboard')"
        class="text-white text-sm uppercase hidden lg:inline-block font-semibold text-right ml-60"
      >
        Admin Dashboard
      </Link>

      <form
        class="md:flex hidden flex-row flex-wrap items-center lg:ml-auto mr-3"
      >
        <div class="relative flex w-full flex-wrap items-stretch">
          <span
            class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3"
          >
            <i class="fas fa-search"></i>
          </span>
          <input
            type="text"
            placeholder="Search here..."
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10"
          />
        </div>
      </form>
      <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
        <button
          id="dropdownNotificationButton"
          data-dropdown-toggle="dropdownNotification"
          data-dropdown-placement="bottom"
          data-dropdown-trigger="hover"
          class="inline-flex items-center justify-center ring-2 ring-slate-300 mx-5 text-sm font-medium w-10 h-10 rounded-full bg-gray-200 text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400"
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
          class="z-20 w-1/2 hidden h-auto max-h-[800px] overflow-auto max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700 border scrollbar"
          aria-labelledby="dropdownNotificationButton"
        >
          <div
            class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white"
          >
            Notifications
          </div>

          <div
            v-for="notification in notifications"
            :key="notification.id"
            class="divide-y divide-gray-300 dark:divide-gray-700"
          >
            <RegisteredVendorNotificationCard :notification="notification" />
            <RegisteredUserNotificationCard :notification="notification" />
            <OrderPlacedNotificationCard :notification="notification" />
            <FollowedShopNotificationCard :notification="notification" />
          </div>

          <div class="w-full text-center py-3" v-if="!notifications.length">
            <span class="text-sm text-slate-500 font-bold">
              <i class="fa-solid fa-bell" />
              There are no notifications
            </span>
          </div>
        </div>

        <UserDropdown />
      </ul>
    </div>
  </nav>
</template>


