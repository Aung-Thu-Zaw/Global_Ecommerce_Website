<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumbs/WebsiteSettingBreadcrumb.vue";
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Define the props
const props = defineProps({
  websiteSetting: Object,
});

// Define Variables
const processing = ref(false);

// Preview Photos
const previewPhoto1 = ref("");
const getPreviewPhotoPath1 = (path) => {
  previewPhoto1.value.src = URL.createObjectURL(path);
};

const previewPhoto2 = ref("");
const getPreviewPhotoPath2 = (path) => {
  previewPhoto2.value.src = URL.createObjectURL(path);
};

// Website Setting Edit Form Data
const form = useForm({
  logo: props.websiteSetting?.logo,
  favicon: props.websiteSetting?.favicon,
  phone: props.websiteSetting?.phone,
  support_phone: props.websiteSetting?.support_phone,
  email: props.websiteSetting?.email,
  company_address: props.websiteSetting?.company_address,
  copyright: props.websiteSetting?.copyright,
  facebook: props.websiteSetting?.facebook,
  twitter: props.websiteSetting?.twitter,
  instagram: props.websiteSetting?.instagram,
  youtube: props.websiteSetting?.youtube,
  reddit: props.websiteSetting?.reddit,
  linked_in: props.websiteSetting?.linked_in,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Website Setting
const handleEditWebsiteSetting = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_website_setting");

  processing.value = true;
  form.post(
    route("admin.website-settings.update", {
      website_setting: props.websiteSetting.id,
    }),
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing.value = false;
      },
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};

// Website Setting Edit Permission
const websiteSettingEdit = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "website-setting.edit"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Website Setting" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditWebsiteSetting">
          <!-- Preview Images -->
          <div class="grid grid-cols-2 gap-3 mb-5">
            <div class="h-[200px]">
              <img
                ref="previewPhoto1"
                :src="form.logo"
                class="h-full object-cover shadow border rounded-md"
              />
            </div>
            <div class="h-[200px]">
              <img
                ref="previewPhoto2"
                :src="form.favicon"
                class="h-full object-cover shadow border rounded-md"
              />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <!-- Logo File Upload Input -->
            <div class="mb-3">
              <InputLabel for="logo" value="Logo" />

              <input
                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                type="file"
                id="logo"
                @input="form.logo = $event.target.files[0]"
                @change="getPreviewPhotoPath1($event.target.files[0])"
              />

              <InputError class="mt-2" :message="form.errors.logo" />
            </div>

            <!-- Favicon File Upload Input -->
            <div class="mb-3">
              <InputLabel for="favicon" value="Favicon" />

              <input
                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                type="file"
                id="favicon"
                @input="form.favicon = $event.target.files[0]"
                @change="getPreviewPhotoPath2($event.target.files[0])"
              />

              <InputError class="mt-2" :message="form.errors.favicon" />
            </div>
          </div>

          <!-- Componay Email Input -->
          <div class="mb-3">
            <InputLabel for="email" value="Company Email" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              placeholder="Enter Company Email"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-envelope text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError class="mt-2" :message="form.errors.email" />
          </div>
          <div class="grid grid-cols-2 gap-3">
            <!-- Company Phone Input -->
            <div class="mb-3">
              <InputLabel for="phone" value="Company Phone" />

              <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                placeholder="Enter Company Phone"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-phone-volume text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <!-- Support Phone Input -->
            <div class="mb-3">
              <InputLabel for="support_phone" value="Support Phone" />

              <TextInput
                id="support_phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.support_phone"
                placeholder="Enter Support Phone"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-phone text-gray-600"></i>
                  </span>
                </template>
              </TextInput>

              <InputError class="mt-2" :message="form.errors.support_phone" />
            </div>
          </div>

          <!-- Company Address Input -->
          <div class="mb-3">
            <InputLabel for="company_address" value="Company Address" />

            <TextInput
              id="company_address"
              type="text"
              class="mt-1 block w-full"
              v-model="form.company_address"
              placeholder="Enter Company Address"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-building text-gray-600"></i>
                </span>
              </template>
            </TextInput>
            <InputError class="mt-2" :message="form.errors.company_address" />
          </div>

          <!-- Copyright Input -->
          <div class="mb-3">
            <InputLabel for="copyright" value="Copy Right" />

            <TextInput
              id="copyright"
              type="text"
              class="mt-1 block w-full"
              v-model="form.copyright"
              placeholder="Enter Copy Right"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-copyright text-gray-600"></i>
                </span>
              </template>
            </TextInput>
            <InputError class="mt-2" :message="form.errors.copyright" />
          </div>

          <!-- Facebook Input -->
          <div class="grid grid-cols-2 gap-3">
            <div class="mb-3">
              <InputLabel for="facebook" value="Facebook URL" />

              <TextInput
                id="facebook"
                type="text"
                class="mt-1 block w-full"
                v-model="form.facebook"
                placeholder="Enter Facebook URL"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-brands fa-facebook text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.facebook" />
            </div>

            <!-- Instagram Input -->
            <div class="mb-3">
              <InputLabel for="instagram" value="Instagram URL" />

              <TextInput
                id="instagram"
                type="text"
                class="mt-1 block w-full"
                v-model="form.instagram"
                placeholder="Enter Instagram URL"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-brands fa-instagram text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.instagram" />
            </div>
          </div>

          <!-- Twitter Input -->
          <div class="grid grid-cols-2 gap-3">
            <div class="mb-3">
              <InputLabel for="twitter" value="Twitter URL" />

              <TextInput
                id="twitter"
                type="text"
                class="mt-1 block w-full"
                v-model="form.twitter"
                placeholder="Enter Twitter URL"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-brands fa-twitter text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.twitter" />
            </div>

            <!-- Youtube Input -->
            <div class="mb-3">
              <InputLabel for="youtube" value="Youtube URL" />

              <TextInput
                id="youtube"
                type="text"
                class="mt-1 block w-full"
                v-model="form.youtube"
                placeholder="Enter Youtube URL"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-brands fa-youtube text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.youtube" />
            </div>
          </div>

          <!-- Reddit Input -->
          <div class="grid grid-cols-2 gap-3">
            <div class="mb-3">
              <InputLabel for="reddit" value="Reddit URL" />

              <TextInput
                id="reddit"
                type="text"
                class="mt-1 block w-full"
                v-model="form.reddit"
                placeholder="Enter Reddit URL"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-brands fa-reddit text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.reddit" />
            </div>

            <!-- Linked In Input -->
            <div class="mb-3">
              <InputLabel for="linked_in" value="Linked In URL" />

              <TextInput
                id="linked_in"
                type="text"
                class="mt-1 block w-full"
                v-model="form.linked_in"
                placeholder="Enter Linked In URL"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-brands fa-linkedin text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
              <InputError class="mt-2" :message="form.errors.linked_in" />
            </div>
          </div>

          <!-- Handle Button -->
          <div v-if="websiteSettingEdit" class="mb-6">
            <button
              class="py-3 bg-blueGray-700 rounded-sm w-full font-bold text-white hover:bg-blueGray-800 transition-all"
            >
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
              {{ processing ? "Processing..." : "Save" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
