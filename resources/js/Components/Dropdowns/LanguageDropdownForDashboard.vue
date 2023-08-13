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
  <div class="flex justify-center mx-2">
    <div>
      <div class="relative" data-te-dropdown-ref>
        <button
          class="flex items-center whitespace-nowrap px-4 pt-2.5 pb-2 text-sm font-bold uppercase leading-normal text-white"
          type="button"
          id="dropdownMenuButton2"
          data-te-dropdown-toggle-ref
          aria-expanded="false"
        >
          <i class="fa-solid fa-globe mr-1"></i>
        </button>
        <ul
          class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg [&[data-te-dropdown-show]]:block"
          aria-labelledby="dropdownMenuButton2"
          data-te-dropdown-menu-ref
        >
          <li v-for="language in $page.props.languages" :key="language.id">
            <div
              @click="handleChangeLanguage(language.short_name)"
              class="block w-full whitespace-nowrap bg-transparent py-2 px-5 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 cursor-pointer"
              data-te-dropdown-item-ref
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
                  v-else-if="
                    !$page.props.locale && language.short_name === 'en'
                  "
                  class="ml-1"
                >
                  <i class="fa-solid fa-check"></i>
                </span>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>
