<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Collections/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { reactive, watch, inject } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  collections: Object,
});

const swal = inject("$swal");

const params = reactive({
  search: null,
  page: props.collections.current_page ? props.collections.current_page : 1,
  per_page: props.collections.per_page ? props.collections.per_page : 10,
  sort: "id",
  direction: "desc",
});

const handleSearchBox = () => {
  params.search = "";
};

watch(
  () => params.search,
  (current, previous) => {
    router.get(
      "/admin/collections",
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

watch(
  () => params.per_page,
  (current, previous) => {
    router.get(
      "/admin/collections",
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

const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    "/admin/collections",
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

const handleDelete = async (collection) => {
  if (collection.products.length > 0) {
    const result = await swal({
      icon: "error",
      title:
        "You can't delete this collection because this collection have products?",
      text: "If you click 'Delete, whatever!' button products will be automatically deleted.You will be able to restore this collection in the trash!",
      showCancelButton: true,
      confirmButtonText: "Delete, whatever!",
      confirmButtonColor: "#ef4444",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });
    if (result.isConfirmed) {
      router.delete(
        route("admin.collections.destroy", {
          collection: collection.slug,
          page: props.collections.current_page,
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
  } else {
    const result = await swal({
      icon: "warning",
      title: "Are you sure you want to delete this collection?",
      text: "You will be able to restore this collection in the trash!",
      showCancelButton: true,
      confirmButtonText: "Yes, delete it!",
      confirmButtonColor: "#ef4444",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });

    if (result.isConfirmed) {
      router.delete(
        route("admin.collections.destroy", {
          collection: collection.slug,
          page: props.collections.current_page,
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
  }
};

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Collections" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Category Breadcrumb -->
      <div class="flex items-center justify-between mb-10">
        <Breadcrumb />

        <div>
          <Link
            as="button"
            :href="route('admin.collections.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <Link
          :href="route('admin.collections.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          <i class="fa-sharp fa-solid fa-plus cursor-pointer"></i>
          Add Collection</Link
        >
        <!-- Search Input Form -->
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

      <TableContainer>
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
          <HeaderTh @click="updateSorting('title')">
            Title
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'title',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'title',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'title',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'title',
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

        <tbody v-if="collections.data.length">
          <Tr v-for="collection in collections.data" :key="collection.id">
            <BodyTh>{{ collection.id }}</BodyTh>
            <Td>
              <img
                :src="collection.image"
                class="h-[50px] rounded-sm object-cover shadow-lg ring-2 ring-slate-300"
                alt=""
              />
            </Td>
            <Td>{{ collection.title }}</Td>
            <Td>{{ collection.created_at }}</Td>
            <Td>
              <Link
                as="button"
                :href="route('admin.collections.edit', collection.slug)"
                :data="{
                  page: props.collections.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-edit"></i>
                Edit
              </Link>
              <button
                @click="handleDelete(collection)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!collections.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="collections.links" />
    </div>
  </AdminDashboardLayout>
</template>

