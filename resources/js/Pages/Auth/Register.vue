<template>
  <GuestLayout>
    <Head title="Register" />

    <FormContainer>
      <form @submit.prevent="submit" class="w-full">
        <h1 class="text-center text-2xl text-dark mb-5 font-bold">
          Create Your Stuff Ecommerce Account
        </h1>

        <div class="mb-3">
          <InputLabel for="name" value="Name" />

          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            placeholder="Enter Your Fullname"
          >
            <template v-slot:icon>
              <span>
                <i class="fa-solid fa-user text-gray-600"></i>
              </span>
            </template>
          </TextInput>

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

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

          <InputError
            class="mt-2"
            :message="form.errors.password_confirmation"
          />
        </div>
        <div class="mb-3">
          <FormButton> Sign Up </FormButton>
        </div>

        <p class="text-center text-sm">
          Already have account?
          <Link
            :href="route('login')"
            class="text-blue-600 font-bold hover:cursor-pointer hover:underline"
            >Login</Link
          >
        </p>
      </form>
      <span class="my-4">Or</span>

      <!-- Social Signup -->
      <SocialiteAuth />
    </FormContainer>
  </GuestLayout>
</template>




<script setup>
import FormContainer from "@/Components/Form/FormContainer.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import FormButton from "@/Components/Form/FormButton.vue";
import SocialiteAuth from "@/Components/Form/SocialiteAuth.vue";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
