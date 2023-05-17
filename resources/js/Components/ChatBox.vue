<script setup>
</script>


<template>
  <div
    class="fixed z-40 bottom-0 right-14 w-[900px] h-[700px] rounded-tl-md border-2 border-r-0 shadow-sm bg-gray-50 chat-box"
  >
    <div class="flex items-center h-full">
      <div class="w-1/2 h-full">
        <h1
          class="text-center text-lg font-semibold text-slate-700 border-b py-[18px]"
        >
          <i class="fa-solid fa-message"></i>
          Messages
        </h1>
        <div class="p-2 space-y-1 h-[630px] overflow-auto">
          <!-- card  -->
          <div class="border-2 rounded-md shadow-md">
            <div class="py-3 flex items-start px-3">
              <img
                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqQboRrVxPyj4MM46ay8dav--CBtWFR4sT3z2YF5E&s"
                alt=""
                class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
              />
              <div>
                <div class="flex items-start justify-between">
                  <h1
                    class="flex items-center text-left text-sm font-semibold text-slate-700 w-[100px]"
                  >
                    <span class="line-clamp-1">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                      Magnam est in eaque obcaecati non officiis ut atque soluta
                      repellat voluptates distinctio expedita ipsam magni
                      laboriosam quia dignissimos eum, quaerat dicta.
                    </span>
                    <span class="text-green-500 text-[.7rem] font-bold">
                      <i class="fa-solid fa-circle-check"></i>
                    </span>
                  </h1>
                  <span class="text-[.7rem] text-slate-500"
                    >2 minutes ago
                  </span>
                </div>
                <div class="flex items-center justify-between">
                  <p class="text-[.7rem] line-clamp-1 text-slate-600 w-[90%]">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Perferendis explicabo, facere, impedit ullam culpa numquam
                    veritatis corrupti, vel quos labore nulla. Dicta dolores,
                    harum dolorem modi eius ullam nesciunt reprehenderit?
                  </p>
                  <p class="w-[10%] flex items-center justify-center">
                    <span
                      class="text-[.6rem] rounded-full px-1.5 py-0.5 bg-blue-600 text-white flex items-center justify-center"
                    >
                      2
                    </span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="border-l border-r w-full h-full">
        <div
          class="border-b-2 border-b-slate-300 shadow-md py-3 flex items-center px-3 mb-5"
        >
          <img
            src="https://images.samsung.com/is/image/samsung/assets/samsung-and-you/SamsungAndYouBlackBanner.png?$FB_TYPE_B_PNG$"
            alt=""
            class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
          />
          <h1 class="text-left text-lg font-semibold text-slate-700">
            Samsung
          </h1>
        </div>

        <div class="overflow-auto w-full h-[570px]">
          <div class="w-full h-full px-3">
            <!-- left text  -->
            <div class="mb-2">
              <p class="text-center text-sm text-slate-500 font-bold mb-2">
                22-May-2023 ( 3 minutes ago )
              </p>
              <div class="flex items-end">
                <img
                  src="https://images.samsung.com/is/image/samsung/assets/samsung-and-you/SamsungAndYouBlackBanner.png?$FB_TYPE_B_PNG$"
                  alt=""
                  class="w-8 h-8 object-cover rounded-full ring-2 ring-blue-400 mr-3"
                />

                <div class="flex items-end mb-3">
                  <div
                    class="p-3 border-2 border-slate-300 rounded-lg rounded-bl-none shadow-md w-[80%]"
                  >
                    <p class="">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                      Ipsum similique id enim incidunt illo labore, cumque
                      tempore fuga asperiores, blanditiis commodi earum saepe.
                      Corporis consequatur tempora similique labore qui quam!
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <!-- right text  -->
            <div class="mb-2">
              <p class="text-center text-sm text-slate-500 font-bold mb-2">
                22-May-2023 ( 3 minutes ago )
              </p>
              <div class="flex items-end">
                <div class="flex items-center justify-end mb-3">
                  <div
                    class="p-3 border-2 border-slate-300 rounded-lg rounded-br-none shadow-md w-[80%]"
                  >
                    <p class="">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                      Ipsum similique id enim incidunt illo labore, cumque
                      tempore fuga asperiores, blanditiis commodi earum saepe.
                      Corporis consequatur tempora similique labore qui quam!
                    </p>
                  </div>
                </div>
                <img
                  src="https://images.samsung.com/is/image/samsung/assets/samsung-and-you/SamsungAndYouBlackBanner.png?$FB_TYPE_B_PNG$"
                  alt=""
                  class="w-8 h-8 object-cover rounded-full ring-2 ring-blue-400 ml-3"
                />
              </div>
            </div>
          </div>

          <div
            class="w-[599px] overflow-hidden fixed bottom-0 border-t-2 border-t-slate-300 py-3 bg-slate-100"
          >
            <form action="" class="w-full flex items-center justify-end px-5">
              <div class="mr-5">
                <label
                  for="fileInput"
                  class="inline-block cursor-pointer bg-slate-400 text-white hover:bg-slate-600 rounded-full px-3 py-2"
                >
                  <i class="fa-solid fa-paperclip"></i>
                </label>
                <input id="fileInput" type="file" class="hidden" />
              </div>
              <div
                class="border-2 border-slate-400 w-[95%] flex items-center justify-between rounded-full px-4 bg-gray-50"
              >
                <input
                  type="text"
                  class="border-0 bg-gray-50 focus:ring-0 focus:border-0 w-full"
                />
                <button class="px-3 py-2 text-slate-600">
                  <i class="fa-solid fa-paper-plane"></i>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.chat-box {
    box-shadow: -5px 0px 8px 0px #3737377f;
}
</style>
