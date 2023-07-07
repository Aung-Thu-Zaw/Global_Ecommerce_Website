<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import datepicker from "vue3-datepicker";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, inject, ref } from "vue";

// Define the props
const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

// Define Variables
const user = usePage().props.auth.user;
const loading = ref(false);
const swal = inject("$swal");
const date = ref(user.birthday ? new Date(user.birthday) : "");
const previewPhoto = ref("");

// Formatted Date
const formattedDate = computed(() => {
  const year = date.value ? date.value.getFullYear() : "";
  const month = date.value ? date.value.getMonth() + 1 : "";
  const day = date.value ? date.value.getDate() : "";

  if (year && month && date) {
    return `${year}-${month}-${day}`;
  }
  return "";
});

// Handle Select Photo Preview
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

// Handle Account Update
const form = useForm({
  name: user.name,
  email: user.email,
  avatar: user.avatar,
  phone: user.phone,
  address: user.address,
  gender: user.gender,
  birthday: formattedDate,
});

const submit = () => {
  loading.value = true;

  form.post(route("my-account.update"), {
    replace: true,
    preserveState: true,
    onFinish: () => {
      loading.value = false;
    },
    onSuccess: () => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    },
  });
};
</script>

<template>
  <section class="flex flex-wrap items-start justify-between">
    <!-- Avatar Profile Photo  -->
    <div v-if="user.avatar" class="mx-auto">
      <img
        ref="previewPhoto"
        :src="user.avatar"
        alt=""
        class="ring-4 ring-slate-300 w-[200px] h-[200px] object-cover rounded-full shadow-md my-3"
      />
    </div>

    <div v-else class="mx-auto">
      <img
        src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
        alt=""
        class="ring-4 ring-slate-300 w-[200px] h-[200px] object-cover rounded-full shadow-md my-3"
      />
    </div>

    <div class="mx-auto w-full md:w-[60%]">
      <header>
        <h2 class="text-lg font-medium text-gray-900">
          {{ __("PROFILE_INFORMATION") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          {{ __("UPDATE_YOUR_ACCOUNT_PROFILE_INFORMATION") }}
        </p>
      </header>

      <form @submit.prevent="submit" class="mt-6 space-y-6">
        <!-- Name Input -->
        <div>
          <InputLabel for="name" :value="__('NAME') + '*'" />

          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            :placeholder="__('ENTER_YOUR_FULLNAME')"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <!-- Email Input -->
        <div>
          <InputLabel for="email" :value="__('EMAIL_ADDRESS') + '*'" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            :placeholder="__('ENTER_YOUR_EMAIL_ADDRESS')"
          />

          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <!-- Resend Verification Link -->
        <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
          <p class="text-sm mt-2 text-gray-800">
            {{ __("YOUR_EMAIL_ADDRESS_IS_UNVERIFIED") }}
            <Link
              :href="route('verification.send')"
              method="post"
              as="button"
              class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              {{ __("CLICK_HERE_TO_RESEND_THE_VERIFICATION_EMAIL") }}
            </Link>
          </p>

          <div
            v-show="props.status === 'verification-link-sent'"
            class="mt-2 font-medium text-sm text-green-600"
          >
            {{
              __("A_NEW_VERIFICATION_LINK_HAS_BEEN_SENT_TO_YOUR_EMAIL_ADDRESS")
            }}
          </div>
        </div>

        <!-- Phone Input -->
        <div>
          <InputLabel for="phone" :value="__('PHONE') + '*'" />

          <TextInput
            id="phone"
            type="phone"
            class="mt-1 block w-full"
            v-model="form.phone"
            :placeholder="__('ENTER_YOUR_PHONE_NUMBER')"
          />

          <InputError class="mt-2" :message="form.errors.phone" />
        </div>

        <!-- Address Input -->
        <div>
          <InputLabel for="address" :value="__('ADDRESS')" />

          <TextInput
            id="address"
            type="address"
            class="mt-1 block w-full"
            v-model="form.address"
            :placeholder="__('ENTER_YOUR_ADDRESS')"
          />

          <InputError class="mt-2" :message="form.errors.address" />
        </div>

        <!-- Gender Select Box -->
        <div>
          <InputLabel for="gender" :value="__('GENDER') + '*'" />

          <select
            class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
            v-model="form.gender"
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

        <!-- Birthday Calendar Component -->
        <div>
          <InputLabel for="birthday" :value="__('BIRTHDAY')" />

          <datepicker
            class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
            :placeholder="__('SELECT_YOUR_BIRTHDAY')"
            v-model="date"
          />

          <InputError class="mt-2" :message="form.errors.birthday" />
        </div>

        <!-- Avatar File Input -->
        <div>
          <InputLabel for="avatar" :value="__('AVATAR')" />

          <input
            class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
            type="file"
            id="avatar"
            @input="form.avatar = $event.target.files[0]"
            @change="getPreviewPhotoPath($event.target.files[0])"
          />

          <InputError class="mt-2" :message="form.errors.avatar" />
        </div>

        <!-- Save Button -->
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
            {{ loading ? "Loading..." : __("SAVE") }}
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
    </div>
  </section>
</template>
