<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { inject, ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const loading = ref(false);
const swal = inject("$swal");

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  loading.value = true;
  form.put(route("password.update"), {
    preserveScroll: true,
    onFinish: () => {
      loading.value = false;
    },
    onSuccess: () => {
      form.reset();
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
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
    <header>
      <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

      <p class="mt-1 text-sm text-gray-600">
        Ensure your account is using a long, random password to stay secure.
      </p>
    </header>

    <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
      <!-- Current Password Input -->
      <div>
        <InputLabel for="current_password" value="Current Password" />

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
        <InputLabel for="password" value="New Password" />

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
        <InputLabel for="password_confirmation" value="Confirm Password" />

        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          class="mt-1 block w-full"
          autocomplete="new-password"
        />

        <InputError :message="form.errors.password_confirmation" class="mt-2" />
      </div>

      <!-- Submit Button -->
      <div class="flex items-center gap-4">
        <FormButton>
          <svg
            v-if="loading"
            aria-hidden="true"
            role="status"
            class="inline w-4 h-4 mr-3 text-white animate-spin"
            viewBox="0 0 100 101"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="#E5E7EB"
            />
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentColor"
            />
          </svg>
          {{ loading ? "Loading..." : "Save" }}
        </FormButton>

        <Transition
          enter-from-class="opacity-0"
          leave-to-class="opacity-0"
          class="transition ease-in-out"
        >
          <p v-if="form.recentlySuccessful">
            {{ successAlert() }}
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
