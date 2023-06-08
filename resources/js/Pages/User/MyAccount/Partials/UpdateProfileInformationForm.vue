<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, inject, ref } from "vue";
import datepicker from "vue3-datepicker";

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

const user = usePage().props.auth.user;

const date = ref(user.birthday ? new Date(user.birthday) : "");

const formatDate = computed(() => {
  const year = date.value ? date.value.getFullYear() : "";
  const month = date.value ? date.value.getMonth() + 1 : "";
  const day = date.value ? date.value.getDate() : "";

  if (year && month && date) {
    return `${year}-${month}-${day}`;
  }
  return "";
});

const form = useForm({
  name: user.name,
  email: user.email,
  avatar: user.avatar,
  phone: user.phone,
  address: user.address,
  gender: user.gender,
  birthday: formatDate,
});

const swal = inject("$swal");
const successAlert = () => {
  swal({
    icon: "success",
    title: "Profile updated successfully",
  });
};

const previewPhoto = ref("");
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};
</script>

<template>
  <section class="flex flex-wrap items-start justify-between">
    <div v-if="user.avatar" class="mx-auto">
      <img
        ref="previewPhoto"
        :src="user.avatar"
        alt=""
        class="ring-4 ring-blue-400 w-[200px] h-[200px] object-cover rounded-full shadow-md my-3"
      />
    </div>

    <div v-else class="mx-auto">
      <img
        src="https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
        alt=""
        class="ring-4 ring-blue-400 w-[200px] h-[200px] object-cover rounded-full shadow-md my-3"
      />
    </div>

    <div class="mx-auto w-full md:w-[60%]">
      <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

        <p class="mt-1 text-sm text-gray-600">
          Update your account's profile information and email address.
        </p>
      </header>

      <form
        @submit.prevent="form.post(route('my-account.update'))"
        class="mt-6 space-y-6"
      >
        <div>
          <InputLabel for="name" value="Name *" />

          <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            placeholder="Enter Your Name"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div>
          <InputLabel for="email" value="Email *" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            placeholder="Enter Your Email"
          />

          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
          <p class="text-sm mt-2 text-gray-800">
            Your email address is unverified.
            <Link
              :href="route('verification.send')"
              method="post"
              as="button"
              class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Click here to re-send the verification email.
            </Link>
          </p>

          <div
            v-show="props.status === 'verification-link-sent'"
            class="mt-2 font-medium text-sm text-green-600"
          >
            A new verification link has been sent to your email address.
          </div>
        </div>

        <div>
          <InputLabel for="phone" value="Phone" />

          <TextInput
            id="phone"
            type="phone"
            class="mt-1 block w-full"
            v-model="form.phone"
            placeholder="Enter Your Phone Number"
          />

          <InputError class="mt-2" :message="form.errors.phone" />
        </div>

        <div>
          <InputLabel for="address" value="Address" />

          <TextInput
            id="address"
            type="address"
            class="mt-1 block w-full"
            v-model="form.address"
            placeholder="Enter Your Address"
          />

          <InputError class="mt-2" :message="form.errors.address" />
        </div>

        <div>
          <InputLabel for="gender" value="Gender *" />

          <select
            class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
            v-model="form.gender"
          >
            <option value="" selected disabled>Select Your Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>

          <InputError class="mt-2" :message="form.errors.gender" />
        </div>

        <div>
          <InputLabel for="birthday" value="Birthday" />

          <datepicker
            class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
            placeholder="Select Your Birthday"
            v-model="date"
          />

          <InputError class="mt-2" :message="form.errors.birthday" />
        </div>

        <div>
          <InputLabel for="avatar" value="Avatar" />

          <input
            class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
            type="file"
            id="avatar"
            @input="form.avatar = $event.target.files[0]"
            @change="getPreviewPhotoPath($event.target.files[0])"
          />

          <InputError class="mt-2" :message="form.errors.avatar" />
        </div>

        <div class="flex items-center gap-4">
          <FormButton :disabled="form.processing"> Save </FormButton>

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
