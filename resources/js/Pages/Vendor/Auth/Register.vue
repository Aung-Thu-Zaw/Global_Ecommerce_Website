<script setup>
import { useReCaptcha } from "vue-recaptcha-v3";
import FormContainer from "@/Components/Forms/FormContainer.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import FormButton from "@/Components/Buttons/FormButton.vue";

const form = useForm({
  company_name: "",
  shop_name: "",
  name: "",
  email: "",
  phone: "",
  password: "",
  password_confirmation: "",
  gender: "other",
  role: "vendor",
  status: "inactive",
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
    <Head :title="__('SELLER_REGISTER')" />
    <div class="mt-48 mb-10 flex items-center justify-center w-full px-5">
      <FormContainer>
        <form @submit.prevent="recaptcha" class="w-full">
          <h1 class="text-center text-2xl text-dark mb-5 font-bold">
            {{ __("BECOME_A_SELLER") }}
          </h1>

          <!-- Hidden Input Fields  -->
          <input type="hidden" v-model="form.gender" />
          <input type="hidden" v-model="form.role" />
          <input type="hidden" v-model="form.status" />

          <!-- Company Name Input -->
          <div class="mb-3">
            <InputLabel for="companyName" :value="__('COMPANY_NAME')" />

            <TextInput
              id="companyName"
              type="text"
              v-model="form.company_name"
              :placeholder="__('ENTER_COMPANY_NAME')"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-building text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError class="mt-2" :message="form.errors.company_name" />
          </div>

          <!-- Shop Name Input -->
          <div class="mb-3">
            <InputLabel for="shopName" :value="__('SHOP_NAME') + '*'" />

            <TextInput
              id="shopName"
              type="text"
              v-model="form.shop_name"
              required
              :placeholder="__('ENTER_SHOP_NAME')"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-store text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError class="mt-2" :message="form.errors.shop_name" />
          </div>

          <!-- Username Input -->
          <div class="mb-3">
            <InputLabel for="name" :value="__('NAME') + '*'" />

            <TextInput
              id="name"
              type="text"
              v-model="form.name"
              required
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

          <!-- Phone Number Input -->
          <div class="mb-3">
            <InputLabel for="phone" :value="__('PHONE') + '*'" />

            <TextInput
              id="phone"
              type="text"
              v-model="form.phone"
              required
              :placeholder="__('ENTER_YOUR_PHONE_NUMBER')"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-phone text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError class="mt-2" :message="form.errors.phone" />
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

          <!-- Confirm Password Input -->
          <div class="mb-3">
            <InputLabel
              for="password_confirmation"
              :value="__('CONFIRM_PASSWORD') + '*'"
            />

            <TextInput
              id="password_confirmation"
              type="password"
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

          <!-- Submit Button -->
          <div class="mb-3">
            <FormButton> {{ __("SIGN_UP") }} </FormButton>
          </div>

          <InputError
            class="mt-2 text-center font-bold"
            :message="form.errors.captcha_token"
          />

          <p class="text-center text-sm">
            {{ __("ALREADY_HAS_A_SELLER_ACCOUNT") }}?
            <Link
              :href="route('vendor.login')"
              class="text-blue-600 font-bold hover:cursor-pointer hover:underline"
            >
              {{ __("SIGN_IN") }}
            </Link>
          </p>
        </form>
      </FormContainer>
    </div>
  </AppLayout>
</template>
