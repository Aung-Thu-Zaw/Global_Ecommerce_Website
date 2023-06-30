<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SeoSettingBreadcrumb.vue";
import { useForm, Head, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  seoSetting: Object,
});

const processing = ref(false);

// Seo Permissions
const seoSettingEdit = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "seo-setting.edit"
      )
    : false;
});

// Handle Seo Setting
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
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditSeoSetting">
          <!-- Meta Title Input -->
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

          <!-- Meta Author Input -->
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

          <!-- Meta Keyword Input -->
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

          <!-- Meta Description Textarea -->
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

          <!-- Handle Button -->
          <div v-if="seoSettingEdit" class="mb-6">
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
