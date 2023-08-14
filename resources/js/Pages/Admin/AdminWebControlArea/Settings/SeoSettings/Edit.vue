<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SeoSettingBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { usePage, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref, inject } from "vue";

// Define the props
const props = defineProps({
  seoSetting: Object,
});

// Define Variables
const swal = inject("$swal");
const processing = ref(false);

// Seo Setting Edit Form Data
const form = useForm({
  meta_title: props.seoSetting?.meta_title,
  meta_author: props.seoSetting?.meta_author,
  meta_keyword: props.seoSetting?.meta_keyword,
  meta_description: props.seoSetting?.meta_description,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Seo Setting
const handleEditSeoSetting = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_seo_setting");

  processing.value = true;

  form.post(
    route("admin.seo-settings.update", {
      seo_setting: props.seoSetting.id,
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

// Seo Setting Edit Permission
const seoSettingEdit = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "setting.edit"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('SEO_SETTING')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditSeoSetting">
          <!-- Meta Title Input -->
          <div class="mb-3">
            <InputLabel for="meta_title" :value="__('META_TITLE')" />

            <TextInput
              id="meta_title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_title"
              :placeholder="__('ENTER_META_TITLE')"
            />

            <InputError class="mt-2" :message="form.errors.meta_title" />
          </div>

          <!-- Meta Author Input -->
          <div class="mb-3">
            <InputLabel for="meta_author" :value="__('META_AUTHOR')" />

            <TextInput
              id="meta_author"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_author"
              :placeholder="__('ENTER_META_AUTHOR')"
            />

            <InputError class="mt-2" :message="form.errors.meta_author" />
          </div>

          <!-- Meta Keyword Input -->
          <div class="mb-3">
            <InputLabel for="meta_author" :value="__('META_KEYWORD')" />

            <TextInput
              id="meta_keyword"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_keyword"
              :placeholder="__('ENTER_META_KEYWORD')"
            />

            <InputError class="mt-2" :message="form.errors.meta_keyword" />
          </div>

          <!-- Meta Description Textarea -->
          <div class="mb-3">
            <InputLabel
              for="meta_description"
              :value="__('META_DESCRIPTION')"
            />

            <textarea
              name=""
              id=""
              cols="10"
              rows="10"
              class="p-2 w-full outline-none border-slate-300 focus:outline-none focus:border-slate-300 rounded-md focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
              :placeholder="__('ENTER_META_DESCRIPTION')"
              v-model="form.meta_description"
            ></textarea>

            <InputError class="mt-2" :message="form.errors.meta_description" />
          </div>

          <!-- Save Button -->
          <div v-if="seoSettingEdit" class="mb-6">
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
