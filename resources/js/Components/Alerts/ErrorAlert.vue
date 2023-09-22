<script setup>
</script>

<template>
  <div
    id="error-alert"
    class="flex items-center justify-center p-4 text-red-800 border-red-300 bg-red-100 dark:text-red-400"
    role="alert"
  >
    <i class="fa-solid fa-triangle-exclamation"></i>
    <div class="ml-3 text-sm font-medium">
      {{ $page.props.flash.errorMessage }}
    </div>
  </div>
</template>

