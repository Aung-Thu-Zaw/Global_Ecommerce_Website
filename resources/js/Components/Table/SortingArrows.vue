<script setup>
defineProps({
  params: Object,
  sort: String,
});
</script>

<template>
  <i
    class="fa-sharp fa-solid fa-arrow-up arrow-icon"
    :class="{
      'text-blue-600': params.direction === 'asc' && params.sort === sort,
      'visually-hidden':
        params.direction !== '' &&
        params.direction !== 'asc' &&
        params.sort === sort,
    }"
  ></i>
  <i
    class="fa-sharp fa-solid fa-arrow-down arrow-icon"
    :class="{
      'text-blue-600': params.direction === 'desc' && params.sort === sort,
      'visually-hidden':
        params.direction !== '' &&
        params.direction !== 'desc' &&
        params.sort === sort,
    }"
  ></i>
</template>

