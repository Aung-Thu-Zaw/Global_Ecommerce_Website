<script setup>
import { ref } from "vue";

const isReplyFormVisible = ref(false);
</script>


<template>
  <div class="w-full flex items-center justify-end">
    <div class="w-full flex flex-col items-end">
      <button
        @click="isReplyFormVisible = !isReplyFormVisible"
        class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all mb-3"
      >
        <i class="fa-solid fa-flag"></i>
        Reply
      </button>

      <div v-if="isReplyFormVisible" class="w-full">
        <textarea
          name=""
          id=""
          cols="30"
          rows="10"
          class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
        ></textarea>
        <button
          type="submit"
          class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 mb-3"
        >
          Submit Reply
        </button>
      </div>
    </div>
  </div>
</template>


