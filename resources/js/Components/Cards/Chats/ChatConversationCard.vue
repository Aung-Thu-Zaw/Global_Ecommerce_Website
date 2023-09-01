<script setup>
</script>

<template>
  <!-- Chat Card  -->
  <div
    class="border border-slate-200 rounded-md p-3 bg-white cursor-pointer hover:bg-gray-50 transition-all"
  >
    <div class="flex items-center">
      <div class="flex items-center w-full">
        <img
          src="https://img.freepik.com/premium-vector/female-user-profile-avatar-is-woman-character-screen-saver-with-emotions_505620-617.jpg?w=2000"
          class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300 mr-2"
        />
        <div class="flex flex-col items-start w-full">
          <div class="w-full flex items-center justify-between">
            <h4 class="text-sm font-semibold text-slate-700">Aung Thu Zaw</h4>
            <div class="flex items-center justify-center space-x-2">
              <!-- Dropdown  -->
              <div class="font-bold text-slate-600 hover:text-slate-800">
                <button
                  id="messageDropdown"
                  data-dropdown-toggle="messageDropdownDots"
                  data-dropdown-placement="left-start"
                  type="button"
                  class="p-2"
                >
                  <svg
                    class="w-3 h-3"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 16 3"
                  >
                    <path
                      d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
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
                        <i class="fa-solid fa-box-archive mr-1"></i>
                        {{ __("ARCHIVE") }}
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
                        <i class="fa-solid fa-envelope-circle-check mr-1"></i>
                        {{ __("MARK_AS_READ") }}
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-eye mr-1"></i>
                        {{ __("VIEW_CHAT") }}
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-folder-plus mr-1"></i>
                        {{ __("ADD_TO_FOLDER") }}
                      </a>
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-broom mr-1"></i>
                        {{ __("CLEAR_HISTORY") }}</a
                      >
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-trash-can mr-1"></i>
                        {{ __("DELETE_CHAT") }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
          <!-- Send Text -->
          <div class="w-full flex items-center">
            <span class="text-[.6rem] w-auto mr-1 font-medium text-amber-700"
              >Kyaw Kyaw :
            </span>

            <span class="text-[.7rem] text-slate-600 line-clamp-1 w-[200px]">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis
              eius cum eaque reprehenderit labore rerum possimus maiores
              perferendis iusto! Autem voluptates cumque itaque quasi totam aut
              quod veniam voluptas culpa.
            </span>
          </div>

          <!-- Send Photo -->
          <!-- <div class="w-full flex items-center">
                          <div class="flex items-center">
       <span
                            class="text-[.6rem] w-auto mr-1 font-medium text-blue-700"
                            >Kyaw Kyaw :
                          </span>

                            <div class="flex items-center">
                              <div class="flex items-center space-x-1 mr-2">
                                <img
                                  src="https://images.pexels.com/photos/268533/pexels-photo-268533.jpeg?cs=srgb&dl=pexels-pixabay-268533.jpg&fm=jpg"
                                  class="w-4 h-4 rounded-sm"
                                />
                                <img
                                  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRF9FZDLvWxBsWD3FXuCjKLhGhoOSyWDwYfz1jjFfILSDHEtepu7DmmaEkJOFcemzVbW3I&usqp=CAU"
                                  class="w-4 h-4 rounded-sm"
                                />
                                <img
                                  src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5-6gLvgyk2VWlrZMNnsGiVBs9U_CVqxawL-mPoXP3U1pMWbw1niyt7HELrqua30phg-g&usqp=CAU"
                                  class="w-4 h-4 rounded-sm"
                                />
                              </div>
                              <span class="text-[.7rem] text-slate-600">
                                3 photos
                              </span>
                            </div>
                          </div>
                        </div> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Chat Card  -->

  <div
    class="border border-slate-200 rounded-md p-3 bg-white cursor-pointer hover:bg-gray-50 transition-all"
  >
    <div class="flex items-center">
      <div class="flex items-center w-full">
        <img
          src="https://img.freepik.com/premium-vector/female-user-profile-avatar-is-woman-character-screen-saver-with-emotions_505620-617.jpg?w=2000"
          class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300 mr-2"
        />
        <div class="flex flex-col items-start w-full">
          <div class="w-full flex items-center justify-between">
            <h4 class="text-sm font-semibold text-slate-700">Aung Thu Zaw</h4>
            <div class="flex items-center justify-center space-x-2">
              <!-- Dropdown  -->
              <div class="font-bold text-slate-600 hover:text-slate-800">
                <button
                  id="messageDropdown"
                  data-dropdown-toggle="messageDropdownDots"
                  data-dropdown-placement="left-start"
                  type="button"
                  class="p-2"
                >
                  <svg
                    class="w-3 h-3"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 16 3"
                  >
                    <path
                      d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
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
                        <i class="fa-solid fa-box-archive mr-1"></i>
                        {{ __("ARCHIVE") }}
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
                        <i class="fa-solid fa-envelope-circle-check mr-1"></i>
                        {{ __("MARK_AS_READ") }}
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-eye mr-1"></i>
                        {{ __("VIEW_CHAT") }}
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-folder-plus mr-1"></i>
                        {{ __("ADD_TO_FOLDER") }}
                      </a>
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-broom mr-1"></i>
                        {{ __("CLEAR_HISTORY") }}</a
                      >
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-trash-can mr-1"></i>
                        {{ __("DELETE_CHAT") }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
          <!-- Send Text -->
          <div class="flex items-center w-full">
            <div class="w-full flex items-center">
              <span class="text-[.6rem] w-auto mr-1 font-medium text-amber-700"
                >Myo Zaw :
              </span>

              <span class="text-[.7rem] text-slate-600 line-clamp-1 w-[200px]">
                send 4 videos
              </span>
            </div>

            <div
              class="ml-auto rounded-full bg-blue-600 w-4 h-4 flex items-center justify-center"
            >
              <span class="text-[.6rem] font-medium text-white mb-0"> 5 </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Chat Card  -->
  <div
    class="border border-slate-400 shadow-md rounded-md p-3 bg-gray-50 cursor-pointer"
  >
    <div class="flex items-center">
      <div class="flex items-center w-full">
        <img
          src="https://img.freepik.com/premium-vector/female-user-profile-avatar-is-woman-character-screen-saver-with-emotions_505620-617.jpg?w=2000"
          class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300 mr-2"
        />
        <div class="flex flex-col items-start w-full">
          <div class="w-full flex items-center justify-between">
            <h4 class="text-sm font-semibold text-slate-700">Aung Thu Zaw</h4>
            <div class="flex items-center justify-center space-x-2">
              <!-- Dropdown  -->
              <div class="font-bold text-slate-600 hover:text-slate-800">
                <button
                  id="messageDropdown"
                  data-dropdown-toggle="messageDropdownDots"
                  data-dropdown-placement="left-start"
                  type="button"
                  class="p-2"
                >
                  <svg
                    class="w-3 h-3"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 16 3"
                  >
                    <path
                      d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"
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
                        <i class="fa-solid fa-box-archive mr-1"></i>
                        {{ __("ARCHIVE") }}
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
                        <i class="fa-solid fa-envelope-circle-check mr-1"></i>
                        {{ __("MARK_AS_READ") }}
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-eye mr-1"></i>
                        {{ __("VIEW_CHAT") }}
                      </a>
                    </li>
                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-folder-plus mr-1"></i>
                        {{ __("ADD_TO_FOLDER") }}
                      </a>
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-broom mr-1"></i>
                        {{ __("CLEAR_HISTORY") }}</a
                      >
                    </li>

                    <li>
                      <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                        <i class="fa-solid fa-trash-can mr-1"></i>
                        {{ __("DELETE_CHAT") }}
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
          <!-- Send Text -->
          <!-- <div class="w-full flex items-center">
                          <span
                            class="text-[.6rem] w-auto mr-1 font-medium text-amber-700"
                            >Kyaw Kyaw :
                          </span>

                          <span
                            class="text-[.7rem] text-slate-600 line-clamp-1"
                          >
                            Lorem ipsum, dolor sit amet consectetur adipisicing
                            elit. Corporis eius cum eaque reprehenderit labore
                            rerum possimus maiores perferendis iusto! Autem
                            voluptates cumque itaque quasi totam aut quod veniam
                            voluptas culpa.
                          </span>
                        </div> -->

          <!-- Send Photo -->
          <div class="w-full flex items-center">
            <!-- <div class="flex items-center justify-between">

                            </div> -->
            <div class="flex items-center">
              <span class="text-[.6rem] w-auto mr-1 font-medium text-blue-700"
                >You :
              </span>

              <div class="flex items-center w-[200px]">
                <div class="flex items-center space-x-1 mr-2">
                  <img
                    src="https://images.pexels.com/photos/268533/pexels-photo-268533.jpeg?cs=srgb&dl=pexels-pixabay-268533.jpg&fm=jpg"
                    class="w-3 h-3 rounded-sm"
                  />
                  <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRF9FZDLvWxBsWD3FXuCjKLhGhoOSyWDwYfz1jjFfILSDHEtepu7DmmaEkJOFcemzVbW3I&usqp=CAU"
                    class="w-3 h-3 rounded-sm"
                  />
                  <img
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5-6gLvgyk2VWlrZMNnsGiVBs9U_CVqxawL-mPoXP3U1pMWbw1niyt7HELrqua30phg-g&usqp=CAU"
                    class="w-3 h-3 rounded-sm"
                  />
                </div>
                <span class="text-[.7rem] text-slate-600"> 3 photos </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

