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
import { reactive, watch, inject } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

// Data From Controller
const props = defineProps({
  products: Object,
});

const swal = inject("$swal");

const handleSearchBox = () => {
  params.search = "";
};

// Handle Url Query Params
const params = reactive({
  search: null,
  page: props.products.current_page ? props.products.current_page : 1,
  per_page: props.products.per_page ? props.products.per_page : 10,
  sort: "id",
  direction: "desc",
});

// Watch Search Form
watch(
  () => params.search,
  (current, previous) => {
    router.get(
      "/admin/products",
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
      "/admin/products",
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
    "/admin/products",
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

// Handle Product Delete
const handleDelete = async (productSlug) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete this product?",
    text: "You will be able to restore this product in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.products.destroy", {
        product: productSlug,
        page: props.products.current_page,
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

// Successful Message
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
        <!-- Breadcrumb  -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div>
          <Link
            as="button"
            :href="route('admin.products.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Add Proudct Button -->
        <Link
          as="button"
          :href="route('admin.products.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          <i class="fa-sharp fa-solid fa-plus cursor-pointer"></i>
          Add Product</Link
        >
        <!-- Search Form -->
        <div class="flex items-center">
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

          <!-- PerPage Dropdown  -->
          <div class="ml-5">
            <select
              class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="params.per_page"
            >
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

      <!-- Product Table -->
      <TableContainer>
        <!-- Table Header  -->
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

        <!-- Table Body -->
        <tbody v-if="products.data.length">
          <Tr v-for="product in products.data" :key="product.id">
            <BodyTh>{{ product.id }}</BodyTh>
            <Td>
              <img
                :src="product.image"
                class="h-[50px] rounded-sm object-cover shadow-lg ring-2 ring-slate-300"
                alt=""
              />
            </Td>
            <Td>{{ product.name }}</Td>
            <Td>{{ product.qty }}</Td>
            <Td>$ {{ product.price }}</Td>
            <Td>
              <span
                v-if="product.discount"
                class="bg-green-200 text-green-600 py-1 px-3 rounded-md"
              >
                {{
                  (
                    ((product.price - product.discount) / product.price) *
                    100
                  ).toFixed(1)
                }}%
              </span>
              <span
                v-if="!product.discount"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-md"
              >
                No Discount
              </span>
            </Td>
            <Td>
              <ActiveStatus v-if="product.status == 'active'">
                {{ product.status }}
              </ActiveStatus>
              <InactiveStatus v-if="product.status == 'inactive'">
                {{ product.status }}
              </InactiveStatus>
            </Td>
            <Td>{{ product.created_at }}</Td>
            <Td>
              <Link
                as="button"
                :href="route('admin.products.edit', product.slug)"
                :data="{
                  page: props.products.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-edit"></i>
                Edit
              </Link>
              <button
                @click="handleDelete(product.slug)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
              <!-- <Link
                as="button"
                :href="route('admin.products.show', product.slug)"
                :data="{
                  page: props.products.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-emerald-600 text-white hover:bg-emerald-700 my-1"
              >
                <i class="fa-solid fa-eye"></i>
                Details
              </Link> -->
              <button
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-sky-600 text-white hover:bg-sky-700 my-1 mr-3"
              >
                <i class="fa-solid fa-eye"></i>
                Details
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!products.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="products.links" />
    </div>
  </AdminDashboardLayout>
</template>

