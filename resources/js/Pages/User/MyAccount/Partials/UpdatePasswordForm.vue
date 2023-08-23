<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const processing = ref(false);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  processing.value = true;
  form.put(route("password.update"), {
    preserveScroll: true,
    onFinish: () => {
      processing.value = false;
    },
    onSuccess: () => {
      form.reset();
      if (usePage().props.flash.successMessage) {
        toast.success(__(usePage().props.flash.successMessage), {
          autoClose: 2000,
        });
      }
    },
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <section class="">
    <div class="border border-gray-300 w-full shadow rounded-md p-10">
      <header>
        <h2 class="text-lg font-medium text-gray-900">
          {{ __("UPDATE_PASSWORD") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          {{
            __(
              "ENSURE_YOUR_ACCOUNT_IS_USING_A_LONG_RANDOM_PASSWORD_TO_STAY_SECURE"
            )
          }}
        </p>
      </header>

      <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
        <!-- Current Password Input -->
        <div>
          <InputLabel for="current_password" :value="__('CURRENT_PASSWORD')" />

          <TextInput
            id="current_password"
            ref="currentPasswordInput"
            v-model="form.current_password"
            type="password"
            class="mt-1 block w-full"
            autocomplete="current-password"
          />

          <InputError :message="form.errors.current_password" class="mt-2" />
        </div>

        <!-- New Password Input -->
        <div>
          <InputLabel for="password" :value="__('NEW_PASSWORD')" />

          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full"
            autocomplete="new-password"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <!-- Confirm Password Input -->
        <div>
          <InputLabel
            for="password_confirmation"
            :value="__('CONFIRM_PASSWORD')"
          />

          <TextInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="mt-1 block w-full"
            autocomplete="new-password"
          />

          <InputError
            :message="form.errors.password_confirmation"
            class="mt-2"
          />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
          <SaveButton :processing="processing" />
        </div>
      </form>
    </div>
  </section>
</template>
