<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

// Query String Parameters
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});
</script>

<template>
  <button
    id="dropdownNavbarLink"
    data-dropdown-toggle="dropdownNavbar"
    data-dropdown-trigger="hover"
    class="flex items-center justify-between w-full pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto"
  >
    <i class="fa-solid fa-list mr-2"></i>
    {{ __("SHOP_BY_CATEGORIES") }}
    <svg
      class="w-5 h-5 ml-1"
      aria-hidden="true"
      fill="currentColor"
      viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        fill-rule="evenodd"
        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
        clip-rule="evenodd"
      ></path>
    </svg>
  </button>
  <!-- Dropdown menu -->
  <div
    id="dropdownNavbar"
    class="hidden z-40 font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-md w-[900px] h-[700px] ml-10 overflow-auto scrollbar"
  >
    <div
      class="grid grid-cols-1 md:grid-cols-3 p-5 text-slate-700 overflow-auto scrollbar"
    >
      <ul
        class="m-3"
        v-for="category in $page.props.parentCategory"
        :key="category.id"
      >
        <li class="flex items-center">
          <img
            :src="category.image"
            alt=""
            class="w-7 h-7 rounded-full object-cover mr-2 border-2 border-secondary-500"
          />
          <Link
            :href="route('category.products', category.slug)"
            :data="{
              sort: params.sort,
              direction: params.direction,
              view: params.view,
            }"
            class="hover:text-blue-600 hover:underline cursor-pointer text-[1.1rem] font-bold"
          >
            {{ category.name }}
          </Link>
        </li>
        <li
          v-for="childCategory in category.children"
          :key="childCategory.id"
          class="flex items-start"
        >
          <span>
            <i class="fa-solid fa-circle text-[.4rem] text-slate-600 mx-4"></i>
          </span>

          <span>
            <Link
              :href="route('category.products', childCategory.slug)"
              :data="{
                sort: params.sort,
                direction: params.direction,
                view: params.view,
              }"
              class="font-medium text-sm hover:text-blue-600 hover:underline cursor-pointer"
            >
              {{ childCategory.name }}
            </Link>
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>
