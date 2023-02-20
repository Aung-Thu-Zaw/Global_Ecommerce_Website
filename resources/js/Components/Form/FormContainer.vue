<template>
  <div
    class="
      relative
      flex flex-col
      items-center
      justify-between
      w-100
      px-10
      py-10
      bg-white
      border-2
      rounded-md
      shadow-md
      md:flex-row md:px-5 md:w-[1000px]
    "
  >
    <img
      src="../../assets/images/logo-light.png"
      alt=""
      class="hidden md:block w-1/2"
    />
    <!-- Form Start -->
    <div class="flex flex-col items-center bg-white w-full md:px-5 md:w-1/2">
      <slot />
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
