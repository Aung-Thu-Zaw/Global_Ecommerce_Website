<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import ResetFilterButton from "@/Components/Buttons/ResetFilterButton.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import DisapprovedStatus from "@/Components/Status/DisapprovedStatus.vue";
import ApprovedStatus from "@/Components/Status/ApprovedStatus.vue";
import NoDiscountStatus from "@/Components/Status/NoDiscountStatus.vue";
import DiscountStatus from "@/Components/Status/DiscountStatus.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import datepicker from "vue3-datepicker";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  products: Object,
});

// Define  Variables
const swal = inject("$swal");
const isFilterBoxOpened = ref(false);
const createdFrom = ref(
  usePage().props.ziggy.query.created_from
    ? new Date(usePage().props.ziggy.query.created_from)
    : ""
);
const createdUntil = ref(
  usePage().props.ziggy.query.created_until
    ? new Date(usePage().props.ziggy.query.created_until)
    : ""
);

// Formatted Date
const formattedCreatedFrom = computed(() => {
  const year = createdFrom.value ? createdFrom.value.getFullYear() : "";
  const month = createdFrom.value ? createdFrom.value.getMonth() + 1 : "";
  const day = createdFrom.value ? createdFrom.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

const formattedCreatedUntil = computed(() => {
  const year = createdUntil.value ? createdUntil.value.getFullYear() : "";
  const month = createdUntil.value ? createdUntil.value.getMonth() + 1 : "";
  const day = createdUntil.value ? createdUntil.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  created_from: usePage().props.ziggy.query.created_from
    ? usePage().props.ziggy.query.created_from
    : formattedCreatedFrom,
  created_until: usePage().props.ziggy.query.created_until
    ? usePage().props.ziggy.query.created_until
    : formattedCreatedUntil,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("admin.products.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search = "";
  router.get(
    route("admin.products.index"),
    {
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Filtered By Only Created From
const filteredByCreatedFrom = () => {
  router.get(
    route("admin.products.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: formattedCreatedFrom.value,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => {
        isFilterBoxOpened.value = true;
      },
    }
  );
};

// Filtered By Only Created Until
const filteredByCreatedUntil = () => {
  router.get(
    route("admin.products.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: formattedCreatedUntil.value,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => {
        isFilterBoxOpened.value = true;
      },
    }
  );
};

// Handle Reset Filtered Date
const resetFilteredDate = () => {
  createdFrom.value = "";
  createdUntil.value = "";
  router.get(
    route("admin.products.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => (isFilterBoxOpened.value = false),
    }
  );
};

// Handle Query String Parameter
const handleQueryStringParameter = () => {
  router.get(
    route("admin.products.index"),
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Watching Search Box
watch(
  () => params.search,
  () => {
    if (params.search === "") {
      removeSearch();
    } else {
      handleSearch();
    }
  }
);

// Watching Perpage Select Box
watch(
  () => params.per_page,
  () => {
    handleQueryStringParameter();
  }
);

// Watching Created From Datepicker
watch(
  () => params.created_from,
  () => {
    if (params.created_from === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedFrom();
    }
  }
);

// Watching Created Unitl Datepicker
watch(
  () => params.created_until,
  () => {
    if (params.created_until === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedUntil();
    }
  }
);

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  handleQueryStringParameter();
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

// Handle Product Approved Or Disapproved
const handleStatus = async (product) => {
  const result = await swal({
    icon: "question",
    title: `Are you sure you want to set ${
      product.status === "pending" || product.status === "disapproved"
        ? "approve"
        : "disapprove"
    } this product?`,
    showCancelButton: true,
    confirmButtonText: `Yes, ${
      product.status === "pending" || product.status === "disapproved"
        ? "Approve"
        : "Disapprove"
    }!`,
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.products.handle.status", {
        product: product.slug,
        status:
          product.status === "pending" || product.status === "disapproved"
            ? "approved"
            : "disapproved",
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: params.created_from,
        created_until: params.created_until,
      }),
      {},
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

// Handle Product Delete
const handleProductDelete = async (productSlug) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete this product?",
    text: "You will be able to restore this product in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it!",
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.products.destroy", {
        product: productSlug,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: params.created_from,
        created_until: params.created_until,
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

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Product Permission
const productAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "product.add")
    : false;
});

// Product Detail Permission
const productDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.detail"
      )
    : false;
});

// Product Edit Permission
const productEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "product.edit")
    : false;
});

// Product Delete Permission
const productDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.delete"
      )
    : false;
});

// Product Trash List Permission
const productTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.trash.list"
      )
    : false;
});

// Product Control Permission
const productControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.control"
      )
    : false;
});

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: __(usePage().props.flash.successMessage),
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('PRODUCTS')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="productTrashList">
          <Link
            as="button"
            :href="route('admin.products.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
          >
            <TrashButton />
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Product Button -->
        <Link
          v-if="productAdd"
          as="button"
          :href="route('admin.products.create')"
          :data="{
            per_page: params.per_page,
          }"
        >
          <CreateButton>
            {{ __("ADD_PRODUCT") }}
          </CreateButton>
        </Link>

        <div class="flex items-center">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="search-input"
              :placeholder="__('SEARCH_BY_NAME')"
              v-model="params.search"
            />

            <i
              v-if="params.search"
              class="fa-solid fa-xmark remove-search"
              @click="removeSearch"
            ></i>
          </form>

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <select class="perpage-selectbox" v-model="params.per_page">
              <option value="" disabled>Select</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="75">75</option>
              <option value="100">100</option>
            </select>
          </div>

          <!-- Filter By Date -->
          <button
            @click="isFilterBoxOpened = !isFilterBoxOpened"
            class="filter-btn"
          >
            <span class="">
              <i class="fa-solid fa-filter"></i>
            </span>
          </button>

          <div
            v-if="isFilterBoxOpened"
            class="w-[400px] border border-gray-300 shadow-lg absolute bg-white top-64 right-10 z-30 px-5 py-4 rounded-md"
          >
            <div class="flex items-center justify-end">
              <span
                @click="isFilterBoxOpened = false"
                class="text-lg text-gray-500 hover:text-gray-800 cursor-pointer"
              >
                <i class="fa-solid fa-xmark"></i>
              </span>
            </div>
            <div class="w-full mb-6">
              <span class="font-bold text-sm text-gray-700 mb-5"
                >Created from</span
              >
              <div>
                <datepicker
                  class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                  :placeholder="__('SELECT_DATE')"
                  v-model="createdFrom"
                />
              </div>
            </div>
            <div class="w-full mb-3">
              <span class="font-bold text-sm text-gray-700 mb-5"
                >Created until</span
              >
              <div>
                <datepicker
                  class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                  :placeholder="__('SELECT_DATE')"
                  v-model="createdUntil"
                />
              </div>
            </div>

            <div
              v-if="params.created_from || params.created_until"
              class="w-full flex items-center"
            >
              <ResetFilterButton @click="resetFilteredDate" />
            </div>
          </div>
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

          <HeaderTh v-if="productEdit || productDelete || productDetail">
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

            <Td
              class="w-[550px]"
              v-if="
                productEdit || productDelete || productDetail || productControl
              "
            >
              <!-- Control Button -->
              <button
                v-if="productControl"
                @click="handleStatus(product)"
                class="text-sm px-5 py-2 border-[3px] font-semibold rounded-[4px] shadow-md text-white transition-all mr-3 my-1 group"
                type="button"
                :class="{
                  'bg-green-600  hover:bg-green-700 border-green-700':
                    product.status === 'pending' ||
                    product.status === 'disapproved',
                  'bg-orange-600  hover:bg-orange-700 border-orange-700':
                    product.status === 'approved',
                }"
              >
                <span
                  v-if="
                    product.status === 'pending' ||
                    product.status === 'disapproved'
                  "
                  class="group-hover:animate-pulse"
                >
                  <i class="fa-solid fa-check"></i>
                  {{ __("APPROVE") }}
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  {{ __("DISAPPROVE") }}
                </span>
              </button>

              <!-- Edit Button -->
              <Link
                v-if="productEdit"
                as="button"
                :href="route('admin.products.edit', product.slug)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
              >
                <EditButton />
              </Link>

              <!-- Delete Button -->
              <DeleteButton
                v-if="productDelete"
                @click="handleProductDelete(product.slug)"
              />

              <!-- Detail Button -->
              <Link
                v-if="productDetail"
                as="button"
                :href="route('admin.products.show', product.slug)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
              >
                <DetailButton />
              </Link>
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
  </AdminDashboardLayout>
</template>

