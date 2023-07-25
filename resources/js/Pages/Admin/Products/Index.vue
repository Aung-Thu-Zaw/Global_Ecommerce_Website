<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import NoDiscountStatus from "@/Components/Status/NoDiscountStatus.vue";
import DiscountStatus from "@/Components/Status/DiscountStatus.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head, router, usePage } from "@inertiajs/vue3";
import { reactive, watch, inject, computed } from "vue";

// Define the props
const props = defineProps({
  products: Object,
});

// Define Alert Variables
const swal = inject("$swal");

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
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
    },
    {
      replace: true,
      preserveState: true,
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

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  handleQueryStringParameter();
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
      }),
      {
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
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

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Products" />
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
            class="trash-btn group"
          >
            <span class="group-hover:animate-pulse">
              <i class="fa-solid fa-trash-can-arrow-up"></i>
              Trash
            </span>
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
          class="add-btn"
        >
          <span>
            <i class="fa-solid fa-file-circle-plus"></i>
            Add Product
          </span>
        </Link>

        <div class="flex items-center">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="search-input"
              placeholder="Search by name"
              v-model="params.search"
            />

            <i
              v-if="params.search"
              class="fa-solid fa-xmark remove-search"
              @click="handleSearchBox"
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
        </div>
      </div>

      <!-- Product Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Image </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            Name
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('price')">
            Price
            <SortingArrows :params="params" sort="price" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount')">
            Discount (%)
            <SortingArrows :params="params" sort="discount" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="productEdit || productDelete || productDetail">
            Action
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

            <Td>
              {{ product.name }}
            </Td>

            <Td> $ {{ formattedAmount(product.price) }} </Td>

            <Td>
              <DiscountStatus
                :price="product.price"
                :discount="product.discount"
              />

              <NoDiscountStatus v-if="!product.discount" />
            </Td>

            <Td>
              {{ product.created_at }}
            </Td>

            <Td v-if="productEdit || productDelete || productDetail">
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
                class="edit-btn group"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-edit"></i>
                  Edit
                </span>
              </Link>

              <!-- Delete Button -->
              <button
                v-if="productDelete"
                @click="handleProductDelete(product.slug)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>

              <!-- Detail Button -->
              <Link
                v-if="productDetail"
                as="button"
                :href="route('admin.products.show', product.slug)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                }"
                class="detail-btn group"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-eye"></i>
                  Details
                </span>
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

