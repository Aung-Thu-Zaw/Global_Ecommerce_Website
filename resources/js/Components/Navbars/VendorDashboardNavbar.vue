<template>
  <!-- Navbar -->
  <nav
    class="absolute top-0 left-0 w-full z-3 md:flex-row md:flex-nowrap md:justify-start flex items-center p-4 bg-cyan-700"
  >
    <div
      class="w-full mx-auto items-center flex justify-end md:flex-nowrap flex-wrap md:px-10 px-4"
    >
      <Link
        :href="route('vendor.dashboard')"
        class="text-white text-sm hidden lg:inline-block font-semibold text-right ml-60"
      >
        <span class="uppercase"> Vendor Dashboard </span>
        <span
          v-if="
            $page.props.auth.user.role === 'vendor' &&
            $page.props.auth.user.status === 'inactive'
          "
          class="px-3 py-1 bg-orange-200 text-orange-700 rounded-xl"
        >
          <i class="fa-solid fa-spinner animate-spin"></i>
          Pending
        </span>
        <span
          v-if="
            $page.props.auth.user.role === 'vendor' &&
            $page.props.auth.user.status === 'active'
          "
          class="px-3 py-1 bg-green-200 text-green-600 rounded-xl"
        >
          <i class="fa-solid fa-circle-check"></i>
          Verified
        </span>
      </Link>

      <!-- Form -->
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
      <!-- User -->
      <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
        <UserDropdown />
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
</template>

<script>
import { Link } from "@inertiajs/vue3";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";

export default {
  components: {
    UserDropdown,
  },
};
</script>
