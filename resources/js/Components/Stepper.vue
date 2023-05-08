<script setup>
defineProps({
  order: Object,
});
</script>

<template>
  <div class="w-full border mt-5 shadow rounded-sm px-10 py-5">
    <ol class="flex items-center justify-center mx-auto">
      <li
        class="flex w-full items-center dark:text-blue-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-4 after:inline-block dark:after:border-blue-800"
        :class="{
          'text-blue-600 after:border-blue-100':
            order.status === 'pending' ||
            order.status === 'confirm' ||
            order.status === 'processing' ||
            order.status === 'shipped' ||
            order.status === 'delivered',

          'text-gray-500 after:border-gray-100':
            order.status !== 'pending' &&
            order.status !== 'confirm' &&
            order.status !== 'processing' &&
            order.status !== 'shipped' &&
            order.status !== 'delivered',
        }"
      >
        <span
          class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 dark:bg-blue-800 shrink-0"
          :class="{
            'bg-blue-100':
              order.status === 'pending' ||
              order.status === 'confirm' ||
              order.status === 'processing' ||
              order.status === 'shipped' ||
              order.status === 'delivered',
            'bg-gray-100':
              order.status !== 'pending' &&
              order.status !== 'confirm' &&
              order.status !== 'processing' &&
              order.status !== 'shipped' &&
              order.status !== 'delivered',
          }"
        >
          <i class="fas fa-spinner animate-spin"></i>
        </span>
      </li>
      <li
        class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-4 after:inline-block dark:after:border-gray-700"
        :class="{
          'text-blue-600 after:border-blue-100':
            order.status === 'confirm' ||
            order.status === 'processing' ||
            order.status === 'shipped' ||
            order.status === 'delivered',

          'text-gray-500 after:border-gray-100':
            order.status !== 'confirm' &&
            order.status !== 'processing' &&
            order.status !== 'shipped' &&
            order.status !== 'delivered',
        }"
      >
        <span
          class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
          :class="{
            'bg-blue-100':
              order.status === 'confirm' ||
              order.status === 'processing' ||
              order.status === 'shipped' ||
              order.status === 'delivered',
            'bg-gray-100':
              order.status !== 'confirm' &&
              order.status !== 'processing' &&
              order.status !== 'shipped' &&
              order.status !== 'delivered',
          }"
        >
          <i class="fa-solid fa-clipboard-check animate-pulse"></i>
        </span>
      </li>

      <li
        class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-4 after:inline-block dark:after:border-gray-700"
        :class="{
          'text-blue-600 after:border-blue-100':
            order.status === 'processing' ||
            order.status === 'shipped' ||
            order.status === 'delivered',

          'text-gray-500 after:border-gray-100':
            order.status !== 'processing' &&
            order.status !== 'shipped' &&
            order.status !== 'delivered',
        }"
      >
        <span
          class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
          :class="{
            'bg-blue-100':
              order.status === 'processing' ||
              order.status === 'shipped' ||
              order.status === 'delivered',
            'bg-gray-100':
              order.status !== 'processing' &&
              order.status !== 'shipped' &&
              order.status !== 'delivered',
          }"
        >
          <i class="fa-solid fa-rotate animate-spin"></i>
        </span>
      </li>

      <li
        class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-4 after:inline-block dark:after:border-gray-700"
        :class="{
          'text-blue-600 after:border-blue-100':
            order.status === 'shipped' || order.status === 'delivered',

          'text-gray-500 after:border-gray-100':
            order.status !== 'shipped' && order.status !== 'delivered',
        }"
      >
        <span
          class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
          :class="{
            'bg-blue-100':
              order.status === 'shipped' || order.status === 'delivered',
            'bg-gray-100':
              order.status !== 'shipped' && order.status !== 'delivered',
          }"
        >
          <i class="fa-solid fa-truck-fast animate-pulse"></i>
        </span>
      </li>

      <li
        class="flex items-center"
        :class="{
          'text-blue-600 ': order.status === 'delivered',
          'text-gray-500 ': order.status !== 'delivered',
        }"
      >
        <span
          class="flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 dark:bg-gray-700 shrink-0"
          :class="{
            'bg-blue-100': order.status === 'delivered',
            'bg-gray-100': order.status !== 'delivered',
          }"
        >
          <i class="fa-solid fa-box-archive animate-pulse"></i>
        </span>
      </li>
    </ol>
    <div class="flex items-center justify-between mt-3 font-bold text-sm">
      <span
        :class="{
          'text-blue-500':
            order.status === 'pending' ||
            order.status === 'confirm' ||
            order.status === 'processing' ||
            order.status === 'shipped' ||
            order.status === 'delivered',
          'text-gray-500':
            order.status !== 'pending' &&
            order.status !== 'confirm' &&
            order.status !== 'processing' &&
            order.status !== 'shipped' &&
            order.status !== 'delivered',
        }"
      >
        Pending
      </span>
      <span
        :class="{
          'text-blue-500':
            order.status === 'confirm' ||
            order.status === 'processing' ||
            order.status === 'shipped' ||
            order.status === 'delivered',
          'text-gray-500':
            order.status !== 'confirm' &&
            order.status !== 'processing' &&
            order.status !== 'shipped' &&
            order.status === 'delivered',
        }"
      >
        Confirmed
      </span>
      <span
        :class="{
          'text-blue-500':
            order.status === 'processing' ||
            order.status === 'shipped' ||
            order.status === 'delivered',
          'text-gray-500':
            order.status !== 'processing' &&
            order.status !== 'shipped' &&
            order.status === 'delivered',
        }"
      >
        Processing
      </span>
      <span
        :class="{
          'text-blue-500':
            order.status === 'shipped' || order.status === 'delivered',
          'text-gray-500':
            order.status !== 'shipped' && order.status !== 'delivered',
        }"
      >
        Shipped
      </span>
      <span
        :class="{
          'text-blue-500': order.status === 'delivered',
          'text-gray-500': order.status !== 'delivered',
        }"
      >
        Delivered
      </span>
    </div>
  </div>
</template>
