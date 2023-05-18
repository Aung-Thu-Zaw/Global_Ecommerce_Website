<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { watch } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  conversation: Object,
});

watch(
  () => props.conversation,
  () => {
    form.conversation_id = props.conversation.id;
  }
);

const form = useForm({
  conversation_id: null,
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  message: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleCreateMessage = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_message");
  submit();
};

const submit = () => {
  form.post(route("message.store"), {
    onFinish: () => {
      form.message = "";
    },
  });
};
</script>

<template>
  <div
    class="w-[599px] overflow-hidden fixed bottom-0 border-t-2 border-t-slate-300 py-3 bg-slate-100"
  >
    <form
      @submit.prevent="handleCreateMessage"
      class="w-full flex items-center justify-end px-5"
    >
      <!-- <div class="mr-5">
                <label
                  for="fileInput"
                  class="inline-block cursor-pointer bg-slate-400 text-white hover:bg-slate-600 rounded-full px-3 py-2"
                >
                  <i class="fa-solid fa-paperclip"></i>
                </label>
                <input id="fileInput" type="file" class="hidden" />
              </div> -->
      <div
        class="border-2 border-slate-400 w-[95%] flex items-center justify-between rounded-full px-4 bg-gray-50"
      >
        <input
          type="text"
          class="border-0 bg-gray-50 focus:ring-0 focus:border-0 w-full"
          v-model="form.message"
        />
        <button class="px-3 py-2 text-slate-600">
          <i class="fa-solid fa-paper-plane"></i>
        </button>
      </div>
    </form>
  </div>
</template>


