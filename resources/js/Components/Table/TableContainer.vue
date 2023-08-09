<template>
  <div class="relative">
    <table
      class="text-sm text-left text-gray-500 w-auto min-w-full max-w-[2500px] border border-gray-200 shadow-md overflow-auto overflow-x-scroll scrollbar"
    >
      <slot />
    </table>
  </div>
</template>

<style>
.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
  height: 10px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
