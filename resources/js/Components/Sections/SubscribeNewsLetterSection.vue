<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { router, useForm } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  socialMedia: Object,
});

// Handle Form And Submit
const form = useForm({
  email: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleSubscribe = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_subscriber");

  form.post(route("subscribe.store"), {
    preserveScroll: true,
    onFinish: () => (form.email = ""),
  });
};

// Handle Social Traffic
const openLink = (socialLink) => {
  window.open(socialLink, "_blank");
};

const handleTrafficIncrement = (id, socialLink) => {
  router.post(
    route("admin.social-traffics.increment.visitors", id),
    {},
    {
      onSuccess: () => {
        openLink(socialLink);
      },
    }
  );
};
</script>

<template>
  <section class="bg-gray-100 border-t py-6">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div
        class="flex items-center flex-col lg:flex-row space-y-7 lg:space-y-0"
      >
        <div class="flex items-center mr-10">
          <div
            class="flex mr-5 items-center justify-center rounded w-11 h-11 bg-white shadow-sm"
          >
            <i class="fa fa-envelope fa-lg text-blue-600"></i>
          </div>
          <div>
            <p class="font-semibold text-lg">{{ __("SUBSCRIBE") }}</p>
            <p class="text-sm text-gray-600">
              {{ __("GET_NOTIFIED_ON_OFFERS") }}
            </p>
          </div>
        </div>

        <!-- Subscribe Form Input -->
        <div class="flex flex-col items-center justify-center">
          <form @submit.prevent="handleSubscribe" class="flex w-80">
            <input
              class="text-black w-full appearance-none border border-gray-200 bg-white py-2 px-3 rounded-tl-md rounded-bl-md focus:outline-none focus:ring-0 focus:border-gray-200 hover:border-gray-200"
              type="email"
              :placeholder="__('EMAIL_ADDRESS')"
              v-model="form.email"
            />
            <button
              class="px-4 py-2 text-white bg-blue-600 border border-gray-200 rounded-tr-md rounded-br-md min-w-[100px] hover:bg-blue-700"
            >
              {{ __("SUBMIT") }}
            </button>
          </form>

          <InputError class="mt-2" :message="form.errors.email" />

          <p
            v-if="$page.props.flash.successMessage"
            class="text-green-600 text-sm font-bold my-1"
          >
            {{ __($page.props.flash.successMessage) }}
          </p>
        </div>

        <!-- Social Media Icons -->
        <div v-if="socialMedia" class="flex items-center lg:ml-auto space-x-2">
          <!-- Facebook -->
          <div
            @click="handleTrafficIncrement(1, socialMedia.facebook)"
            v-if="socialMedia.facebook"
            class="cursor-pointer px-3 py-2 inline-block text-center bg-white shadow-sm border border-gray-200 rounded-md text-blue-600 hover:bg-gray-50"
            data-tooltip-target="facebook-tooltip"
          >
            <span class="sr-only">Facebook</span>
            <i class="fab fa-facebook-square"></i>

            <div
              id="facebook-tooltip"
              role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-blue-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
            >
              Our Facebook
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>

          <!-- Instagram -->
          <div
            @click="handleTrafficIncrement(2, socialMedia.instagram)"
            v-if="socialMedia.instagram"
            class="cursor-pointer px-3 py-2 inline-block text-center bg-white shadow-sm border border-gray-200 rounded-md text-pink-600 hover:bg-gray-50"
            data-tooltip-target="instagram-tooltip"
          >
            <span class="sr-only">Instagram</span>
            <i class="fab fa-instagram"></i>

            <div
              id="instagram-tooltip"
              role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-pink-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
            >
              Our Instagram
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>

          <!-- Twitter -->
          <div
            @click="handleTrafficIncrement(3, socialMedia.twitter)"
            v-if="socialMedia.twitter"
            class="cursor-pointer px-3 py-2 inline-block text-center bg-white shadow-sm border border-gray-200 rounded-md text-sky-600 hover:bg-gray-50"
            data-tooltip-target="twitter-tooltip"
          >
            <span class="sr-only">Twitter</span>
            <i class="fab fa-twitter"></i>

            <div
              id="twitter-tooltip"
              role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-sky-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
            >
              Our Twitter
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>

          <!-- Youtube -->
          <div
            @click="handleTrafficIncrement(4, socialMedia.youtube)"
            v-if="socialMedia.youtube"
            class="cursor-pointer px-3 py-2 inline-block text-center bg-white shadow-sm border border-gray-200 rounded-md text-red-600 hover:bg-gray-50"
            data-tooltip-target="youtube-tooltip"
          >
            <span class="sr-only">YouTube</span>
            <i class="w-4 fab fa-youtube"></i>

            <div
              id="youtube-tooltip"
              role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-red-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
            >
              Our Youtube
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>

          <!-- Reddit -->
          <div
            @click="handleTrafficIncrement(5, socialMedia.reddit)"
            v-if="socialMedia.reddit"
            class="cursor-pointer px-3 py-2 inline-block text-center bg-white shadow-sm border border-gray-200 rounded-md text-orange-500 hover:bg-gray-50"
            data-tooltip-target="reddit-tooltip"
          >
            <span class="sr-only">Reddit</span>
            <i class="fab fa-reddit"></i>

            <div
              id="reddit-tooltip"
              role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-orange-500 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
            >
              Our Reddit
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>

          <!-- Linked In -->
          <div
            @click="handleTrafficIncrement(6, socialMedia.linked_in)"
            v-if="socialMedia.linked_in"
            class="cursor-pointer px-3 py-2 inline-block text-center bg-white shadow-sm border border-gray-200 rounded-md text-primary-600 hover:bg-gray-50"
            data-tooltip-target="linkedin-tooltip"
          >
            <span class="sr-only">Linked In</span>
            <i class="fab fa-linkedin"></i>

            <div
              id="linkedin-tooltip"
              role="tooltip"
              class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-primary-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
            >
              Our LinkedIn
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>


