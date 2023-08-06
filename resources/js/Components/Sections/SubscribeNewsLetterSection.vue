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
  form.captcha_token = await executeRecaptcha("newsletter_subscribe");
  submit();
};

const submit = () => {
  form.post(route("subscribe.store"), {
    preserveScroll: true,
    onFinish: () => (form.email = ""),
  });
};

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
            <i class="fa fa-envelope fa-lg text-blue-400"></i>
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
              class="text-black w-full appearance-none border border-gray-200 bg-white py-2 px-3 rounded-tl-md rounded-bl-md focus:outline-none focus:ring-0 focus:border-gray-200 hover:border-gray-400"
              type="email"
              :placeholder="__('EMAIL_ADDRESS')"
              v-model="form.email"
            />
            <button
              class="px-4 py-2 text-blue-600 bg-white border border-gray-200 rounded-tr-md rounded-br-md w-[100px] hover:text-white hover:bg-blue-600"
            >
              {{ __("SUBMIT") }}
            </button>
          </form>

          <InputError class="mt-2" :message="form.errors.email" />

          <p
            v-if="$page.props.flash.successMessage"
            class="text-green-600 text-sm font-bold my-1"
          >
            {{ $page.props.flash.successMessage }}
          </p>
        </div>

        <!-- Social Media Icons -->
        <nav v-if="socialMedia" class="flex lg:ml-auto space-x-2">
          <div
            @click="handleTrafficIncrement(1, socialMedia.facebook)"
            v-if="socialMedia.facebook"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-blue-600"
          >
            <span class="sr-only">Facebook</span>
            <i class="fab fa-facebook-square"></i>
          </div>
          <div
            @click="handleTrafficIncrement(2, socialMedia.instagram)"
            v-if="socialMedia.instagram"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-pink-600"
          >
            <span class="sr-only">Instagram</span>
            <i class="fab fa-instagram"></i>
          </div>
          <div
            @click="handleTrafficIncrement(3, socialMedia.twitter)"
            v-if="socialMedia.twitter"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-sky-600"
          >
            <span class="sr-only">Twitter</span>
            <i class="fab fa-twitter"></i>
          </div>
          <div
            @click="handleTrafficIncrement(4, socialMedia.youtube)"
            v-if="socialMedia.youtube"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-red-600"
          >
            <span class="sr-only">YouTube</span>
            <i class="w-4 fab fa-youtube"></i>
          </div>
          <div
            @click="handleTrafficIncrement(5, socialMedia.reddit)"
            v-if="socialMedia.reddit"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-orange-500"
          >
            <span class="sr-only">Reddit</span>
            <i class="fab fa-reddit"></i>
          </div>
          <div
            @click="handleTrafficIncrement(6, socialMedia.linked_in)"
            v-if="socialMedia.linked_in"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-primary-600"
          >
            <span class="sr-only">Linked In</span>
            <i class="fab fa-linkedin"></i>
          </div>
        </nav>
      </div>
    </div>
  </section>
</template>


