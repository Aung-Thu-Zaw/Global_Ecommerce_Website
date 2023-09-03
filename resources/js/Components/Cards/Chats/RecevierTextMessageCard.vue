<script setup>
</script>


<template>
  <div class="mb-2">
    <div>
      <p class="text-center text-sm text-slate-500 font-bold mb-5">
        22-April-2023 ( Sunday )
      </p>
      <div class="flex items-end">
        <img
          src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
          class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
        />

        <div class="flex items-end justify-start w-full">
          <div class="pr-28">
            <div class="flex items-center justify-start">
              <p
                class="p-3 bg-slate-200 border-2 border-slate-300 rounded-xl rounded-bl-none shadow w-auto max-w-[500px] text-sm"
              >
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Voluptates hic soluta repudiandae sit cumque velit ratione nam
                fugiat magnam blanditiis. Debitis, culpa ex dolores repellendus
                corporis nemo at quibusdam. Sequi!ff
              </p>
              <!-- Dropdown  -->
              <div class="font-bold text-slate-500 hover:text-slate-800">
                <button
                  id="messageDropdown"
                  data-dropdown-toggle="messageDropdownDots"
                  data-dropdown-placement="right-start"
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
                        Select
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-reply mr-1"></i>
                        Reply
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-thumbtack mr-1"></i>
                        Pin
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-copy mr-1"></i>
                        Copy Text</a
                      >
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-download mr-1"></i>
                        Download</a
                      >
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-edit mr-1"></i>
                        Edit</a
                      >
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-trash mr-1"></i>
                        Delete</a
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div
              class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-start space-x-4"
            >
              <div class="flex items-center justify-end space-x-2">
                <span class=""> 3:30 PM </span>
                <span class="text-[.6rem] text-slate-600">
                  <i class="fa-solid fa-check text-green-500"></i>
                  <i class="fa-solid fa-check text-green-500"></i>
                </span>
              </div>

              <span class="font-bold">{{ __("EDITED") }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

