<script setup>
defineProps({
  conversation: Object,
});
</script>

<template>
  <!-- For Vendor  -->
  <div class="border-2 rounded-md shadow-md">
    <div class="py-3 flex items-start px-3">
      <img
        :src="conversation.customer.avatar"
        alt=""
        class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
      />
      <div>
        <div class="flex items-start justify-between">
          <h1
            class="flex items-center text-left text-sm font-semibold text-slate-700 w-[100px]"
          >
            <span class="line-clamp-1">
              {{ conversation.customer.name }}
            </span>
          </h1>
          <span class="text-[.7rem] text-slate-500"> 2 minutes ago </span>
        </div>
        <div class="flex items-center justify-between">
          <p class="text-[.7rem] line-clamp-1 text-slate-600 w-[90%]">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis
            explicabo, facere, impedit ullam culpa numquam veritatis corrupti,
            vel quos labore nulla. Dicta dolores, harum dolorem modi eius ullam
            nesciunt reprehenderit?
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
</template>


