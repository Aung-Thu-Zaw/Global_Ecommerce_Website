<script setup>
import OrderTrackingForm from "@/Components/Forms/OrderTrackingForm.vue";
import EcommerceSearchInputForm from "@/Components/Forms/EcommerceSearchInputForm.vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import LanguageDropdown from "@/Components/Dropdowns/LanguageDropdown.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

// Calculate Total Items
const totalItems = computed(() => {
  if (usePage().props.totalCartItems) {
    return usePage().props.totalCartItems.cart_items.reduce(
      (acc, item) => acc + item.qty,
      0
    );
  }
  return;
});
</script>


<template>
  <nav class="bg-blue-600 text-white">
    <div class="flex items-center justify-between px-10">
      <!-- Title -->
      <span class="text-sm font-bold">GLOBAL E-COMMERCE WEBSITE</span>
      <nav class="hidden lg:flex flex-1 items-center justify-end py-1">
        <!-- Help Center -->
        <Link
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 uppercase"
          :href="route('help-center.index')"
        >
          <i class="fa-solid fa-circle-info"></i>
          {{ __("HELP_CENTER") }}
        </Link>

        <span>|</span>

        <!-- Seller Register -->
        <Link
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 uppercase"
          :href="route('vendor.register')"
        >
          <i class="fa-solid fa-store"></i>
          {{ __("BECOME_A_SELLER") }}
        </Link>

        <span>|</span>

        <!-- Order Tracking -->
        <OrderTrackingForm />

        <span>|</span>

        <!-- Change Languages Dropdown -->
        <LanguageDropdown />
      </nav>
    </div>
  </nav>

  <!-- Middle Navbar -->
  <header class="bg-white shadow-sm border border-b">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="py-3 md:flex items-center">
        <!-- Website Logo -->
        <div class="flex items-center flex-shrink-0 mb-4 md:mb-0">
          <Link
            v-if="$page.props.websiteSetting.logo"
            :href="route('home')"
            class="mr-20 md:mr-3 lg:mr-24 pr-4 w-[200px]"
          >
            <img
              :src="$page.props.websiteSetting.logo"
              alt=""
              class="h-12 w-full object-cover"
            />
          </Link>
          <Link
            v-else
            :href="route('home')"
            class="mr-20 md:mr-3 lg:mr-24 pr-4 text-xl text-slate-600 font-bold"
          >
            Global E-commerce
          </Link>

          <div class="md:hidden ml-auto">
            <button
              type="button"
              class="bg-white p-3 inline-flex items-center justify-center rounded-md text-gray-400 font-semibold hover:bg-gray-200 hover:text-gray-800 border border-transparent"
            >
              <span class="sr-only">Open menu</span>
              <i class="fa fa-bars fa-lg"></i>
            </button>
          </div>
        </div>

        <!-- Global Search With History And Suggestion -->
        <EcommerceSearchInputForm />

        <!-- Auuthorized User Actions -->
        <nav
          v-if="$page.props.auth.user"
          class="hidden md:flex justify-end flex-1 items-center"
        >
          <!-- User Profile Dropdown  -->
          <UserDropdown />

          <!-- My Cart Button -->
          <Link
            as="button"
            class="relative px-3 py-2 ml-5 inline-block text-center text-white bg-blue-600 shadow-sm border border-gray-300 rounded-md hover:bg-blue-700"
            :href="route('cart.index')"
          >
            <i class="w-5 fa fa-shopping-cart"></i>
            <span class="hidden lg:inline ml-1"> {{ __("MY_CART") }}</span>
            <span
              v-if="totalItems"
              class="bg-red-500 text-[.7rem] absolute -top-2 -right-2 w-5 h-5 p-2 rounded-full flex items-center justify-center"
            >
              {{ totalItems }}
            </span>
          </Link>
        </nav>

        <!-- Unauthorized User Actions -->
        <nav v-else class="hidden md:flex justify-end flex-1 items-center">
          <div class="flex items-center space-x-2 ml-auto">
            <!-- Sign Up Button -->
            <Link
              as="button"
              class="px-3 py-2 inline-block text-center text-gray-700 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100 hover:border-gray-300 uppercase"
              :href="route('register')"
            >
              <i class="text-gray-400 w-5 fa fa-user"></i>
              <span class="hidden lg:inline ml-1 text-sm font-bold">
                {{ __("SIGN_UP") }}
              </span>
            </Link>

            <!-- Sign In Button -->
            <Link
              as="button"
              class="px-3 py-2 inline-block text-center text-white bg-blue-500 shadow-sm border border-gray-200 rounded-md hover:bg-blue-700 uppercase"
              :href="route('login')"
            >
              <i class="w-5 fa fa-user"></i>
              <span class="hidden lg:inline ml-1 text-sm font-bold">
                {{ __("SIGN_IN") }}
              </span>
            </Link>
          </div>
        </nav>
      </div>
    </div>
  </header>
</template>



