<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Table/ActiveStatus.vue";
import InactiveStatus from "@/Components/Table/InactiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Products/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { inject, reactive, watch } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

// Data From Controller
const props = defineProps({
  trashProducts: Object,
});

const swal = inject("$swal");
const handleSearchBox = () => {
  params.search = "";
};

// Handle Url Query Params
const params = reactive({
  search: null,
  page: props.trashProducts.current_page ? props.trashProducts.current_page : 1,
  per_page: props.trashProducts.per_page ? props.trashProducts.per_page : 10,
  sort: "id",
  direction: "desc",
});

// Watch Search Form
watch(
  () => params.search,
  (current, previous) => {
    router.get(
      "/admin/products/trash",
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
  }
);

// Watch Perpage Dropdown
watch(
  () => params.per_page,
  (current, previous) => {
    router.get(
      "/admin/products/trash",
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
  }
);

// Handle Sorting With Column Arrow
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    "/admin/products/trash",
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    { replace: true, preserveState: true }
  );
};

// Handle Product Restore
const handleRestore = async (trashProductId) => {
  const result = await swal({
    icon: "info",
    title: "Are you sure you want to restore this product?",
    showCancelButton: true,
    confirmButtonText: "Yes, restore",
    confirmButtonColor: "#4d9be9",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.products.restore", {
        id: trashProductId,
        page: props.trashProducts.current_page,
        per_page: params.per_page,
      })
    );
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

// Handle Product Delete
const handleDelete = async (trashProductId) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete it from the trash?",
    text: "Product in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it !",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.products.forceDelete", {
        id: trashProductId,
        page: props.trashProducts.current_page,
        per_page: params.per_page,
      })
    );
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

const handlePermanentlyDelete = async () => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete it from the trash?",
    text: "All products in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it !",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.get(
      route("admin.products.permanentlyDelete", {
        page: props.trashProducts.current_page,
        per_page: params.per_page,
      })
    );
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Trash products" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb  -->
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
                >Trash</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back Button -->
        <div>
          <Link
            :href="route('admin.products.index')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Form -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="rounded-md border-2 border-slate-300 text-sm p-3 w-full"
            placeholder="Search"
            v-model="params.search"
          />

          <i
            v-if="params.search"
            class="fa-solid fa-xmark absolute top-4 right-5 text-slate-600 cursor-pointer"
            @click="handleSearchBox"
          ></i>
        </form>
        <!-- PerPage Dropdown -->
        <div class="ml-5">
          <select
            class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="params.per_page"
          >
            <option value="" selected disabled>Select</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>

      <!-- Auto delete description and button  -->
      <p class="text-left text-sm font-bold mb-2 text-warning-600">
        Products in the Trash will be automatically deleted after 60 days.
        <button
          @click="handlePermanentlyDelete"
          class="text-primary-500 rounded-md px-2 py-1 hover:bg-primary-200 hover:text-primary-600 transition-all hover:animate-bounce"
        >
          Empty the trash now
        </button>
      </p>

      <!-- Trash Product Table -->
      <TableContainer>
        <!-- Table Header -->
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'id',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'id',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Image </HeaderTh>
          <HeaderTh @click="updateSorting('name')">
            Name
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'name',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'name',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'name',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'name',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('qty')">
            Qty
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'qty',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'qty',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'qty',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'qty',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('price')">
            Price
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'price',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'price',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'price',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'price',
              }"
            ></i>
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount')">
            Discount (%)
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'discount',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'discount',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'discount',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'discount',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('status')">
            Status
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'status',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'status',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'status',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'status',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'created_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'created_at',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'created_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'created_at',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Action </HeaderTh>
        </TableHeader>

        <!-- Table Body  -->
        <tbody v-if="trashProducts.data.length">
          <Tr v-for="trashProduct in trashProducts.data" :key="trashProduct.id">
            <BodyTh>{{ trashProduct.id }}</BodyTh>
            <Td>
              <img
                :src="trashProduct.image"
                class="w-[50px] h-[50px] rounded-sm object-cover shadow-lg ring-2 ring-slate-300"
                alt=""
              />
            </Td>
            <Td>{{ trashProduct.name }}</Td>
            <Td>{{ trashProduct.qty }}</Td>
            <Td>$ {{ trashProduct.price }}</Td>
            <Td>
              <span
                v-if="trashProduct.discount"
                class="bg-green-200 text-green-600 py-1 px-3 rounded-md"
              >
                {{
                  (
                    ((trashProduct.price - trashProduct.discount) /
                      trashProduct.price) *
                    100
                  ).toFixed(1)
                }}%
              </span>
              <span
                v-if="!trashProduct.discount"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-md"
              >
                No Discount
              </span>
            </Td>
            <Td>
              <ActiveStatus v-if="trashProduct.status == 'active'">
                {{ trashProduct.status }}
              </ActiveStatus>
              <InactiveStatus v-if="trashProduct.status == 'inactive'">
                {{ trashProduct.status }}
              </InactiveStatus>
            </Td>
            <Td>{{ trashProduct.created_at }}</Td>
            <Td>
              <button
                @click="handleRestore(trashProduct.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-recycle"></i>
                Restore
              </button>
              <button
                @click="handleDelete(trashProduct.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-trash"></i>
                Delete Forever
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!trashProducts.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="trashProducts.links" />
    </div>
  </AdminDashboardLayout>
</template>


