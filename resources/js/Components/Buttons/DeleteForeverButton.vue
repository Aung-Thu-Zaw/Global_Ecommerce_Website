<script setup>
</script>

<template>
  <button
    class="text-sm px-5 py-2 border-[3px] border-red-700 font-semibold rounded-[4px] shadow-md bg-red-600 text-white transition-all hover:bg-red-700 mr-3 my-1 group"
    type="button"
  >
    <span class="group-hover:animate-pulse">
      <i class="fa-solid fa-trash-can"></i>
      {{ __("DELETE_FOREVER") }}
    </span>
  </button>
</template>

