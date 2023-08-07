<script setup>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import NotificationDropdownForSellerDashboard from "@/Components/Dropdowns/NotificationDropdownForSellerDashboard.vue";
import LanguageDropdownForDashboard from "@/Components/Dropdowns/LanguageDropdownForDashboard.vue";
</script>

<template>
  <nav
    class="absolute top-0 left-0 w-full z-3 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 bg-cyan-700"
  >
    <div
      class="w-full mx-auto items-center flex justify-end md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <Link
        :href="route('seller.dashboard')"
        class="text-white text-sm uppercase hidden lg:inline-block font-semibold text-right ml-60"
      >
        <span class="uppercase"> Seller Dashboard </span>
        <span
          v-if="
            $page.props.auth.user.role === 'seller' &&
            $page.props.auth.user.status === 'inactive'
          "
          class="px-3 py-1 bg-orange-200 text-orange-700 rounded-xl"
        >
          <i class="fa-solid fa-spinner animate-spin"></i>
          {{ __("PENDING") }}
        </span>
        <span
          v-if="
            $page.props.auth.user.role === 'seller' &&
            $page.props.auth.user.status === 'active'
          "
          class="px-3 py-1 bg-green-200 text-green-600 rounded-xl"
        >
          <i class="fa-solid fa-circle-check"></i>
          {{ __("VERIFIED") }}
        </span>
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
            :placeholder="__('SEARCH_HERE') + '...'"
            class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm shadow outline-none focus:outline-none focus:ring w-full pl-10"
          />
        </div>
      </form>

      <ul
        class="flex-col md:flex-row list-none items-center justify-center hidden md:flex"
      >
        <NotificationDropdownForSellerDashboard />

        <LanguageDropdownForDashboard />

        <UserDropdown />
      </ul>
    </div>
  </nav>
</template>


