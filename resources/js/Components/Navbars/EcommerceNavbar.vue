<script setup>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { computed, reactive } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Calculate Total Item
const totalItems = computed(() => {
  if (usePage().props.totalCartItems) {
    return usePage().props.totalCartItems.cart_items.reduce(
      (acc, item) => acc + item.qty,
      0
    );
  }
  return;
});

// Query String Parameter
const params = reactive({
  search: usePage().props.ziggy.query.search
    ? usePage().props.ziggy.query.search
    : "",
  sort: "id",
  direction: "desc",
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

// Handle Search
const handleSearch = () => {
  if (params.search === "") {
    router.get(route("home"));
  } else {
    router.get(route("product.search"), {
      search: params.search,
      sort: params.sort,
      direction: params.direction,
      view: params.view,
    });
  }
};

// Handle Order Tracking
const form = useForm({
  order_no: "",
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleTrackOrder = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("track_order");
  submit();
};

const submit = () => {
  form.post(route("order.track"), {
    onFinish: () => form.reset(),
    onSuccess: () => {
      if (usePage().props.flash.errorMessage) {
        toast.error(usePage().props.flash.errorMessage, {
          autoClose: 2000,
        });
      }
    },
  });
};

// Handle Change Language
const handleChangeLanguage = (language) => {
  router.post(
    route("languages.change", { locale: language }),
    {},
    {
      onSuccess: () => {
        window.location.reload();
      },
    }
  );
};
</script>


<template>
  <nav class="bg-blue-600 text-white">
    <div class="flex items-center justify-between px-10">
      <span class="text-sm font-bold">GLOBAL E-COMMERCE WEBSITE</span>
      <!-- Menus -->
      <nav class="hidden lg:flex flex-1 items-center justify-end py-1">
        <a
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 uppercase"
          href="#"
        >
          <i class="fa-solid fa-circle-info"></i>
          {{ __("HELP_CENTER") }}
        </a>

        <span>|</span>

        <Link
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 uppercase"
          :href="route('vendor.register')"
        >
          <i class="fa-solid fa-store"></i>
          {{ __("BECOME_A_SELLER") }}
        </Link>

        <span>|</span>

        <!-- Order Tracking -->
        <div
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 cursor-pointer uppercase"
          data-dropdown-toggle="dropdownSearch"
          data-dropdown-placement="bottom"
          data-te-toggle="tooltip"
          data-te-placement="bottom"
          title="Check what happened to my products order?"
        >
          <i class="fa-solid fa-location-crosshairs"></i>
          {{ __("TRACK_MY_ORDER") }}
        </div>
        <div
          id="dropdownSearch"
          class="z-10 hidden bg-gray-50 rounded-lg shadow-md w-[300px] p-5"
        >
          <h4 class="font-bold text-lg mb-4 text-slate-700 text-center">
            <i class="fa-solid fa-location-crosshairs"></i>
            {{ __("TRACK_MY_ORDER") }}
          </h4>

          <form @submit.prevent="handleTrackOrder">
            <label for="" class="text-sm font-bold text-slate-800 mb-3">
              {{ __("ENTER_YOUR_ORDER_NUMBER") }}
            </label>
            <input
              type="text"
              class="w-full rounded-sm text-slate-800"
              placeholder="Eg. #e5353453er"
              v-model="form.order_no"
            />
            <button
              class="font-bold text-sm bg-blue-600 w-full py-2 px 4 my-3 hover:bg-blue-700"
            >
              {{ __("SEARCH") }}
            </button>
          </form>
        </div>

        <span>|</span>

        <!-- Languages Dropdown -->
        <div class="flex justify-center">
          <div>
            <div class="relative" data-te-dropdown-ref>
              <a
                class="flex items-center whitespace-nowrap px-4 pt-2.5 pb-2 text-sm font-bold uppercase leading-normal text-white"
                href="#"
                type="button"
                id="dropdownMenuButton2"
                data-te-dropdown-toggle-ref
                aria-expanded="false"
              >
                <i class="fa-solid fa-globe mr-1"></i>

                {{ __("LANGUAGE") }}
                <span class="ml-2 w-2">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    class="h-5 w-5"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </span>
              </a>
              <ul
                class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg [&[data-te-dropdown-show]]:block"
                aria-labelledby="dropdownMenuButton2"
                data-te-dropdown-menu-ref
              >
                <li
                  v-for="language in $page.props.languages"
                  :key="language.id"
                >
                  <div
                    @click="handleChangeLanguage(language.short_name)"
                    class="block w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 cursor-pointer"
                    data-te-dropdown-item-ref
                  >
                    {{ language.name }}
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </nav>

  <header class="bg-white shadow-sm border border-b">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="py-3 md:flex items-center">
        <div class="flex items-center flex-shrink-0 mb-4 md:mb-0">
          <Link
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

        <div class="w-full flex flex-nowrap items-center md:w-1/2">
          <input
            class="flex-grow appearance-none border border-gray-200 bg-gray-100 rounded-md mr-2 py-2 px-3 hover:border-gray-400 focus:outline-none focus:border-gray-400 placeholder:text-sm placeholder:text-gray-400"
            type="text"
            v-model="params.search"
            :placeholder="__('WHAT_ARE_YOU_LOOKING_FOR') + '?'"
          />
          <button
            @click="handleSearch"
            type="button"
            class="px-4 py-2 inline-block text-white border border-transparent bg-blue-600 rounded-md hover:bg-blue-700"
          >
            <i class="fa fa-search"></i>
          </button>
        </div>

        <nav
          v-if="$page.props.auth.user"
          class="hidden md:flex justify-end flex-1 items-center"
        >
          <!-- User Profile Dropdown  -->
          <UserDropdown />

          <Link
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

        <nav v-else class="hidden md:flex justify-end flex-1 items-center">
          <div class="flex items-center space-x-2 ml-auto">
            <Link
              class="px-3 py-2 inline-block text-center text-gray-700 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100 hover:border-gray-300"
              :href="route('register')"
            >
              <i class="text-gray-400 w-5 fa fa-user"></i>
              <span class="hidden lg:inline ml-1 text-sm font-bold">
                {{ __("SIGN_UP") }}
              </span>
            </Link>
            <Link
              class="px-3 py-2 inline-block text-center text-white bg-blue-500 shadow-sm border border-gray-200 rounded-md hover:bg-blue-700"
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



