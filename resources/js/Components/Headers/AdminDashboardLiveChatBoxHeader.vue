<script setup>
defineProps({
  liveChat: Object,
});
</script>


<template>
  <div class="w-full border-b bg-white px-5 py-3 flex items-center">
    <div class="flex items-center justify-between w-full">
      <div class="flex items-center">
        <div class="mr-3">
          <img
            :src="liveChat?.user?.avatar"
            class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300"
          />
        </div>
        <div>
          <div class="flex items-center space-x-3">
            <h3 class="text-slate-700 font-bold text-md">
              {{ liveChat?.user?.name }}
            </h3>
          </div>

          <!-- Online Status -->
          <!-- <div class="flex items-center text-green-500 animate-pulse space-x-1">
            <i class="fa-solid fa-circle text-[.5rem]"></i>
            <span class="text-xs font-bold">Online</span>
          </div> -->
        </div>
      </div>

      <div class="flex items-center space-x-5">
        <!-- Search Icon -->
        <div
          @click="isMessageSearchFormOpened = !isMessageSearchFormOpened"
          class="cursor-pointer text-slate-600 hover:text-slate-800"
        >
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <!-- Dropdown  -->
        <div class="font-bold text-slate-600 hover:text-slate-800">
          <button
            id="dropdownMenuIconButton"
            data-dropdown-toggle="dropdownDots"
            type="button"
            class="p-2 hover:bg-gray-200 rounded-md"
          >
            <svg
              class="w-4 h-4"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 4 15"
            >
              <path
                d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
              />
            </svg>
          </button>

          <!-- Dropdown menu -->
          <div
            id="dropdownDots"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
          >
            <ul
              class="py-2 text-sm text-gray-600 font-medium"
              aria-labelledby="dropdownMenuIconButton"
            >
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                  <i class="fa-solid fa-file-export mr-1"></i>
                  {{ __("EXPORT_CHAT") }}</a
                >
              </li>
              <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                  <i class="fa-solid fa-broom mr-1"></i>
                  {{ __("CLEAR_HISTORY") }}</a
                >
              </li>
            </ul>
            <div class="py-2">
              <a
                href="#"
                class="block px-4 py-2 hover:bg-gray-100 text-red-600 text-sm font-medium"
              >
                <i class="fa-solid fa-trash-can mr-2"></i>
                {{ __("DELETE_CHAT") }}</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

