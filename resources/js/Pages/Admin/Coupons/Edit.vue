<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Coupons/Breadcrumb.vue";
import { computed, ref } from "vue";
import datepicker from "vue3-datepicker";

const props = defineProps({
  paginate: Array,
  coupon: Object,
});

const processing = ref(false);

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
  min_spend: props.coupon.min_spend,
  start_date: formatStartDate,
  end_date: formatEndDate,
  max_uses: props.coupon.max_uses,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditCoupon = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_coupon");
  submit();
};

const submit = () => {
  processing.value = true;
  form.post(
    route("admin.coupons.update", {
      coupon: props.coupon.id,
      page: props.paginate.page,
      per_page: props.paginate.per_page,
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
    <Head title="Edit Coupon" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
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
            as="button"
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
            <InputLabel for="min_spend" value="Minmimum Spend *" />

            <TextInput
              id="min_spend"
              type="text"
              class="mt-1 block w-full"
              v-model="form.min_spend"
              placeholder="Enter User Minimun Spend Amount"
            />

            <InputError class="mt-2" :message="form.errors.min_spend" />
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
            <InputLabel for="max_uses" value="Max Uses *" />

            <TextInput
              id="max_uses"
              type="text"
              class="mt-1 block w-full"
              v-model="form.max_uses"
              placeholder="Enter Max Usage Coupon"
            />

            <InputError class="mt-2" :message="form.errors.max_uses" />
          </div>

          <div class="mb-6">
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
