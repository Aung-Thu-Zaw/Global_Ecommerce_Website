<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import InputLabel from "@/Components/Forms/Fields/InputLabel.vue";
import InputError from "@/Components/Forms/Fields/InputError.vue";
import InputField from "@/Components/Forms/Fields/InputField.vue";
import SelectBox from "@/Components/Forms/Fields/SelectBox.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import Datepicker from "vue3-datepicker";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";
import { useFormatFunctions } from "@/Composables/useFormatFunctions";
import { computed, ref } from "vue";

const startDate = ref(null);

const endDate = ref(null);

const formatStartDate = computed(() => formatDate(startDate.value));

const formatEndDate = computed(() => formatDate(endDate.value));

const couponList = "admin.coupons.index";

const { queryStringParams } = useQueryStringParams();

const { formatDate } = useFormatFunctions();

const { form, processing, errors, createAction } = useResourceActions({
  code: null,
  discount_type: null,
  discount_amount: null,
  min_spend: null,
  start_date: formatStartDate,
  end_date: formatEndDate,
  max_uses: null,
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Create :label', { label: __('Coupon') })" />
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="couponList" icon="fa-ticket" label="Coupons">
          <BreadcrumbItem label="Create" />
        </Breadcrumb>

        <div class="w-full flex items-center justify-end">
          <GoBackButton :to="couponList" />

          <InertiaLinkButton :to="couponList" :data="queryStringParams">
            <i class="fa-solid fa-left-long"></i>
            {{ __("Go Back") }}
          </InertiaLinkButton>
        </div>
      </div>

      <!-- Form Start -->
      <div class="border p-10 bg-white rounded-md">
        <form
          @submit.prevent="createAction('Coupon', 'admin.coupons.store')"
          class="space-y-4 md:space-y-6"
        >
          <div>
            <InputLabel :label="__('Coupon Code')" required />

            <InputField
              type="text"
              name="coupon-code"
              v-model="form.code"
              :placeholder="__('Enter Coupon Code')"
              autofocus
              required
            />

            <InputError :message="errors?.code" />
          </div>

          <div>
            <InputLabel :label="__('Discount Type')" required />

            <SelectBox
              name="discount-type"
              :options="[
                {
                  label: 'Percentage',
                  value: 'percentage',
                },
                {
                  label: 'Fixed Amount',
                  value: 'fixed_amount',
                },
              ]"
              v-model="form.discount_type"
              :placeholder="__('Select Option')"
              required
            />

            <InputError :message="errors?.discount_type" />
          </div>

          <div>
            <InputLabel :label="__('Discount Amount')" required />

            <InputField
              type="number"
              name="discount-amount"
              v-model="form.discount_amount"
              :placeholder="__('Enter Discount Amount')"
              required
            />

            <InputError :message="errors?.discount_amount" />
          </div>

          <div>
            <InputLabel :label="__('Minimum Spend')" required />

            <InputField
              type="number"
              name="min-spend"
              v-model="form.min_spend"
              :placeholder="__('Enter Minimum Spend')"
              required
            />

            <InputError :message="errors?.min_spend" />
          </div>

          <div>
            <InputLabel :label="__('Max Uses')" required />

            <InputField
              type="number"
              name="max-uses"
              v-model="form.max_uses"
              :placeholder="__('Enter Maximum Uses')"
              required
            />

            <InputError :message="errors?.max_uses" />
          </div>

          <div>
            <InputLabel :label="__('Start Date')" required />

            <Datepicker
              id="coupon-start-date"
              class="block w-full p-4 font-semibold text-sm text-gray-800 border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all rounded-md"
              v-model="startDate"
              :placeholder="__('Select Date')"
              required
            />

            <InputError :message="errors?.start_date" />
          </div>

          <div>
            <InputLabel :label="__('End Date')" required />

            <Datepicker
              id="coupon-end-date"
              class="block w-full p-4 font-semibold text-sm text-gray-800 border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all rounded-md"
              v-model="endDate"
              :placeholder="__('Select Date')"
              required
            />

            <InputError :message="errors?.end_date" />
          </div>

          <InputError :message="errors?.captcha_token" />

          <FormButton type="submit" :processing="processing">
            {{ __("Create") }}
          </FormButton>
        </form>
      </div>
      <!-- Form End -->
    </div>
  </AdminDashboardLayout>
</template>
