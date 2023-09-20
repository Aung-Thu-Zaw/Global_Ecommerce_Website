<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CityBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  countries: Object,
  regions: Object,
  city: Object,
});

const processing = ref(false);
const country = ref(props.city?.region?.country?.id);

const filteredRegions = computed(() => {
  return props.regions.filter((region) => {
    return region.country_id === country.value;
  });
});

const form = useForm({
  name: props.city?.name,
  region_id: props.city?.region_id,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditCity = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_city");

  processing.value = true;
  form.patch(
    route("admin.cities.update", {
      city: props.city.slug,
      page: props.queryStringParams.page,
      per_page: props.queryStringParams.per_page,
      sort: props.queryStringParams.sort,
      direction: props.queryStringParams.direction,
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
    <Head :title="__('EDIT_CITY')" />
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
              >
                {{ city.name }}
              </span>
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
              >
                {{ __("EDIT") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <GoBackButton
            href="admin.cities.index"
            :queryStringParams="queryStringParams"
          />
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleEditCity">
          <div class="mb-6">
            <InputLabel for="name" :value="__('CITY_NAME') + ' *'" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              :placeholder="__('ENTER_CITY_NAME')"
            />

            <InputError class="mt-2" :message="form.errors.name" />
          </div>

          <!-- Country Select Box -->
          <div class="mb-6">
            <InputLabel for="country" :value="__('COUNTRY') + '*'" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="country"
            >
              <option value="" selected disabled>
                {{ __("SELECT_COUNTRY") }}
              </option>
              <option
                v-for="country in countries"
                :key="country"
                :value="country.id"
              >
                {{ country.name }}
              </option>
            </select>
          </div>

          <!-- Region Select Box -->
          <div class="mb-6">
            <InputLabel for="region" :value="__('REGION') + '*'" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.region_id"
              :disabled="!country"
            >
              <option value="" selected disabled>
                {{ __("SELECT_REGION") }}
              </option>
              <option
                v-for="region in filteredRegions"
                :key="region"
                :value="region.id"
                :selected="region.id === form.region_id"
              >
                {{ region.name }}
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.region_id" />
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


