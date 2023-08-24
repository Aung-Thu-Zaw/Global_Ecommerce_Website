<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FlashSaleBreadcrumb.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import DisapprovedStatus from "@/Components/Status/DisapprovedStatus.vue";
import ApprovedStatus from "@/Components/Status/ApprovedStatus.vue";
import NoDiscountStatus from "@/Components/Status/NoDiscountStatus.vue";
import DiscountStatus from "@/Components/Status/DiscountStatus.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import datepicker from "vue3-datepicker";
import { usePage, useForm, Head, router } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref, inject } from "vue";

// Define the props
const props = defineProps({
  flashSale: Object,
  products: Object,
  flashSaleItems: Object,
});

// Define Variables
const swal = inject("$swal");
const processing1 = ref(false);
const processing2 = ref(false);
const product = ref(null);

const endDate = ref(
  props.flashSale.end_date ? new Date(props.flashSale.end_date) : ""
);

const formattedEndDate = computed(() => {
  const year = endDate.value ? endDate.value.getFullYear() : "";
  const month = endDate.value ? endDate.value.getMonth() + 1 : "";
  const day = endDate.value ? endDate.value.getDate() : "";

  return `${year}-${month}-${day}`;
});

// Flash Sale Edit Form Data
const form = useForm({
  end_date: formattedEndDate,
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Edit Flash Sale
const handleEditFlashSale = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_flash_sale");

  processing1.value = true;

  form.patch(
    route("admin.flash-sales.update", {
      flash_sale: props.flashSale.id,
    }),
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing1.value = false;
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

// Handle Add Flash Sale Product
const handleAddFlashSaleProduct = () => {
  processing2.value = true;
  router.post(
    route("admin.flash-sales.add-product"),
    {
      product_id: product.value,
    },
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing2.value = false;
        product.value = null;
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

// Handle Remove Flash Sale Product
const handleRemoveFlashSaleProduct = async (productId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THIS_PRODUCT"),
    showCancelButton: true,
    confirmButtonText: __("YES_REMOVE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(route("admin.flash-sales.remove-product", productId), {
      preserveScroll: true,
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          swal({
            icon: "success",
            title: __(usePage().props.flash.successMessage),
          });
        }
      },
    });
  }
};

// Formatted Amount
const formattedAmount = (amount) => {
  const totalAmount = parseFloat(amount);
  if (Number.isInteger(totalAmount)) {
    return totalAmount.toFixed(0);
  } else {
    return totalAmount.toFixed(2);
  }
};

// Flash Sale Edit Permission
const flashSaleEdit = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "flash-sale.edit"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('FLASH_SALES')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="grid grid-cols-2 gap-3 mb-5">
        <div class="border shadow-md p-10">
          <form @submit.prevent="handleEditFlashSale">
            <!-- Flash Sale Date Component -->
            <div class="mb-6">
              <InputLabel for="end_date" :value="__('END_DATE') + ' *'" />

              <datepicker
                class="p-3 w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                :placeholder="__('SELECT_END_DATE')"
                v-model="endDate"
              />

              <InputError class="mt-2" :message="form.errors.end_date" />
            </div>

            <!-- Save Button -->
            <div v-if="flashSaleEdit" class="mb-3">
              <SaveButton :processing="processing1" />
            </div>
          </form>
        </div>

        <div class="border shadow-md p-10">
          <form @submit.prevent="handleAddFlashSaleProduct">
            <!-- Product Select Box -->
            <div class="mb-6">
              <InputLabel for="end-date" :value="__('ADD_PRODUCT') + ' *'" />

              <select
                class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
                v-model="product"
              >
                <option selected disabled>
                  {{ __("SELECT_PRODUCT") }}
                </option>

                <option
                  v-for="product in products"
                  :key="product.id"
                  :value="product.id"
                >
                  {{ product.name }}
                </option>
              </select>
            </div>

            <!-- Save Button -->
            <div v-if="flashSaleEdit" class="mb-3">
              <SaveButton :processing="processing2" />
            </div>
          </form>
        </div>
      </div>

      <div>
        <!-- Product Table -->
        <TableContainer>
          <TableHeader>
            <HeaderTh @click="updateSorting('id')"> No </HeaderTh>

            <HeaderTh> {{ __("IMAGE") }} </HeaderTh>

            <HeaderTh @click="updateSorting('name')">
              {{ __("NAME") }}
            </HeaderTh>

            <HeaderTh @click="updateSorting('price')">
              {{ __("PRICE") }}
            </HeaderTh>

            <HeaderTh @click="updateSorting('discount')">
              {{ __("DISCOUNT") }} (%)
            </HeaderTh>

            <HeaderTh @click="updateSorting('status')">
              {{ __("STATUS") }}
            </HeaderTh>

            <HeaderTh @click="updateSorting('created_at')">
              {{ __("CREATED_DATE") }}
            </HeaderTh>

            <HeaderTh>
              {{ __("ACTION") }}
            </HeaderTh>
          </TableHeader>

          <tbody v-if="flashSaleItems.data.length">
            <Tr
              v-for="flashSaleItem in flashSaleItems.data"
              :key="flashSaleItem.product.id"
            >
              <BodyTh>
                {{ flashSaleItem.id }}
              </BodyTh>

              <Td>
                <img :src="flashSaleItem.product.image" class="image" />
              </Td>

              <Td class="line-clamp-1">
                {{ flashSaleItem.product.name }}
              </Td>

              <Td class="w-[110px]">
                $ {{ formattedAmount(flashSaleItem.product.price) }}
              </Td>

              <Td class="w-[150px]">
                <DiscountStatus
                  :price="flashSaleItem.product.price"
                  :discount="flashSaleItem.product.discount"
                />

                <NoDiscountStatus v-if="!flashSaleItem.product.discount" />
              </Td>

              <Td class="w-[180px]">
                <PendingStatus
                  v-if="flashSaleItem.product.status === 'pending'"
                >
                  {{ flashSaleItem.product.status }}
                </PendingStatus>

                <DisapprovedStatus
                  v-if="flashSaleItem.product.status === 'disapproved'"
                >
                  {{ flashSaleItem.product.status }}
                </DisapprovedStatus>

                <ApprovedStatus
                  v-if="flashSaleItem.product.status === 'approved'"
                >
                  {{ flashSaleItem.product.status }}
                </ApprovedStatus>
              </Td>

              <Td>
                {{ flashSaleItem.created_at }}
              </Td>

              <Td>
                <!-- Delete Button -->
                <div>
                  <DeleteButton
                    @click="
                      handleRemoveFlashSaleProduct(flashSaleItem.product_id)
                    "
                  />
                </div>
              </Td>
            </Tr>
          </tbody>
        </TableContainer>

        <!-- No Data Row -->
        <NotAvaliableData v-if="!flashSaleItems.data.length" />

        <!-- Pagination -->
        <div v-if="flashSaleItems.data.length" class="mt-6">
          <p class="text-center text-sm text-gray-600 mb-3 font-bold">
            Showing {{ flashSaleItems.from }} - {{ flashSaleItems.to }} of
            {{ flashSaleItems.total }}
          </p>
          <Pagination :links="flashSaleItems.links" />
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
