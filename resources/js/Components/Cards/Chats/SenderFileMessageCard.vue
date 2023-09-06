<script setup>
import DropdownToolForChatMessage from "@/Components/Dropdowns/Chats/DropdownToolsForChatMessage.vue";
// import { VideoPlayer } from "@videojs-player/vue";
// import "video.js/dist/video-js.css";

defineProps({
  message: Object,
});

const filteredFilename = (attachmentPath) => {
  if (typeof attachmentPath === "string") {
    const parts = attachmentPath.split("/");

    const filename = parts[parts.length - 1];

    const sanitizedFilename = filename.replace(/^file-\d+-/, "");

    return sanitizedFilename;
  } else {
    return "";
  }
};
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
            <div
              v-if="message.chat_file_attachments.length === 1"
              class="w-auto max-w-[400px]"
            >
              <!-- Image -->
              <img
                v-if="message.chat_file_attachments[0].type === 'image'"
                :src="message.chat_file_attachments[0]?.attachment_path"
                class="h-48 object-cover border border-gray-200 rounded-[4px]"
              />

              <!-- Video -->
              <div
                v-if="message.chat_file_attachments[0].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="h-44 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>
            </div>

            <!-- For Two Image Or Video  -->
            <div
              v-else-if="message.chat_file_attachments.length === 2"
              class="flex items-center w-auto max-w-[400px]"
            >
              <!-- Images -->
              <img
                v-if="message.chat_file_attachments[0].type === 'image'"
                :src="message.chat_file_attachments[0]?.attachment_path"
                class="w-full h-32 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                v-if="message.chat_file_attachments[1].type === 'image'"
                :src="message.chat_file_attachments[1]?.attachment_path"
                class="w-full h-32 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />

              <!-- Videos -->
              <div
                v-if="message.chat_file_attachments[0].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="h-32 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>

              <div
                v-if="message.chat_file_attachments[1].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[1]?.attachment_path"
                  class="h-32 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>
            </div>

            <!-- For Three Image Or Video  -->
            <div
              v-else-if="message.chat_file_attachments.length === 3"
              class="flex flex-col items-center w-auto max-w-[400px] h-auto"
            >
              <img
                v-if="message.chat_file_attachments[0].type === 'image'"
                :src="message.chat_file_attachments[0]?.attachment_path"
                class="w-full h-40 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />

              <div
                v-if="message.chat_file_attachments[0].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="w-full h-40 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>

              <div class="flex items-center w-full">
                <img
                  v-if="message.chat_file_attachments[1].type === 'image'"
                  :src="message.chat_file_attachments[1]?.attachment_path"
                  class="w-1/2 h-24 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  v-if="message.chat_file_attachments[2].type === 'image'"
                  :src="message.chat_file_attachments[2]?.attachment_path"
                  class="w-1/2 h-24 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />

                <div
                  v-if="message.chat_file_attachments[1].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[1]?.attachment_path"
                    class="w-full h-24 object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>

                <div
                  v-if="message.chat_file_attachments[2].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[2]?.attachment_path"
                    class="w-full h-24 object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- For Four Image Or Video  -->
            <div
              v-else-if="message.chat_file_attachments.length === 4"
              class="grid grid-cols-2 gap-x-0.5 w-auto max-w-[400px] h-auto"
            >
              <img
                v-if="message.chat_file_attachments[0].type === 'image'"
                :src="message.chat_file_attachments[0]?.attachment_path"
                class="w-full h-24 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                v-if="message.chat_file_attachments[1].type === 'image'"
                :src="message.chat_file_attachments[1]?.attachment_path"
                class="w-full h-24 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                v-if="message.chat_file_attachments[2].type === 'image'"
                :src="message.chat_file_attachments[2]?.attachment_path"
                class="w-full h-24 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />
              <img
                v-if="message.chat_file_attachments[3].type === 'image'"
                :src="message.chat_file_attachments[3]?.attachment_path"
                class="w-full h-24 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
              />

              <div
                v-if="message.chat_file_attachments[0].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="w-full h-24 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>
              <div
                v-if="message.chat_file_attachments[1].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[1]?.attachment_path"
                  class="w-full h-24 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>
              <div
                v-if="message.chat_file_attachments[2].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[2]?.attachment_path"
                  class="w-full h-24 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>
              <div
                v-if="message.chat_file_attachments[3].type === 'video'"
                class="relative ml-0.5 mb-0.5"
              >
                <video
                  :src="message.chat_file_attachments[3]?.attachment_path"
                  class="w-full h-24 object-cover rounded-[4px]"
                ></video>
                <div
                  class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                >
                  <i class="fa-solid fa-play"></i>
                </div>
              </div>
            </div>

            <!-- For Five Images Or Video  -->
            <div
              v-else-if="message.chat_file_attachments.length === 5"
              class="flex items-center w-auto max-w-[400px] h-auto"
            >
              <div class="flex flex-col items-center">
                <img
                  v-if="message.chat_file_attachments[0].type === 'image'"
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="w-48 h-[136px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />

                <img
                  v-if="message.chat_file_attachments[1].type === 'image'"
                  :src="message.chat_file_attachments[1]?.attachment_path"
                  class="w-48 h-[136px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />

                <div
                  v-if="message.chat_file_attachments[0].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[0]?.attachment_path"
                    class="w-full h-[136px] object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>

                <div
                  v-if="message.chat_file_attachments[1].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[1]?.attachment_path"
                    class="w-full h-[136px] object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
              </div>
              <div class="flex flex-col items-center">
                <img
                  v-if="message.chat_file_attachments[2].type === 'image'"
                  :src="message.chat_file_attachments[2]?.attachment_path"
                  class="w-full h-[90px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  v-if="message.chat_file_attachments[3].type === 'image'"
                  :src="message.chat_file_attachments[3]?.attachment_path"
                  class="w-full h-[90px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  v-if="message.chat_file_attachments[4].type === 'image'"
                  :src="message.chat_file_attachments[4]?.attachment_path"
                  class="w-full h-[90px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />

                <div
                  v-if="message.chat_file_attachments[2].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[2]?.attachment_path"
                    class="w-full h-[90px] object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>

                <div
                  v-if="message.chat_file_attachments[3].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[3]?.attachment_path"
                    class="w-full h-[90px] object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>

                <div
                  v-if="message.chat_file_attachments[4].type === 'video'"
                  class="relative ml-0.5 mb-0.5"
                >
                  <video
                    :src="message.chat_file_attachments[4]?.attachment_path"
                    class="w-full h-[90px] object-cover rounded-[4px]"
                  ></video>
                  <div
                    class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-md text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                  >
                    <i class="fa-solid fa-play"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- For Six Images Or Video  -->
            <div
              v-else-if="message.chat_file_attachments.length === 6"
              class="flex flex-col items-centerw-auto max-w-[400px] h-auto"
            >
              <div class="flex items-center">
                <img
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="w-[215px] h-[162px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />

                <div class="flex flex-col items-center">
                  <img
                    :src="message.chat_file_attachments[1]?.attachment_path"
                    class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                  />
                  <img
                    :src="message.chat_file_attachments[2]?.attachment_path"
                    class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                  />
                </div>
              </div>
              <div class="flex items-center">
                <img
                  :src="message.chat_file_attachments[3]?.attachment_path"
                  class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  :src="message.chat_file_attachments[4]?.attachment_path"
                  class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />

                <img
                  :src="message.chat_file_attachments[5]?.attachment_path"
                  class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div>

            <!-- For Seven Image Or Video -->
            <div
              v-else-if="message.chat_file_attachments.length === 7"
              class="flex flex-col items-center w-auto max-w-[400px] h-auto"
            >
              <div class="flex items-center justify-end w-full">
                <img
                  :src="message.chat_file_attachments[0]?.attachment_path"
                  class="w-full h-[244px] object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <div class="flex flex-col items-center w-[183px]">
                  <img
                    :src="message.chat_file_attachments[1]?.attachment_path"
                    class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                  />
                  <img
                    :src="message.chat_file_attachments[2]?.attachment_path"
                    class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                  />
                  <img
                    :src="message.chat_file_attachments[3]?.attachment_path"
                    class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                  />
                </div>
              </div>
              <div class="flex items-center">
                <img
                  :src="message.chat_file_attachments[4]?.attachment_path"
                  class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  :src="message.chat_file_attachments[5]?.attachment_path"
                  class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
                <img
                  :src="message.chat_file_attachments[6]?.attachment_path"
                  class="w-full h-20 object-cover border border-gray-200 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div>

            <!-- For More than 7 Image or video  -->
            <div
              v-if="message.chat_file_attachments.length > 7"
              class="flex flex-row-reverse items-center flex-wrap w-auto max-w-[400px]"
            >
              <div v-for="file in message.chat_file_attachments" :key="file.id">
                <img
                  :src="file?.attachment_path"
                  class="h-20 object-cover border border-slate-300 rounded-[4px] ml-0.5 mb-0.5"
                />
              </div>
            </div>

            <div class="flex flex-col space-y-1 items-end">
              <div v-for="file in message.chat_file_attachments" :key="file.id">
                <div
                  v-if="file.type === 'file'"
                  class="border p-2 rounded-md flex items-center"
                >
                  <div
                    class="text-gray-700 bg-gray-200 text-sm w-8 h-8 flex items-center justify-center rounded-full border mr-2 border-slate-300"
                  >
                    <i class="fa-solid fa-file-zipper"></i>
                  </div>

                  <h4 class="font-semibold text-sm text-slate-600">
                    {{ filteredFilename(file.attachment_path) }}
                  </h4>
                </div>
              </div>
            </div>
          </div>

          <div
            class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-end space-x-4"
          >
            <span v-if="message.is_edited" class="font-bold">
              {{ __("EDITED") }}
            </span>
            <div class="flex items-center justify-end space-x-2 mr-2">
              <span class=""> {{ message.updated_at }} </span>
              <span
                v-if="message.is_read_by_user || message.is_read_by_agent"
                class="text-[.6rem] text-slate-600"
              >
                <i
                  v-if="message.is_read_by_user"
                  class="fa-solid fa-check text-green-500"
                ></i>
                <i
                  v-if="message.is_read_by_agent"
                  class="fa-solid fa-check text-green-500"
                ></i>
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





