<script setup>
defineProps({
  post: Object,
});
</script>

<template>
  <div
    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 h-[420px]"
  >
    <img
      class="rounded-t-lg"
      src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cHJvZHVjdHxlbnwwfHwwfHx8MA%3D%3D&w=1000&q=80"
    />
    <div class="p-5">
      <div class="flex items-center justify-between mb-3">
        <span class="font-bold text-slate-400 text-[.7rem]">
          <i class="fa-solid fa-user mr-2"></i>
          {{ post.author.name }}
        </span>
        <span class="font-bold text-slate-400 text-[.7rem]">
          <i class="fa-solid fa-clock mr-2"></i>
          {{ post.created_at }}
        </span>
      </div>
      <h5
        class="mb-2 text-lg font-bold tracking-tight text-gray-700 dark:text-white line-clamp-2"
      >
        {{ post.title }}
      </h5>
      <p class="mb-3 font-normal text-[.8rem] text-gray-500 line-clamp-3">
        {{ post.description }}
      </p>
      <div class="w-full flex items-center justify-end">
        <a
          href="#"
          class="inline-flex items-center text-sm font-medium text-center text-slate-700 hover:text-blue-700 rounded-lg hover:animate-bounce"
        >
          Read more
          <svg
            aria-hidden="true"
            class="w-4 h-4 ml-2 -mr-1"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </a>
      </div>
    </div>
  </div>
</template>


