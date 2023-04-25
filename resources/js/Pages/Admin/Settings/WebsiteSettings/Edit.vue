<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/WebsiteSettings/Breadcrumb.vue";
import { ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  websiteSetting: Object,
});

const previewPhoto1 = ref("");
const getPreviewPhotoPath1 = (path) => {
  previewPhoto1.value.src = URL.createObjectURL(path);
};

const previewPhoto2 = ref("");
const getPreviewPhotoPath2 = (path) => {
  previewPhoto2.value.src = URL.createObjectURL(path);
};

const form = useForm({
  logo: props.websiteSetting ? props.websiteSetting.logo : "",
  favicon: props.websiteSetting ? props.websiteSetting.favicon : "",
  phone: props.websiteSetting ? props.websiteSetting.phone : "",
  support_phone: props.websiteSetting ? props.websiteSetting.support_phone : "",
  email: props.websiteSetting ? props.websiteSetting.email : "",
  company_address: props.websiteSetting
    ? props.websiteSetting.company_address
    : "",
  copyright: props.websiteSetting ? props.websiteSetting.copyright : "",
  facebook: props.websiteSetting ? props.websiteSetting.facebook : "",
  twitter: props.websiteSetting ? props.websiteSetting.twitter : "",
  instagram: props.websiteSetting ? props.websiteSetting.instagram : "",
  youtube: props.websiteSetting ? props.websiteSetting.youtube : "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditWebsiteSetting = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_website_setting");
  submit();
};

const submit = () => {
  form.post(
    route("admin.website-settings.update", {
      website_setting: props.websiteSetting.id,
    }),
    {
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
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Website Setting" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Breadcrumb start -->

      <div class="flex items-center justify-between mb-10">
        <Breadcrumb />
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditWebsiteSetting">
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
            <div class="mb-3">
              <InputLabel for="logo" value="Logo *" />

              <input
                class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
                type="file"
                id="logo"
                @input="form.logo = $event.target.files[0]"
                @change="getPreviewPhotoPath1($event.target.files[0])"
              />

              <InputError class="mt-2" :message="form.errors.logo" />
            </div>
            <div class="mb-3">
              <InputLabel for="favicon" value="Favicon *" />

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

          <div class="mb-6">
            <FormButton>Save</FormButton>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
