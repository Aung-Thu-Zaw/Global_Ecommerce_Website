<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CouponBreadcrumb.vue";
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
  per_page: String,
});

// Define Variables
const processing = ref(false);
const startDate = ref(null);
const endDate = ref(null);

// Format Date
const formatStartDate = computed(() => {
  const year = startDate.value ? startDate.value.getFullYear() : "";
  const month = startDate.value ? startDate.value.getMonth() + 1 : "";
  const day = startDate.value ? startDate.value.getDate() : "";

  return `${year}-${month}-${day}`;
});

const formatEndDate = computed(() => {
  const year = endDate.value ? endDate.value.getFullYear() : "";
  const month = endDate.value ? endDate.value.getMonth() + 1 : "";
  const day = endDate.value ? endDate.value.getDate() : "";

  return `${year}-${month}-${day}`;
});

// Coupon Create Form Data
const form = useForm({
  code: "",
  discount_type: "",
  discount_amount: "",
  min_spend: "",
  start_date: formatStartDate,
  end_date: formatEndDate,
  max_uses: "",
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Create Coupon
const handleCreateCoupon = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_coupon");

  processing.value = true;
  form.post(
    route("admin.coupons.store", {
      page: 1,
      per_page: props.per_page,
      sort: "id",
      direction: "desc",
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
    <Head :title="__('CREATE_COUPON')" />
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
                {{ __("CREATE") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <GoBackButton
            href="admin.coupons.index"
            :queryStringParams="{
              page: 1,
              per_page: props.per_page,
              sort: 'id',
              direction: 'desc',
            }"
          />
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleCreateCoupon">
          <!-- Coupon Code Input -->
          <div class="mb-6">
            <InputLabel for="code" :value="__('COUPON_CODE') + ' *'" />

            <TextInput
              id="code"
              type="text"
              class="mt-1 block w-full"
              v-model="form.code"
              required
              :placeholder="__('ENTER_COUPON_CODE')"
            />

            <InputError class="mt-2" :message="form.errors.code" />
          </div>

          <!-- Coupon Type Select Box -->
          <div class="mb-6">
            <InputLabel
              for="discount_type"
              :value="__('COUPON_DISCOUNT_TYPE') + ' *'"
            />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.discount_type"
            >
              <option value="" selected disabled>
                {{ __("SELECT_DISCOUNT_TYPE") }}
              </option>
              <option value="percentage">Percentage</option>
              <option value="fixed_amount">Fixed Amount</option>
            </select>

            <InputError class="mt-2" :message="form.errors.discount_type" />
          </div>

          <!-- Coupon Amount Input -->
          <div class="mb-6">
            <InputLabel
              for="discount_amount"
              :value="__('COUPON_DISCOUNT_AMOUNT') + ' *'"
            />

            <TextInput
              id="discount_amount"
              type="text"
              class="mt-1 block w-full"
              v-model="form.discount_amount"
              required
              :placeholder="__('ENTER_DISCOUNT_AMOUNT')"
            >
              <template v-slot:icon>
                <span
                  v-if="form.discount_type === 'fixed_amount'"
                  class="text-slate-500"
                >
                  $
                </span>
                <span
                  v-else-if="form.discount_type === 'percentage'"
                  class="text-slate-500"
                >
                  %
                </span>
              </template>
            </TextInput>
            <InputError class="mt-2" :message="form.errors.discount_amount" />
          </div>

          <!-- Coupon Min Spend Input -->
          <div class="mb-6">
            <InputLabel for="min_spend" :value="__('MINIMUN_SPEND') + ' *'" />

            <TextInput
              id="min_spend"
              type="text"
              class="mt-1 block w-full"
              v-model="form.min_spend"
              :placeholder="__('ENTER_USER_MINIMUN_SPEND_AMOUNT')"
            />

            <InputError class="mt-2" :message="form.errors.min_spend" />
          </div>

          <!-- Coupon Date Component -->
          <div class="mb-6">
            <InputLabel
              for="start_date"
              :value="__('COUPON_START_DATE') + ' *'"
            />

            <datepicker
              class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
              :placeholder="__('SELECT_COUPON_START_DATE')"
              v-model="startDate"
            />

            <InputError class="mt-2" :message="form.errors.start_date" />
          </div>

          <!-- Coupon Date Component -->
          <div class="mb-6">
            <InputLabel for="end_date" :value="__('COUPON_END_DATE') + ' *'" />

            <datepicker
              class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
              :placeholder="__('SELECT_COUPON_END_DATE')"
              v-model="endDate"
            />

            <InputError class="mt-2" :message="form.errors.end_date" />
          </div>

          <!-- Coupon Max Usage Input -->
          <div class="mb-6">
            <InputLabel for="max_uses" :value="__('MAX_USES') + ' *'" />

            <TextInput
              id="max_uses"
              type="text"
              class="mt-1 block w-full"
              v-model="form.max_uses"
              :placeholder="__('ENTER_MAX_USAGE_COUPON')"
            />

            <InputError class="mt-2" :message="form.errors.max_uses" />
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

