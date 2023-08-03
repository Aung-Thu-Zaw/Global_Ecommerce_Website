<script setup>
import CategoryDropdown from "@/Components/Dropdowns/CategoryDropdown.vue";
import ShopListDropdown from "@/Components/Dropdowns/ShopListDropdown.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <nav class="relative shadow-sm bg-secondary-200">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="hidden lg:flex flex-1 items-center py-1">
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
          <ul
            class="flex flex-col p-2 mt-4 rounded-lg md:flex-row md:space-x-5 md:mt-0 md:text-sm md:border-0 font-bold"
          >
            <li class="relative">
              <!-- Category List -->
              <CategoryDropdown />
            </li>
            <li class="relative">
              <!-- Shop List -->
              <ShopListDropdown />
            </li>
            <li class="relative">
              <!-- Our Blogs  -->
              <Link
                :href="route('blogs.index')"
                :data="{
                  view: 'grid',
                }"
                class="font-bold text-sm text-gray-700 hover:text-blue-700 transition-all ml-3"
              >
                <i class="fa-solid fa-newspaper mr-2"></i>
                <span>
                  {{ __("OUR_BLOGS") }}
                </span>
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>
