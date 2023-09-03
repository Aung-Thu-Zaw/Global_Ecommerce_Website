<script setup>
import DropdownToolForChatMessage from "@/Components/Dropdowns/Chats/DropdownToolsForChatMessage.vue";
// import { VideoPlayer } from "@videojs-player/vue";
// import "video.js/dist/video-js.css";

defineProps({
  message: Object,
});
</script>
<template>
  <!-- Right Side  -->
  <div class="mb-5">
    <div class="flex items-end justify-end">
      <div class="flex items-center justify-end">
        <div class="pl-28">
          <div class="flex items-center justify-center">
            <!-- Dropdown  -->
            <DropdownToolForChatMessage :message="message" />

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
            <!-- <div class="flex flex-col items-center w-auto h-auto">
              <div class="flex items-center">
                <div class="relative ml-0.5">
                  <video
                    src="https://player.vimeo.com/external/587457745.sd.mp4?s=1bde705b069024acb8a38a28cc6529d76ca74416&profile_id=165&oauth2_token_id=57447761"
                    class="w-[215px] h-[162px] object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-14 left-24 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>

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
                <div class="relative w-full h-20 ml-0.5">
                  <video
                    src="https://player.vimeo.com/external/587457745.sd.mp4?s=1bde705b069024acb8a38a28cc6529d76ca74416&profile_id=165&oauth2_token_id=57447761"
                    class="w-full h-full object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-14 left-24 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
                <img
                  src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                  class="w-full h-20 object-cover border border-slate-400 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div> -->

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
