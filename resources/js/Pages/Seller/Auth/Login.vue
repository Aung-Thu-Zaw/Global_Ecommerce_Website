<script setup>
import { useReCaptcha } from "vue-recaptcha-v3";
import FormButton from "@/Components/Buttons/FormButton.vue";
import Checkbox from "@/Components/Forms/Checkbox.vue";
import FormContainer from "@/Components/Forms/FormContainer.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage } from "@inertiajs/vue3";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const recaptcha = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("login");
  submit();
};

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <GuestLayout>
    <Head :title="__('SELLER_DASHBOARD_LOGIN')" />

    <FormContainer>
      <div
        v-if="status"
        class="mb-4 font-medium text-sm text-green-500 bg-green-100 p-3 w-full rounded-md text-center"
      >
        {{ status }}
      </div>
      <form @submit.prevent="recaptcha" class="w-full">
        <h1 class="text-center text-2xl text-dark mb-5 font-bold">
          {{ __("SELLER_DASHBOARD_LOGIN") }}
        </h1>

        <!-- Email Input -->
        <div class="mb-3">
          <InputLabel for="email" :value="__('EMAIL_ADDRESS') + '*'" />

          <TextInput
            id="email"
            type="email"
            v-model="form.email"
            required
            :placeholder="__('ENTER_YOUR_EMAIL_ADDRESS')"
          >
            <template v-slot:icon>
              <span>
                <i class="fa-solid fa-envelope text-gray-600"></i>
              </span>
            </template>
          </TextInput>

          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <!-- Password Input -->
        <div class="mb-3">
          <InputLabel for="password" :value="__('PASSWORD') + '*'" />

          <TextInput
            id="password"
            type="password"
            v-model="form.password"
            required
            :placeholder="__('ENTER_PASSWORD')"
          >
            <template v-slot:icon>
              <span>
                <i class="fa-solid fa-lock text-gray-600"></i>
              </span>
            </template>
          </TextInput>

          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <!-- Remember me and Forgot Password -->
        <div class="flex items-center justify-between mb-5">
          <div>
            <label class="flex items-center">
              <Checkbox name="remember" v-model:checked="form.remember" />
              <span class="ml-2 text-sm text-gray-600">
                {{ __("REMEMBER_ME") }}</span
              >
            </label>
          </div>

          <div>
            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="underline text-sm text-gray-600 rounded-md hover:text-blue-500"
            >
              {{ __("FORGOT_PASSWORD") }}?
            </Link>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
          <FormButton
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            {{ __("SIGN_IN") }}
          </FormButton>
        </div>

        <InputError
          class="mt-2 text-center font-bold"
          :message="form.errors.captcha_token"
        />
      </form>
    </FormContainer>
  </GuestLayout>
</template>
