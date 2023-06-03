<template>
  <div
    class="relative flex flex-col items-center md:min-h-[500px] justify-between w-100 px-10 py-10 bg-white border-2 rounded-md shadow-md md:flex-row md:px-5 md:w-[1000px]"
  >
    <img
      v-if="$page.url === '/login' || $page.url === '/register'"
      src="../../assets/images/user-login.jpg"
      alt=""
      class="hidden md:block w-1/2"
    />
    <img
      v-if="$page.url === '/vendor/login' || $page.url === '/vendor/register'"
      src="../../assets/images/vendor-login.jpg"
      alt=""
      class="hidden md:block w-1/2"
    />
    <img
      v-if="$page.url === '/admin/login'"
      src="../../assets/images/admin-login.jpg"
      alt=""
      class="hidden md:block w-1/2"
    />
    <!-- Form Start -->
    <div class="flex flex-col items-center bg-white w-full md:px-5 md:w-1/2">
      <slot />
    </div>
  </div>
</template>

<script setup>
</script>

<style>
</style>
