<script setup>
defineProps({
  message: Object,
});
</script>

<template>
  <div class="font-bold text-slate-500 hover:text-slate-800">
    <button
      id="messageDropdown"
      :data-dropdown-toggle="'messageDropdownDots' + message.id"
      data-dropdown-placement="left-start"
      type="button"
      class="p-2"
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
      :id="'messageDropdownDots' + message.id"
      class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
    >
      <ul
        class="py-2 text-sm text-gray-600 font-normal"
        aria-labelledby="messageDropdown"
      >
        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-circle-check mr-1"></i>
            {{ __("SELECT") }}
          </a>
        </li>
        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-reply mr-1"></i>
            {{ __("REPLY") }}
          </a>
        </li>
        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-thumbtack mr-1"></i>
            {{ __("PIN") }}
          </a>
        </li>
        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-copy mr-1"></i>
            {{ __("COPY_TEXT") }}</a
          >
        </li>
        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-download mr-1"></i>
            {{ __("DOWNLOAD") }}</a
          >
        </li>
        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-edit mr-1"></i>
            {{ __("EDIT") }}</a
          >
        </li>

        <li>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">
            <i class="fa-solid fa-trash mr-1"></i>
            {{ __("DELETE") }}</a
          >
        </li>
      </ul>
    </div>
  </div>
</template>

