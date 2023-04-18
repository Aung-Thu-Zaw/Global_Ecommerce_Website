<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Coupons/Breadcrumb.vue";
import { computed, ref } from "vue";
import datepicker from "vue3-datepicker";

const props = defineProps({
  paginate: Array,
  coupon: Object,
});

const startDate = ref(
  props.coupon.start_date ? new Date(props.coupon.start_date) : ""
);

const formatStartDate = computed(() => {
  const year = startDate.value ? startDate.value.getFullYear() : "";
  const month = startDate.value ? startDate.value.getMonth() + 1 : "";
  const day = startDate.value ? startDate.value.getDate() : "";

  return `${year}-${month}-${day}`;
});

const endDate = ref(
  props.coupon.end_date ? new Date(props.coupon.end_date) : ""
);

const formatEndDate = computed(() => {
  const year = endDate.value ? endDate.value.getFullYear() : "";
  const month = endDate.value ? endDate.value.getMonth() + 1 : "";
  const day = endDate.value ? endDate.value.getDate() : "";

  return `${year}-${month}-${day}`;
});

const form = useForm({
  code: props.coupon.code,
  discount_type: props.coupon.discount_type,
  discount_amount: props.coupon.discount_amount,
  start_date: formatStartDate,
  end_date: formatEndDate,
  max_uses: props.coupon.max_uses,
  uses_count: props.coupon.uses_count,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditCoupon = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_coupon");
  submit();
};

const submit = () => {
  form.post(
    route("admin.coupons.update", {
      coupon: props.coupon.id,
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
    <Head title="Edit Coupon" />
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
            :href="route('admin.coupons.index')"
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
        <form @submit.prevent="handleEditCoupon">
          <div class="mb-6">
            <InputLabel for="code" value="Coupon Code *" />

            <TextInput
              id="code"
              type="text"
              class="mt-1 block w-full"
              v-model="form.code"
              required
              placeholder="Enter Coupon Code"
            />

            <InputError class="mt-2" :message="form.errors.code" />
          </div>

          <div class="mb-6">
            <InputLabel for="discount_type" value="Coupon Discount Type *" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.discount_type"
            >
              <option value="" selected disabled>Select Discount Type</option>
              <option value="percentage">Percentage</option>
              <option value="fixed_amount">Fixed Amount</option>
            </select>

            <InputError class="mt-2" :message="form.errors.discount_type" />
          </div>

          <div class="mb-6">
            <InputLabel
              for="discount_amount"
              value="Coupon Discount Amount *"
            />

            <TextInput
              id="discount_amount"
              type="text"
              class="mt-1 block w-full"
              v-model="form.discount_amount"
              required
              placeholder="Enter Discount Amount"
            />

            <InputError class="mt-2" :message="form.errors.discount_amount" />
          </div>

          <div class="mb-6">
            <InputLabel for="start_date" value="Coupon Start Date *" />

            <datepicker
              class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
              placeholder="Select Coupon Start Date"
              v-model="startDate"
            />

            <InputError class="mt-2" :message="form.errors.start_date" />
          </div>

          <div class="mb-6">
            <InputLabel for="end_date" value="Coupon End Date *" />

            <datepicker
              class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
              placeholder="Select Coupon End Date"
              v-model="endDate"
            />

            <InputError class="mt-2" :message="form.errors.end_date" />
          </div>

          <div class="mb-6">
            <InputLabel for="title" value="Coupon Max Uses *" />

            <TextInput
              id="max_uses"
              type="text"
              class="mt-1 block w-full"
              v-model="form.max_uses"
              required
              placeholder="Enter Max Uses"
            />

            <InputError class="mt-2" :message="form.errors.max_uses" />
          </div>

          <div class="mb-6">
            <InputLabel for="title" value="Coupon Uses Count" />

            <TextInput
              id="uses_count"
              type="text"
              class="mt-1 block w-full"
              v-model="form.uses_count"
              required
              placeholder="Enter Uses Count"
            />

            <InputError class="mt-2" :message="form.errors.uses_count" />
          </div>

          <div class="mb-6">
            <FormButton>Update</FormButton>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
