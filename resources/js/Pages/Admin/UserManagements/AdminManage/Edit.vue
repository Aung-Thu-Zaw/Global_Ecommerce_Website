<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/AdminManageBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import datepicker from "vue3-datepicker";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { ref, computed } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  roles: Object,
  user: Object,
});

// Define Variables
const processing = ref(false);
const previewPhoto = ref("");
const date = ref(props.user.birthday ? new Date(props.user.birthday) : "");

// Formatted Date
const formatDate = computed(() => {
  const year = date.value ? date.value.getFullYear() : "";
  const month = date.value ? date.value.getMonth() + 1 : "";
  const day = date.value ? date.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : null;
});

// Handle Preview Image
const getPreviewPhotoPath = (path) => {
  previewPhoto.value.src = URL.createObjectURL(path);
};

// Admin Edit Form Data
const form = useForm({
  avatar: props.user.avatar,
  address: props.user.address,
  name: props.user.name,
  email: props.user.email,
  phone: props.user.phone,
  password: props.user.password,
  birthday: formatDate,
  gender: props.user.gender,
  about: props.user.about,
  assign_role: props.user.roles.length ? props.user.roles[0].id : null,
  role: props.user.role,
  status: props.user.status,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Admin
const handleEditAdminUser = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_admin");
  processing.value = true;
  form.post(
    route("admin.admin-manage.update", {
      user: props.user.id,
      per_page: props.per_page,
    }),
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing.value = false;
      },
    }
  );
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('EDIT_ADMIN_USER')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >{{ user.name }}</span
              >
            </div>
          </li>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >{{ __("EDIT") }}</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <Link
            as="button"
            :href="route('admin.admin-manage.index')"
            :data="{
              page: queryStringParams.page,
              per_page: queryStringParams.per_page,
              sort: queryStringParams.sort,
              direction: queryStringParams.direction,
            }"
          >
            <GoBackButton />
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <!-- Preview Image -->
        <div class="mb-6">
          <img ref="previewPhoto" :src="form.avatar" class="preview-img" />
        </div>

        <form @submit.prevent="handleEditAdminUser">
          <div class="grid grid-cols-2 gap-5">
            <!-- Name Input -->
            <div class="mb-6">
              <InputLabel for="name" :value="__('NAME') + ' *'" />

              <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                :placeholder="__('ENTER_NAME')"
              />

              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email Input -->
            <div class="mb-6">
              <InputLabel for="email" :value="__('EMAIL_ADDRESS') + ' *'" />

              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                :placeholder="__('ENTER_EMAIL_ADDRESS')"
              />

              <InputError class="mt-2" :message="form.errors.email" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-5">
            <!-- Phone Input -->
            <div class="mb-6">
              <InputLabel for="phone" :value="__('PHONE') + ' *'" />

              <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                :placeholder="__('ENTER_PHONE_NUMBER')"
              />

              <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <!-- Password Input -->
            <div class="mb-6">
              <InputLabel for="password" :value="__('PASSWORD') + ' *'" />

              <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                :placeholder="__('ENTER_PASSWORD')"
              />

              <InputError class="mt-2" :message="form.errors.password" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-5">
            <!-- Gender Select Box -->
            <div class="mb-6">
              <InputLabel for="gender" :value="__('GENDER') + ' *'" />

              <select
                class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                v-model="form.gender"
              >
                <option value="" disabled>{{ __("SELECT_GENDER") }}</option>
                <option value="male" :selected="form.gender === 'male'">
                  Male
                </option>
                <option value="female" :selected="form.gender === 'female'">
                  Female
                </option>
                <option value="other" :selected="form.gender === 'other'">
                  Other
                </option>
              </select>

              <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <!-- Calendar Component -->
            <div class="mb-6">
              <InputLabel for="birthday" :value="__('BIRTHDAY')" />

              <datepicker
                class="px-3 py-2.5 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                :placeholder="__('SELECT_BIRTHDAY_DATE')"
                v-model="date"
              />

              <InputError class="mt-2" :message="form.errors.birthday" />
            </div>
          </div>

          <!-- Address Input -->
          <div class="mb-6">
            <InputLabel for="address" :value="__('ADDRESS')" />

            <TextInput
              id="address"
              type="text"
              class="mt-1 block w-full"
              v-model="form.address"
              required
              :placeholder="__('ENTER_ADDRESS')"
            />

            <InputError class="mt-2" :message="form.errors.address" />
          </div>

          <!-- About Textarea -->
          <div class="mb-6">
            <InputLabel for="about" :value="__('ABOUT')" />

            <textarea
              cols="30"
              rows="10"
              class="w-full h-[200px] rounded-md focus:ring-0 border-slate-300 focus:border-slate-300"
              v-model="form.about"
              placeholder="Write about.."
            ></textarea>

            <InputError class="mt-2" :message="form.errors.about" />
          </div>

          <!-- Role Select Box -->
          <div class="mb-6">
            <InputLabel for="assignRole" :value="__('ROLE') + ' *'" />

            <select
              class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.assign_role"
            >
              <option value="" selected disabled>
                {{ __("SELECT_ROLE") }}
              </option>
              <option
                v-for="role in roles"
                :key="role.id"
                :value="role.id"
                :selected="role.id == form.assign_role"
              >
                {{ role.name }}
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.assign_role" />
          </div>

          <!-- Avatar File Input -->
          <div class="mb-6">
            <InputLabel for="image" :value="__('AVATAR')" />

            <input
              class="file-input"
              type="file"
              id="image"
              @input="form.avatar = $event.target.files[0]"
              @change="getPreviewPhotoPath($event.target.files[0])"
            />

            <span class="text-xs text-gray-500">
              SVG, PNG, JPG, JPEG, WEBP or GIF (Max File size : 5 MB)
            </span>

            <InputError class="mt-2" :message="form.errors.avatar" />
          </div>

          <!-- Save Button -->
          <div class="mb-6">
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


