<script setup>
import FormContainer from "@/Components/Forms/FormContainer.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import InputContainer from "@/Components/Forms/InputContainer.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import SocialiteAuth from "@/Components/Forms/SocialiteAuth.vue";
import datepicker from "vue3-datepicker";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref } from "vue";

const date = ref(null);

const formatDate = computed(() => {
  const year = date.value ? date.value.getFullYear() : "";
  const month = date.value ? date.value.getMonth() + 1 : "";
  const day = date.value ? date.value.getDate() : "";

  return `${year}-${month}-${day}`;
});

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  gender: "",
  birthday: formatDate,
  terms: false,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const recaptcha = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("register");
  submit();
};

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>


<template>
  <AppLayout>
    <Head :title="__('SIGN_UP')" />

    <div class="mt-48 mb-10 flex items-center justify-center w-full px-5">
      <FormContainer>
        <form @submit.prevent="recaptcha" class="w-full">
          <h1 class="text-center text-2xl text-dark mb-5 font-bold">
            {{ __("CREATE_GLOBAL_E-COMMERCE_ACCOUNT") }}
          </h1>

          <!-- Name Input -->
          <div class="mb-3">
            <InputLabel for="name" :value="__('NAME') + '*'" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              autofocus
              :placeholder="__('ENTER_YOUR_FULLNAME')"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-user text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Email Input -->
          <div class="mb-3">
            <InputLabel for="email" :value="__('EMAIL_ADDRESS') + '*'" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
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
              class="mt-1 block w-full"
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

          <!-- Comfirmation Password Input -->
          <div class="mb-3">
            <InputLabel
              for="password_confirmation"
              :value="__('CONFIRM_PASSWORD') + '*'"
            />

            <TextInput
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password_confirmation"
              required
              :placeholder="__('RETYPE_YOUR_PASSWORD')"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-lock text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError
              class="mt-2"
              :message="form.errors.password_confirmation"
            />
          </div>

          <!-- Gender Selectbox -->
          <div class="mb-3">
            <InputLabel for="gender" :value="__('GENDER') + '*'" />

            <select
              class="p-4 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.gender"
              required
            >
              <option value="" selected disabled>
                {{ __("SELECT_YOUR_GENDER") }}
              </option>
              <option value="male">{{ __("MALE") }}</option>
              <option value="female">{{ __("FEMALE") }}</option>
              <option value="other">{{ __("OTHER") }}</option>
            </select>

            <InputError class="mt-2" :message="form.errors.gender" />
          </div>

          <!-- Birthday Selectbox -->
          <div class="mb-3">
            <InputLabel for="birthday" :value="__('BIRTHDAY') + '*'" />

            <InputContainer>
              <i class="fa-solid fa-calendar text-gray-600"></i>
              <datepicker
                class="p-2 w-[400px] border-transparent border-none outline-none focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                v-model="date"
                :placeholder="__('SELECT_YOUR_BIRTHDAY')"
              />
            </InputContainer>

            <InputError class="mt-2" :message="form.errors.birthday" />
          </div>

          <!-- Submit Button -->
          <div class="mb-3">
            <FormButton> {{ __("SIGN_UP") }} </FormButton>
          </div>

          <InputError
            class="mt-2 text-center font-bold"
            :message="form.errors.captcha_token"
          />

          <p class="text-center text-sm">
            {{ __("ALREDAY_HAVE_ACCOUNT") }}?
            <Link
              :href="route('login')"
              class="text-blue-600 font-bold hover:cursor-pointer hover:underline"
            >
              {{ __("SIGN_IN") }}</Link
            >
          </p>
        </form>
        <span class="my-4">
          {{ __("Or") }}
        </span>

        <!-- Social Signup -->
        <SocialiteAuth />
      </FormContainer>
    </div>
  </AppLayout>
</template>
