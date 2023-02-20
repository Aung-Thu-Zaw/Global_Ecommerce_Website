<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
  email: String,
  token: String,
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Reset Password" />

    <form @submit.prevent="submit">
      <div class="mb-3">
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          placeholder="Enter Your Email Address"
        >
          <template v-slot:icon>
            <span>
              <i class="fa-solid fa-envelope text-gray-600"></i>
            </span>
          </template>
        </TextInput>

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mb-3">
        <InputLabel for="password" value="Password" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          placeholder="Enter Password"
        >
          <template v-slot:icon>
            <span>
              <i class="fa-solid fa-lock text-gray-600"></i>
            </span>
          </template>
        </TextInput>

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mb-3">
        <InputLabel for="password_confirmation" value="Confirm Password" />

        <TextInput
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
          required
          placeholder="Retype Your Password"
        >
          <template v-slot:icon>
            <span>
              <i class="fa-solid fa-lock text-gray-600"></i>
            </span>
          </template>
        </TextInput>

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="mb-3">
        <FormButton
          class="text-sm"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Reset Password
        </FormButton>
      </div>
    </form>
  </GuestLayout>
</template>
