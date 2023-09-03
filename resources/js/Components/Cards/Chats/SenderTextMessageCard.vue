<script setup>
</script>


<template>
  <!-- Right Side  -->
  <div class="mb-2">
    <p class="text-center text-sm text-slate-500 font-bold mb-5">
      22-April-2023 ( Monday )
    </p>
    <div class="flex items-end justify-end">
      <div class="flex items-center justify-end">
        <div class="pl-28">
          <div class="flex items-center justify-center">
            <!-- Dropdown  -->
            <div class="font-bold text-slate-500 hover:text-slate-800">
              <button
                id="messageDropdown"
                data-dropdown-toggle="messageDropdownDots"
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
                id="messageDropdownDots"
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
            <p
              class="p-3 bg-slate-50 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
            >
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae
              aspernatur voluptatum beatae libero ex vero quisquam sequi nam,
              cupiditate eaque.
            </p>
          </div>
          <div
            class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-end space-x-4"
          >
            <span class="font-bold">{{ __("EDITED") }}</span>
            <div class="flex items-center justify-end space-x-2 mr-2">
              <span class=""> 3:30 PM </span>
              <span class="text-[.6rem] text-slate-600">
                <i class="fa-solid fa-check text-green-500"></i>
                <i class="fa-solid fa-check text-green-500"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <img
        src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
        class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
      />
    </div>
  </div>
</template>

