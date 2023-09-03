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

            <!-- For One Image Or Video -->
            <!-- <div class="">
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="h-48 object-cover border border-slate-300 rounded-[4px]"
              />
            </div> -->

            <!-- For Two Image Or Video  -->
            <!-- <div class="flex flex-row-reverse items-center w-auto">
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-32 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-32 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
            </div> -->

            <!-- For Three Image Or Video  -->
            <!-- <div class="flex flex-col items-center w-auto h-auto">
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-40 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
              <div class="flex items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-24 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-24 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div> -->

            <!-- For Four Image Or Video  -->
            <!-- <div class="grid grid-cols-2 gap-x-0.5 w-auto h-auto">
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-24 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-24 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-24 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-full h-24 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
            </div> -->

            <!-- For four Images Or Video  -->
            <!-- <div class="flex items-center w-auto h-auto border">
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-56 h-[245px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
              />
              <div class="flex flex-col items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div> -->

            <!-- For Five Images Or Video  -->
            <!-- <div class="flex items-center w-auto h-auto border">
              <div class="flex flex-col items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-48 h-[136px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />

                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-48 h-[136px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
              <div class="flex flex-col items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-[90px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-[90px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-[90px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div> -->

            <!-- For Six Images Or Video  -->
            <div class="flex flex-col items-center w-auto h-auto border">
              <div class="flex items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-[215px] h-[162px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <div class="flex flex-col items-center">
                  <img
                    src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                    class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                  />
                  <img
                    src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                    class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                  />
                </div>
              </div>
              <div class="flex items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div>

            <!-- For Seven Image Or Video -->
            <!-- <div class="flex flex-col items-center w-auto h-auto border">
              <div class="flex items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-[215px] h-[244px] object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <div class="flex flex-col items-center">
                  <img
                    src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                    class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                  />
                  <img
                    src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                    class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                  />
                  <img
                    src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                    class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                  />
                </div>
              </div>
              <div class="flex items-center">
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div> -->

            <!-- For More than 7 Image or video  -->
            <!-- <div
              class="flex flex-row-reverse items-center flex-wrap max-w-[326px] w-auto"
            >
              <img
                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                class="w-30 h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
              />
            </div> -->
          </div>
          <div class="flex items-center justify-end space-x-2 mr-2 mt-1">
            <span class="text-[.6rem] text-slate-600"> 3:30 PM </span>
            <span class="text-[.6rem] text-slate-600">
              <i class="fa-solid fa-check text-green-500"></i>
              <i class="fa-solid fa-check text-green-500"></i>
            </span>
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
