<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumbs/AdminManageBreadcrumb.vue";
import { computed, ref } from "vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import datepicker from "vue3-datepicker";

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
    <Head title="Edit Admin" />
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
                >Edit</span
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
            class="goback-btn"
          >
            <span>
              <i class="fa-solid fa-circle-left"></i>
              Go Back
            </span>
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
              <InputLabel for="name" value="Name *" />

              <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                placeholder="Enter Name"
              />

              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email Input -->
            <div class="mb-6">
              <InputLabel for="email" value="Email Address *" />

              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                placeholder="Enter Email Address"
              />

              <InputError class="mt-2" :message="form.errors.email" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-5">
            <!-- Phone Input -->
            <div class="mb-6">
              <InputLabel for="phone" value="Phone No *" />

              <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                placeholder="Enter Phone Number"
              />

              <InputError class="mt-2" :message="form.errors.phone" />
            </div>
            <!-- Password Input -->
            <div class="mb-6">
              <InputLabel for="password" value="Password *" />

              <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                placeholder="Enter Password"
              />

              <InputError class="mt-2" :message="form.errors.password" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-5">
            <!-- Gender Select Box -->
            <div class="mb-6">
              <InputLabel for="gender" value="Gender *" />

              <select
                class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                v-model="form.gender"
              >
                <option value="" disabled>Select Your Gender</option>
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
              <InputLabel for="birthday" value="Birthday" />

              <datepicker
                class="px-3 py-2.5 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                placeholder="Select Birthday Date"
                v-model="date"
              />

              <InputError class="mt-2" :message="form.errors.birthday" />
            </div>
          </div>

          <!-- Address Input -->
          <div class="mb-6">
            <InputLabel for="address" value="Address" />

            <TextInput
              id="address"
              type="text"
              class="mt-1 block w-full"
              v-model="form.address"
              required
              placeholder="Enter Address"
            />

            <InputError class="mt-2" :message="form.errors.address" />
          </div>

          <!-- About Textarea -->
          <div class="mb-6">
            <InputLabel for="about" value="About" />

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
            <InputLabel for="assignRole" value="Role *" />

            <select
              class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.assign_role"
            >
              <option value="" selected disabled>Select Role</option>
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
            <InputLabel for="image" value="Avatar" />

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

          <!-- Edit Button -->
          <div class="mb-6">
            <button class="save-btn">
              <svg
                v-if="processing"
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
              {{ processing ? "Processing..." : "Update" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


