<script setup>
import QuestionCard from "@/Components/Cards/QuestionCard.vue";
import ReplyCard from "@/Components/Cards/ReplyCard.vue";
</script>

<template>
  <div class="border border-gray-200 shadow-sm rounded bg-white">
    <h3 class="text-lg font-bold text-slate-700 border-b pb-3 mb-3 p-5">
      Ask Questions About This Product
    </h3>

    <p class="font-bold text-md text-slate-600 px-5 mb-5">
      Total Questions (6)
    </p>

    <div class="px-5">
      <div class="shadow border rounded-md p-5 flex flex-col items-start my-5">
        <div class="flex items-start">
          <QuestionCard />
        </div>
        <ReplyCard />
      </div>
    </div>

    <hr />

    <div class="p-5">
      <form>
        <textarea
          cols="30"
          rows="10"
          class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
          placeholder="Write question what you want to ask about this product"
        ></textarea>
        <button
          class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 my-5"
        >
          Ask Question
        </button>
      </form>
    </div>
  </div>
</template>
