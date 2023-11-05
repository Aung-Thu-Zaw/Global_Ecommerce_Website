<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/WebsiteSettingBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { usePage, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref, inject } from "vue";

// Define the props
const props = defineProps({
  websiteSetting: Object,
});

// Define Variables
const swal = inject("$swal");
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
          swal({
            icon: "success",
            title: __(usePage().props.flash.successMessage),
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
        (permission) => permission.name === "setting.edit"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('WEBSITE_SETTING')" />
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
              <InputLabel for="logo" :value="__('LOGO')" />

              <input
                class="file-input"
                type="file"
                id="logo"
                @input="form.logo = $event.target.files[0]"
                @change="getPreviewPhotoPath1($event.target.files[0])"
              />

              <span class="text-xs text-gray-500">
                SVG, PNG, JPG, JPEG, WEBP or GIF (Max File size : 5 MB)
              </span>

              <InputError class="mt-2" :message="form.errors.logo" />
            </div>

            <!-- Favicon File Upload Input -->
            <div class="mb-3">
              <InputLabel for="favicon" :value="__('FAVICON')" />

              <input
                class="file-input"
                type="file"
                id="favicon"
                @input="form.favicon = $event.target.files[0]"
                @change="getPreviewPhotoPath2($event.target.files[0])"
              />

              <span class="text-xs text-gray-500">
                SVG, PNG, JPG, JPEG, WEBP or GIF (Max File size : 5 MB)
              </span>

              <InputError class="mt-2" :message="form.errors.favicon" />
            </div>
          </div>

          <!-- Componay Email Input -->
          <div class="mb-3">
            <InputLabel for="email" :value="__('COMPANY_EMAIL')" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              :placeholder="__('ENTER_COMPANY_EMAIL')"
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
              <InputLabel for="phone" :value="__('COMPANY_PHONE')" />

              <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                :placeholder="__('ENTER_COMPANY_PHONE')"
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
              <InputLabel for="support_phone" :value="__('SUPPORT_PHONE')" />

              <TextInput
                id="support_phone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.support_phone"
                :placeholder="__('ENTER_SUPPORT_PHONE')"
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
            <InputLabel for="company_address" :value="__('COMPANY_ADDRESS')" />

            <TextInput
              id="company_address"
              type="text"
              class="mt-1 block w-full"
              v-model="form.company_address"
              :placeholder="__('ENTER_COMPANY_ADDRESS')"
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
            <InputLabel for="copyright" :value="__('COPY_RIGHT')" />

            <TextInput
              id="copyright"
              type="text"
              class="mt-1 block w-full"
              v-model="form.copyright"
              :placeholder="__('ENTER_COPYRIGHT')"
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
              <InputLabel for="facebook" :value="__('FACEBOOK_URL')" />

              <TextInput
                id="facebook"
                type="text"
                class="mt-1 block w-full"
                v-model="form.facebook"
                :placeholder="__('ENTER_FACEBOOK_URL')"
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
              <InputLabel for="instagram" :value="__('INSTAGRAM_URL')" />

              <TextInput
                id="instagram"
                type="text"
                class="mt-1 block w-full"
                v-model="form.instagram"
                :placeholder="__('ENTER_INSTAGRAM_URL')"
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
              <InputLabel for="twitter" :value="__('TWITTER_URL')" />

              <TextInput
                id="twitter"
                type="text"
                class="mt-1 block w-full"
                v-model="form.twitter"
                :placeholder="__('ENTER_TWITTER_URL')"
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
              <InputLabel for="youtube" :value="__('YOUTUBE_URL')" />

              <TextInput
                id="youtube"
                type="text"
                class="mt-1 block w-full"
                v-model="form.youtube"
                :placeholder="__('ENTER_YOUTUBE_URL')"
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
              <InputLabel for="reddit" :value="__('REDDIT_URL')" />

              <TextInput
                id="reddit"
                type="text"
                class="mt-1 block w-full"
                v-model="form.reddit"
                :placeholder="__('ENTER_REDDIT_URL')"
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
              <InputLabel for="linked_in" :value="__('LINKED_IN_URL')" />

              <TextInput
                id="linked_in"
                type="text"
                class="mt-1 block w-full"
                v-model="form.linked_in"
                :placeholder="__('ENTER_LINKED_IN_URL')"
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

          <!-- Edit Button -->
          <div v-if="websiteSettingEdit" class="mb-6">
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
