<script setup>
import { Head } from "@inertiajs/vue3";
</script>


<template>
  <Head title="Support Service Live Chat" />

  <div class="w-full min-h-screen background flex items-center justify-center">
    <div
      class="w-[1000px] h-auto border border-slate-300 shadow-lg rounded-md overflow-hidden"
    >
      <div class="min-w-full">
        <!-- Header -->
        <div
          class="w-full border-b shadow bg-white px-5 py-3 flex items-center"
        >
          <div class="mr-3">
            <img
              src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
              class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300"
            />
          </div>
          <div>
            <div class="flex items-center space-x-3">
              <h3 class="text-slate-700 font-bold text-md">Aung Thu Zaw</h3>
              <span
                class="text-xs font-medium bg-blue-200 text-blue-700 px-2 py-0.5 rounded-full"
              >
                Service Agent
              </span>
            </div>

            <!-- Online Status -->
            <!-- <div
              class="flex items-center text-green-500 animate-pulse space-x-1"
            >
              <i class="fa-solid fa-circle text-[.5rem]"></i>
              <span class="text-xs font-bold">Online</span>
            </div> -->

            <!-- Offline Status -->
            <!-- <div class="flex items-center text-red-500 space-x-1">
              <i class="fa-solid fa-circle text-[.5rem]"></i>
              <span class="text-xs font-bold">Offline</span>
            </div> -->

            <!-- Busy Status -->
            <div class="flex items-center text-amber-500 space-x-1">
              <i class="fa-solid fa-circle text-[.5rem]"></i>
              <span class="text-xs font-bold">Busy</span>
            </div>
          </div>
        </div>

        <!-- Message -->
        <div class="bg-white">
          <div class="h-[600px] overflow-auto scrollbar">
            <div class="p-5 h-[800px]">
              <!-- Right Side  -->
              <div class="mb-2">
                <p class="text-center text-sm text-slate-500 font-bold mb-5">
                  22-April-2023 ( Monday )
                </p>
                <div class="flex items-end justify-end">
                  <div class="flex items-center justify-end">
                    <div class="pl-28">
                      <p
                        class="p-3 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
                      >
                        Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit. Voluptates hic soluta repudiandae sit cumque velit
                        ratione nam fugiat magnam blanditiis. Debitis, culpa ex
                        dolores repellendus corporis nemo at quibusdam. Sequi!
                      </p>
                      <div
                        class="flex items-center justify-end space-x-2 mr-2 mt-1"
                      >
                        <span class="text-[.6rem] text-slate-600">
                          3:30 PM
                        </span>
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

              <!-- left Side -->
              <div class="mb-2">
                <div>
                  <!-- <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Sunday )
                  </p> -->
                  <div class="flex items-end">
                    <img
                      src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
                    />

                    <div class="flex items-end justify-start w-full">
                      <div class="pr-28">
                        <p
                          class="p-3 border-2 border-slate-300 rounded-xl rounded-bl-none shadow-md w-auto max-w-[500px] text-sm"
                        >
                          Lorem ipsum dolor sit amet, consectetur adipisicing
                          elit. Voluptates hic soluta repudiandae sit cumque
                          velit ratione nam fugiat magnam blanditiis. Debitis,
                          culpa ex dolores repellendus corporis nemo at
                          quibusdam. Sequi!
                        </p>
                        <div
                          class="flex items-center justify-start space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:50 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Side  -->
              <div class="mb-2">
                <p class="text-center text-sm text-slate-500 font-bold mb-5">
                  22-April-2023 ( Monday )
                </p>
                <div class="flex items-end justify-end">
                  <div class="flex items-center justify-end">
                    <div class="pl-28">
                      <div class="grid grid-cols-1">
                        <img
                          src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                          class="h-48 object-cover border border-slate-300 rounded-sm"
                        />
                      </div>
                      <div
                        class="flex items-center justify-end space-x-2 mr-2 mt-1"
                      >
                        <span class="text-[.6rem] text-slate-600">
                          3:30 PM
                        </span>
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

              <!-- Right Side  -->
              <div class="mb-2">
                <p class="text-center text-sm text-slate-500 font-bold mb-5">
                  22-April-2023 ( Monday )
                </p>
                <div class="flex items-end justify-end">
                  <div class="flex items-center justify-end">
                    <div class="pl-28">
                      <div class="grid grid-cols-2 gap-0.5">
                        <img
                          src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                          class="h-28 object-cover border border-slate-300 rounded-sm"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                          class="h-28 object-cover border border-slate-300 rounded-sm"
                        />
                      </div>
                      <div
                        class="flex items-center justify-end space-x-2 mr-2 mt-1"
                      >
                        <span class="text-[.6rem] text-slate-600">
                          3:30 PM
                        </span>
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

              <!-- left Side -->
              <div class="mb-2">
                <div>
                  <!-- <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Sunday )
                  </p> -->
                  <div class="flex items-end">
                    <img
                      src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
                    />

                    <div class="flex items-end justify-start w-full">
                      <div class="pr-28">
                        <div class="grid grid-cols-2 gap-0.5">
                          <img
                            src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                            class="h-28 object-cover border border-slate-300 rounded-sm"
                          />
                          <img
                            src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                            class="h-28 object-cover border border-slate-300 rounded-sm"
                          />
                        </div>
                        <div
                          class="flex items-center justify-start space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:50 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Side  -->
              <div class="mb-2">
                <p class="text-center text-sm text-slate-500 font-bold mb-5">
                  22-April-2023 ( Monday )
                </p>
                <div class="flex items-end justify-end">
                  <div class="flex items-center justify-end">
                    <div class="pl-28 w-[500px]">
                      <div class="flex flex-row-reverse items-center flex-wrap">
                        <img
                          src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                        <img
                          src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                          class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                        />
                      </div>
                      <div
                        class="flex items-center justify-end space-x-2 mr-2 mt-1"
                      >
                        <span class="text-[.6rem] text-slate-600">
                          3:30 PM
                        </span>
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

              <!-- Right Side  -->
              <div class="mb-2">
                <p class="text-center text-sm text-slate-500 font-bold mb-5">
                  22-April-2023 ( Monday )
                </p>
                <div class="flex items-end justify-end">
                  <div class="flex items-center justify-end">
                    <div class="pl-28">
                      <p
                        class="p-3 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
                      >
                        Lorem ipsum dolor sit amet.
                      </p>
                      <div
                        class="flex items-center justify-end space-x-2 mr-2 mt-1"
                      >
                        <span class="text-[.6rem] text-slate-600">
                          3:30 PM
                        </span>
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
              <!-- Right Side  -->
              <div class="mb-2">
                <p class="text-center text-sm text-slate-500 font-bold mb-5">
                  22-April-2023 ( Monday )
                </p>
                <div class="flex items-end justify-end">
                  <div class="flex items-center justify-end">
                    <div class="pl-28">
                      <p
                        class="p-3 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
                      >
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Quae aspernatur voluptatum beatae libero ex vero
                        quisquam sequi nam, cupiditate eaque.
                      </p>
                      <div
                        class="flex items-center justify-end space-x-2 mr-2 mt-1"
                      >
                        <span class="text-[.6rem] text-slate-600">
                          3:30 PM
                        </span>
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
            </div>
          </div>
        </div>

        <!-- Footer Input Form -->
        <div class="w-full bg-white border-t shadow px-5 py-3">
          <form
            class="bg-slate-100 rounded-full w-full flex items-center justify-between py-0.5 px-5 pr-10 space-x-3"
          >
            <div class="flex items-center space-x-3">
              <span class="text-gray-600 hover:text-gray-700">
                <i class="fa-solid fa-face-smile"></i>
              </span>
              <span class="text-gray-600 hover:text-gray-700">
                <i class="fa-solid fa-image"></i>
              </span>
            </div>
            <div class="w-full">
              <input
                type="text"
                class="bg-transparent w-full border-none focus:ring-0 text-sm text-slate-700 py-2.5"
                placeholder="Type a message"
              />
            </div>
            <div>
              <button class="text-gray-400 hover:text-gray-700">
                <i class="fa-solid fa-paper-plane"></i>
              </button>
            </div>
          </form>
        </div>
        <!-- Footer Input Form -->
        <div class="w-full bg-white border-t shadow px-5 py-3">
          <form
            class="bg-slate-100 rounded-full w-full flex items-center justify-between py-0.5 px-5 pr-10 space-x-3"
          >
            <div class="flex items-center space-x-3">
              <span class="text-gray-600 hover:text-gray-700">
                <i class="fa-solid fa-face-smile"></i>
              </span>
              <span class="text-gray-600 hover:text-gray-700">
                <i class="fa-solid fa-image"></i>
              </span>
            </div>
            <div class="w-full">
              <input
                type="text"
                class="bg-transparent w-full border-none focus:ring-0 text-sm text-slate-700 py-2.5"
                placeholder="Type a message"
              />
            </div>
            <div>
              <button class="text-gray-400 hover:text-gray-700">
                <i class="fa-solid fa-paper-plane"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>


<style>
.background {
  background-image: url("https://cdn.dribbble.com/users/1003944/screenshots/15741863/06_comp_1_4x.gif?resize=400x300&vertical=center");
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  background-color: rgba(0, 0, 0, 0.037);
  background-blend-mode: darken;
}

.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
