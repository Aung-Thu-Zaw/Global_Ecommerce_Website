<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import datepicker from "vue3-datepicker";
import { __ } from "@/Translations/translations-inside-setup.js";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Define the props
const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

// Define Variables
const user = usePage().props.auth.user;
const processing = ref(false);
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
  processing.value = true;

  form.post(route("my-account.update"), {
    replace: true,
    preserveState: true,
    onFinish: () => {
      processing.value = false;
    },
    onSuccess: () => {
      if (usePage().props.flash.successMessage) {
        toast.success(__(usePage().props.flash.successMessage), {
          autoClose: 2000,
        });
      }
    },
  });
};
</script>

<template>
  <section class="flex flex-wrap items-start justify-between">
    <div class="border border-gray-300 w-full shadow rounded-md p-10">
      <div class="mx-auto w-full">
        <!-- Avatar Profile Photo  -->
        <div v-if="user.avatar" class="mx-auto">
          <img
            ref="previewPhoto"
            :src="user.avatar"
            alt=""
            class="border-2 border-slate-300 w-[150px] h-[150px] object-cover rounded-full shadow-md my-3"
          />
        </div>

        <div v-else class="mx-auto">
          <img
            src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
            alt=""
            class="border-2 border-slate-300 w-[150px] h-[150px] object-cover rounded-full shadow-md my-3"
          />
        </div>
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

          <div class="grid grid-cols-2 gap-3">
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
          </div>

          <!-- Resend Verification Link -->
          <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
            <p class="text-sm mt-2 text-gray-800">
              {{ __("YOUR_EMAIL_ADDRESS_IS_UNVERIFIED") }}
              <Link
                :href="route('verification.send')"
                method="post"
                as="button"
                class="underline text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                {{ __("CLICK_HERE_TO_RESEND_THE_VERIFICATION_EMAIL") }}
              </Link>
            </p>

            <div
              v-show="props.status === 'verification-link-sent'"
              class="mt-2 font-medium text-sm text-green-600"
            >
              {{
                __(
                  "A_NEW_VERIFICATION_LINK_HAS_BEEN_SENT_TO_YOUR_EMAIL_ADDRESS"
                )
              }}
            </div>
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

          <div class="grid grid-cols-2 gap-3">
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
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </section>
</template>
