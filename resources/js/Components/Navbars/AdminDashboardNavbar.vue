<script setup>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";

const notifications = ref([]);

onMounted(() => {
  notifications.value = usePage().props.auth.user.notifications;

  Echo.private(`App.Models.User.${usePage().props.auth.user.id}`).notification(
    (notification) => {
      formatedNotifications.value.push(notification);
    }
  );
});

const formatedNotifications = ref([]);

watch(
  () => notifications.value,
  () => {
    formatedNotifications.value = notifications.value.map(
      (notification) => notification.data
    );
  }
);
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
            :class="{ 'ml-5': formatedNotifications.length }"
          ></i>
          <span
            v-if="formatedNotifications.length !== 0"
            class="relative -top-4 -right-0 flex items-center justify-center bg-red-600 rounded-full h-5 w-5 p-2"
          >
            <span class="text-[.7rem] font-bold text-white">
              {{ formatedNotifications.length }}
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
            v-for="(notification, index) in formatedNotifications"
            :key="index"
            class="divide-y divide-gray-100 dark:divide-gray-700"
          >
            <Link
              :href="
                route('admin.orders.pending.show', {
                  id: notification.order_id,
                })
              "
              class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700"
            >
              <div
                class="flex-shrink-0 bg-blue-300 text-blue-700 ring-2 ring-blue-400 w-10 h-10 rounded-full flex items-center justify-center p-3 font-bold"
              >
                <i class="fa-solid fa-cart-plus"></i>
              </div>
              <div class="w-full pl-3">
                <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400">
                  {{ notification.message }}

                  <span class="font-bold text-blue-600 text-sm"
                    >Order No : {{ notification.order_no }}</span
                  >
                </div>
                <div class="text-xs text-blue-600 dark:text-blue-500">
                  <!-- {{ notification.created_at }} -->2323232
                </div>
              </div>
            </Link>
          </div>

          <div
            class="w-full text-center py-3"
            v-if="!formatedNotifications.length"
          >
            <span class="text-sm text-slate-500 font-bold">
              <i class="fa-solid fa-bell" />
              There is no notifications
            </span>
          </div>
        </div>

        <UserDropdown />
      </ul>
    </div>
  </nav>
</template>


