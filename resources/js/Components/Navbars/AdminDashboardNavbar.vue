<script setup>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import LanguageDropdownForDashboard from "@/Components/Dropdowns/LanguageDropdownForDashboard.vue";
import NotificationDropdownForAdminDashboard from "@/Components/Dropdowns/NotificationDropdownForAdminDashboard.vue";
</script>

<template>
  <nav
    class="absolute top-0 left-0 w-full z-3 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 bg-blue-500"
  >
    <div
      class="w-full mx-auto items-center flex justify-end md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <!-- Dashboard Title -->
      <Link
        :href="route('admin.dashboard')"
        class="text-white text-sm uppercase hidden lg:inline-block font-semibold text-right ml-60"
      >
        Admin Dashboard
      </Link>

      <!-- Dashboard Search Form -->
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
            :placeholder="__('SEARCH_HERE') + '...'"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10"
          />
        </div>
      </form>
      <ul
        class="flex-col md:flex-row list-none items-center justify-center hidden md:flex"
      >
        <!-- Admin Dashboard Notification Dropdown -->
        <NotificationDropdownForAdminDashboard />

        <!-- Admin Dashboard Language Dropdown -->
        <LanguageDropdownForDashboard />

        <!-- User Dropdown -->
        <UserDropdown />
      </ul>
    </div>
  </nav>
</template>


