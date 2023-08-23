<script setup></script>

<template>
  <div>
    <button
      data-popover-target="share"
      data-popover-placement="left"
      type="button"
      class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
    >
      <i class="fa-solid fa-share-nodes"></i>
    </button>
    <div
      data-popover
      id="share"
      role="tooltip"
      class="absolute invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[170px] text-left"
    >
      <div class="px-3 font-bold py-1 text-blue-600">
        <a
          :href="$page.props.socialShares?.facebook"
          target="_blank"
          data-tooltip-target="facebook"
          data-tooltip-placement="top"
        >
          <i class="fa-brands fa-facebook mr-3 text-xl"></i>
          Facebook
        </a>
        <div
          id="facebook"
          role="tooltip"
          class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
        >
          Share on facebook
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
      <div class="px-3 font-bold py-1 text-sky-600">
        <a
          :href="$page.props.socialShares?.twitter"
          target="_blank"
          data-tooltip-target="twitter"
          data-tooltip-placement="top"
        >
          <i class="fa-brands fa-twitter mr-3 text-xl"></i>
          Twitter
        </a>
        <div
          id="twitter"
          role="tooltip"
          class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
        >
          Share on twitter
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <div class="px-3 font-bold py-1 text-blue-800">
        <a
          :href="$page.props.socialShares?.linkedin"
          target="_blank"
          data-tooltip-target="linkedin"
          data-tooltip-placement="top"
        >
          <i class="fa-brands fa-linkedin mr-3 text-xl"></i>
          Linked In
        </a>
        <div
          id="linkedin"
          role="tooltip"
          class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
        >
          Share on LinkedIn
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
      <div data-popper-arrow></div>
      <div class="px-3 font-bold py-1 text-orange-500">
        <a
          :href="$page.props.socialShares?.reddit"
          target="_blank"
          data-tooltip-target="reddit"
          data-tooltip-placement="top"
        >
          <i class="fa-brands fa-reddit mr-3 text-xl"></i>
          Reddit
        </a>
        <div
          id="reddit"
          role="tooltip"
          class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
        >
          Share on reddit
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
      <div class="px-3 font-bold py-1 text-blue-500">
        <a
          :href="$page.props.socialShares?.telegram"
          target="_blank"
          data-tooltip-target="telegram"
          data-tooltip-placement="top"
        >
          <i class="fa-brands fa-telegram mr-3 text-xl"></i>
          Telegram
        </a>
        <div
          id="telegram"
          role="tooltip"
          class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
        >
          Share on telegram
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
      <div class="px-3 font-bold py-1 text-emerald-600">
        <a
          :href="$page.props.socialShares?.whatsapp"
          target="_blank"
          data-tooltip-target="whatsapp"
          data-tooltip-placement="top"
        >
          <i class="fa-brands fa-whatsapp mr-3 text-xl"></i>
          Whatsapp
        </a>
        <div
          id="whatsapp"
          role="tooltip"
          class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
        >
          Share on whatsapp
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
    </div>
  </div>
</template>
