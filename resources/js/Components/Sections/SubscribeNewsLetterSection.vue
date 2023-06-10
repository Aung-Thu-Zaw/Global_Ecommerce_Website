<script setup>
import { useForm } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  socialMedia: Object,
});

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
  form.post(route("subscribe"), {
    preserveScroll: true,
    onFinish: () => (form.email = ""),
  });
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
            <p class="font-semibold text-lg">Subscribe</p>
            <p class="text-sm text-gray-600">Get notified on offers</p>
          </div>
        </div>

        <div class="flex flex-col items-center justify-center">
          <form @submit.prevent="handleSubscribe" class="flex w-80">
            <input
              class="text-black w-full appearance-none border border-gray-200 bg-white py-2 px-3 rounded-tl-md rounded-bl-md focus:outline-none focus:ring-0 focus:border-gray-200 hover:border-gray-400"
              type="email"
              placeholder="Email"
              v-model="form.email"
            />
            <button
              class="px-4 py-2 text-blue-600 bg-white border border-gray-200 rounded-tr-md rounded-br-md hover:text-white hover:bg-blue-600"
            >
              Subscribe
            </button>
          </form>

          <p
            v-if="$page.props.flash.successMessage"
            class="text-green-600 text-sm font-bold my-1"
          >
            {{ $page.props.flash.successMessage }}
          </p>
        </div>

        <nav v-if="socialMedia" class="flex lg:ml-auto space-x-2">
          <a
            v-if="socialMedia.youtube"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-red-600"
            :href="socialMedia.youtube"
            target="_blank"
          >
            <span class="sr-only">YouTube</span>
            <i class="w-4 fab fa-youtube"></i>
          </a>
          <a
            v-if="socialMedia.facebook"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-blue-600"
            :href="socialMedia.facebook"
            target="_blank"
          >
            <span class="sr-only">Facebook</span>
            <i class="fab fa-facebook-square"></i>
          </a>
          <a
            v-if="socialMedia.twitter"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-sky-600"
            :href="socialMedia.twitter"
            target="_blank"
          >
            <span class="sr-only">Twitter</span>
            <i class="fab fa-twitter"></i>
          </a>
          <a
            v-if="socialMedia.instagram"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-pink-600"
            :href="socialMedia.instagram"
            target="_blank"
          >
            <span class="sr-only">Instagram</span>
            <i class="fab fa-instagram"></i>
          </a>
          <a
            v-if="socialMedia.reddit"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-orange-500"
            :href="socialMedia.reddit"
            target="_blank"
          >
            <span class="sr-only">Reddit</span>
            <i class="fab fa-reddit"></i>
          </a>
          <a
            v-if="socialMedia.linked_in"
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-primary-600"
            :href="socialMedia.linked_in"
            target="_blank"
          >
            <span class="sr-only">Linked In</span>
            <i class="fab fa-linkedin"></i>
          </a>
        </nav>
      </div>
    </div>
  </section>
</template>


