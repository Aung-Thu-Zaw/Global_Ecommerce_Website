<script setup>
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BannerBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  productBanners: Object,
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
    route("admin.product-banners.index"),
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
    route("admin.product-banners.index"),
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
    route("admin.product-banners.index"),
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

// Handle Show Product Banner
const handleShow = async (hideProductBannerId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to show this product banner?",
    showCancelButton: true,
    confirmButtonText: "Yes, Show",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.product-banners.show", {
        product_banner: hideProductBannerId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
            });
          }
          if (usePage().props.flash.errorMessage) {
            swal({
              icon: "error",
              title: usePage().props.flash.errorMessage,
            });
          }
        },
      }
    );
  }
};

// Handle Hide Product Banner
const handleHide = async (showProductBannerId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to hide this product banner?",
    showCancelButton: true,
    confirmButtonText: "Yes, Hide",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.product-banners.hide", {
        product_banner: showProductBannerId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
        preserveScroll: true,
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

// Handle Delete Banner
const handleDeleteProductBanner = async (productBannerId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete this product banner?",
    text: "You will be able to restore this product banner in the trash!",
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
      route("admin.product-banners.destroy", {
        product_banner: productBannerId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {
        preserveScroll: true,
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

// Create New Banner Permission
const bannerAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "banner.add")
    : false;
});

// Banner Control Permission
const bannerControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "banner.control"
      )
    : false;
});

// Banner Edit Permission
const bannerEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "banner.edit")
    : false;
});

// Banner Delete Permission
const bannerDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "banner.delete"
      )
    : false;
});

// Banner Trash List Permission
const bannerTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "banner.trash.list"
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
    <Head title="Product Banners" />

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
                >Product Banners</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Trash Button -->
        <div v-if="bannerTrashList">
          <Link
            as="button"
            :href="route('admin.product-banners.trash')"
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
        <!-- Create Product Banner Button -->
        <Link
          v-if="bannerAdd"
          as="button"
          :href="route('admin.product-banners.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="add-btn"
        >
          <span>
            <i class="fa-solid fa-file-circle-plus"></i>
            Add Product Banner
          </span>
        </Link>

        <div class="flex items-center">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="search-input"
              placeholder="Search by url"
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
        </div>
      </div>

      <!-- Product Banner Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Image </HeaderTh>

          <HeaderTh @click="updateSorting('url')">
            URL
            <SortingArrows :params="params" sort="url" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            Status
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="bannerEdit || bannerDelete || bannerControl">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="productBanners.data.length">
          <Tr
            v-for="productBanner in productBanners.data"
            :key="productBanner.id"
          >
            <BodyTh>
              {{ productBanner.id }}
            </BodyTh>
            <Td>
              <img :src="productBanner.image" class="image" />
            </Td>

            <Td>
              {{ productBanner.url }}
            </Td>

            <Td>
              <ActiveStatus v-if="productBanner.status == 'show'">
                {{ productBanner.status }}
              </ActiveStatus>
              <InactiveStatus v-if="productBanner.status == 'hide'">
                {{ productBanner.status }}
              </InactiveStatus>
            </Td>

            <Td>
              {{ productBanner.created_at }}
            </Td>

            <Td v-if="bannerEdit || bannerDelete || bannerControl">
              <!-- Show Button -->
              <button
                v-if="productBanner.status == 'hide' && bannerControl"
                @click="handleShow(productBanner.id)"
                class="show-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-eye"></i>
                  Show
                </span>
              </button>

              <!-- Hide Button -->
              <button
                v-if="productBanner.status == 'show' && bannerControl"
                @click="handleHide(productBanner.id)"
                class="hide-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-eye-slash"></i>
                  Hide
                </span>
              </button>

              <!-- Edit Button -->
              <Link
                v-if="bannerEdit"
                as="button"
                :href="route('admin.product-banners.edit', productBanner.id)"
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
                v-if="bannerDelete"
                @click="handleDeleteProductBanner(productBanner.id)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Product Banner Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!productBanners.data.length" />

      <!-- Pagination -->
      <div v-if="productBanners.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ productBanners.from }} - {{ productBanners.to }} of
          {{ productBanners.total }}
        </p>
        <Pagination :links="productBanners.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

