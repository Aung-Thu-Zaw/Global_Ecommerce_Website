<script setup>
import DropdownToolsForChatConversationCard from "@/Components/Dropdowns/Chats/DropdownToolsForChatConversationCard.vue";
import { computed } from "vue";

const props = defineProps({
  liveChat: Object,
  lastMessage: Object,
});

// const lastMessage = computed(() => {
//   return
// });
</script>

<template>
  <!-- Chat Card  -->
  <div
    v-if="liveChat"
    class="border rounded-md p-3 cursor-pointer transition-all"
  >
    <div class="flex items-center">
      <div class="flex items-center w-full">
        <img
          :src="liveChat?.user?.avatar"
          class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300 mr-2"
        />
        <div class="flex flex-col items-start w-full">
          <div class="w-full flex items-center justify-between">
            <h4 class="text-sm font-semibold text-slate-700">
              {{ liveChat?.user?.name }}
            </h4>
            <div class="flex items-center justify-center space-x-2">
              <!-- Dropdown  -->
              <DropdownToolsForChatConversationCard :liveChat="liveChat" />

              <div v-if="liveChat.pinned" class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
          <!-- Send Text -->
          <div v-if="lastMessage" class="w-full flex items-center">
            <span class="text-[.6rem] w-auto mr-1 font-medium text-amber-700">
              {{ lastMessage?.user_id ? lastMessage?.user?.name : "You" }} :
            </span>

            <span
              class="text-[.7rem] text-slate-600 line-clamp-1 w-auto min-w-[100px]"
            >
              {{ lastMessage.message }}
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

  <!-- <div
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
              <DropdownToolsForChatConversationCard />

              <div class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
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
              <DropdownToolsForChatConversationCard />

              <div class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
          <div class="w-full flex items-center">
            <span class="text-[.6rem] w-auto mr-1 font-medium text-amber-700"
              >Kyaw Kyaw :
            </span>

            <span class="text-[.7rem] text-slate-600 line-clamp-1">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis
              eius cum eaque reprehenderit labore rerum possimus maiores
              perferendis iusto! Autem voluptates cumque itaque quasi totam aut
              quod veniam voluptas culpa.
            </span>
          </div>

          <div class="w-full flex items-center">
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
  </div> -->
</template>

