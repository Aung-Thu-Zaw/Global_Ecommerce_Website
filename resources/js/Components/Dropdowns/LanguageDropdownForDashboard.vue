<script setup>
import { router } from "@inertiajs/vue3";

// Handle Change Language
const handleChangeLanguage = (language) => {
  router.post(
    route("languages.change", { locale: language }),
    {},
    {
      onSuccess: () => {
        window.location.reload();
      },
    }
  );
};
</script>

<template>
  <div class="hs-dropdown relative inline-flex">
    <button
      id="hs-dropdown-custom-icon-trigger"
      type="button"
      class="hs-dropdown-toggle flex items-center whitespace-nowrap px-4 pt-2.5 pb-2 text-sm font-bold uppercase leading-normal text-white"
    >
      <i class="fa-solid fa-globe mr-1"></i>
    </button>

    <div
      class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden bg-white shadow-md rounded-lg p-2 mt-2"
      aria-labelledby="hs-dropdown-custom-icon-trigger"
    >
      <div v-for="language in $page.props.languages" :key="language.id">
        <div
          @click="handleChangeLanguage(language.short_name)"
          class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
        >
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <img
                v-if="language.short_name === 'en'"
                src="../../assets/images/united-state.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'my'"
                src="../../assets/images/myanmar.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'zh'"
                src="../../assets/images/china.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'fr'"
                src="../../assets/images/france.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'ja'"
                src="../../assets/images/japan.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'ko'"
                src="../../assets/images/south-korea.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'ar'"
                src="../../assets/images/united-arab-emirates.png"
                class="w-5 mr-2"
              />

              <img
                v-if="language.short_name === 'th'"
                src="../../assets/images/thailand.png"
                class="w-5 mr-2"
              />
              <img
                v-if="language.short_name === 'hi'"
                src="../../assets/images/india.png"
                class="w-5 mr-2"
              />

              {{ language.name }}
            </div>

            <span
              v-if="language.short_name === $page.props.locale"
              class="ml-1"
            >
              <i class="fa-solid fa-check"></i>
            </span>
            <span
              v-else-if="!$page.props.locale && language.short_name === 'en'"
              class="ml-2"
            >
              <i class="fa-solid fa-circle-check"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
