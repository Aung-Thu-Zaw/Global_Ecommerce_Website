<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SeoSettings/Breadcrumb.vue";
import { ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  seoSetting: Object,
});

const form = useForm({
  meta_title: props.seoSetting ? props.seoSetting.meta_title : "",
  meta_author: props.seoSetting ? props.seoSetting.meta_author : "",
  meta_keyword: props.seoSetting ? props.seoSetting.meta_keyword : "",
  meta_description: props.seoSetting ? props.seoSetting.meta_description : "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditSeoSetting = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_seo_setting");
  submit();
};

const submit = () => {
  form.post(
    route("admin.seo-settings.update", {
      seo_setting: props.seoSetting.id,
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
    <Head title="SEO Setting" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Breadcrumb start -->

      <div class="flex items-center justify-between mb-10">
        <Breadcrumb />
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditSeoSetting">
          <div class="mb-3">
            <InputLabel for="meta_title" value="Meta Title" />

            <TextInput
              id="meta_title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_title"
              placeholder="Enter Meta Title"
            />

            <InputError class="mt-2" :message="form.errors.meta_title" />
          </div>
          <div class="mb-3">
            <InputLabel for="meta_author" value="Meta Author" />

            <TextInput
              id="meta_author"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_author"
              placeholder="Enter Meta Author"
            />

            <InputError class="mt-2" :message="form.errors.meta_author" />
          </div>

          <div class="mb-3">
            <InputLabel for="meta_title" value="Meta Title" />

            <TextInput
              id="meta_title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_title"
              placeholder="Enter Meta Title"
            />

            <InputError class="mt-2" :message="form.errors.meta_title" />
          </div>

          <div class="mb-3">
            <InputLabel for="meta_keyword" value="Meta Keyword" />

            <TextInput
              id="meta_keyword"
              type="text"
              class="mt-1 block w-full"
              v-model="form.meta_keyword"
              placeholder="Enter Meta Keyword"
            />

            <InputError class="mt-2" :message="form.errors.meta_keyword" />
          </div>

          <div class="mb-3">
            <InputLabel for="meta_description" value="Meta Description" />

            <textarea
              name=""
              id=""
              cols="10"
              rows="10"
              class="p-2 w-full outline-none border-slate-300 focus:outline-none focus:border-slate-300 rounded-md focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
              v-model="form.meta_description"
            ></textarea>

            <InputError class="mt-2" :message="form.errors.meta_description" />
          </div>

          <div class="mb-6">
            <FormButton>Save</FormButton>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
