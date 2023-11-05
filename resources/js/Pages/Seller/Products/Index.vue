<script setup>
import SellerDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import DisapprovedStatus from "@/Components/Status/DisapprovedStatus.vue";
import ApprovedStatus from "@/Components/Status/ApprovedStatus.vue";
import NoDiscountStatus from "@/Components/Status/NoDiscountStatus.vue";
import DiscountStatus from "@/Components/Status/DiscountStatus.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { inject, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  products: Object,
});

// Define Variables
const swal = inject("$swal");

// Query String Parameteres
const params = reactive({
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
});

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    route("seller.products.index"),
    {
      search: usePage().props.ziggy.query?.search,
      page: usePage().props.ziggy.query?.page,
      per_page: usePage().props.ziggy.query?.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: usePage().props.ziggy.query?.created_from,
      created_until: usePage().props.ziggy.query?.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
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

// Handle Product Delete
const handleProductDelete = async (productSlug) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_PRODUCT"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_PRODUCT_IN_THE_TRASH"),
    showCancelButton: true,
    confirmButtonText: __("YES_DELETE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("seller.products.destroy", {
        product: productSlug,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
      }),
      {
        preserveScroll: true,
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
  }
};

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: __(usePage().props.flash.successMessage),
  });
}
</script>

<template>
  <SellerDashboardLayout>
    <Head :title="__('PRODUCTS')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div>
          <TrashButton href="seller.products.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Product Button -->
        <div>
          <CreateButton href="seller.products.create" name="ADD_PRODUCT" />
        </div>

        <div class="flex items-center">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="seller.products.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="seller.products.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="seller.products.index" />
        </div>
      </div>

      <!-- Product Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("IMAGE") }} </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('price')">
            {{ __("PRICE") }}
            <SortingArrows :params="params" sort="price" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount')">
            {{ __("DISCOUNT") }} (%)
            <SortingArrows :params="params" sort="discount" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            {{ __("STATUS") }}
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh>
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="products.data.length">
          <Tr v-for="product in products.data" :key="product.id">
            <BodyTh>
              {{ product.id }}
            </BodyTh>

            <Td>
              <img :src="product.image" class="image" />
            </Td>

            <Td class="line-clamp-1">
              {{ product.name }}
            </Td>

            <Td class="w-[110px]"> $ {{ formattedAmount(product.price) }} </Td>

            <Td class="w-[150px]">
              <DiscountStatus
                :price="product.price"
                :discount="product.discount"
              />

              <NoDiscountStatus v-if="!product.discount" />
            </Td>

            <Td class="w-[180px]">
              <PendingStatus v-if="product.status === 'pending'">
                {{ product.status }}
              </PendingStatus>

              <DisapprovedStatus v-if="product.status === 'disapproved'">
                {{ product.status }}
              </DisapprovedStatus>

              <ApprovedStatus v-if="product.status === 'approved'">
                {{ product.status }}
              </ApprovedStatus>
            </Td>

            <Td class="w-[140px]">
              {{ product.created_at }}
            </Td>

            <Td class="min-w-[570px] w-auto flex items-center">
              <!-- Edit Button -->
              <div>
                <EditButton href="seller.products.edit" :slug="product.slug" />
              </div>

              <!-- Delete Button -->
              <div>
                <DeleteButton @click="handleProductDelete(product.slug)" />
              </div>

              <!-- Detail Button -->
              <div>
                <DetailButton
                  href="seller.products.show"
                  :slug="product.slug"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Product Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!products.data.length" />

      <!-- Pagination -->
      <div v-if="products.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ products.from }} - {{ products.to }} of
          {{ products.total }}
        </p>
        <Pagination :links="products.links" />
      </div>
    </div>
  </SellerDashboardLayout>
</template>

