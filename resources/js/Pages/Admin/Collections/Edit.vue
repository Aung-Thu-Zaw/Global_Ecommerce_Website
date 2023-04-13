<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Collections/Breadcrumb.vue";
import { ref } from "vue";

const props = defineProps({
  paginate: Array,
  collection: Object,
});

const form = useForm({
  title: props.collection.title,
  description: props.collection.description,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditCollection = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_collection");
  submit();
};

const submit = () => {
  form.post(
    route("admin.collections.update", {
      collection: props.collection.slug,
      page: props.paginate.page,
      per_page: props.paginate.per_page,
    }),
    {
      onFinish: () => form.reset(),
    }
  );
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Edit Collection" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Breadcrumb start -->

      <div class="flex items-center justify-between mb-10">
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
                >Edit</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            :href="route('admin.collections.index')"
            :data="{
              page: props.paginate.page,
              per_page: props.paginate.per_page,
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditCollection">
          <div class="mb-6">
            <InputLabel for="title" value="Collection Title *" />

            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              required
              placeholder="Enter Collection Title"
            />

            <InputError class="mt-2" :message="form.errors.title" />
          </div>

          <div class="mb-6">
            <InputLabel for="description" value="Collection Description *" />

            <TextInput
              id="description"
              type="text"
              class="mt-1 block w-full"
              v-model="form.description"
              required
              placeholder="Enter Collection Description"
            />

            <InputError class="mt-2" :message="form.errors.description" />
          </div>

          <div class="mb-6">
            <FormButton>Update</FormButton>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
