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
import SearchForm from "@/Components/Form/SearchForm.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Categories/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { reactive, watch, inject } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

defineProps({
  categories: Object,
});

const swal = inject("$swal");

const params = reactive({
  search: null,
});

const handleDelete = async (id) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to move it to the trash?",
    text: "You will be able to revert this action!",
    showCancelButton: true,
    confirmButtonText: "Yes, remove it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(route("admin.categories.destroy", id));
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
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
    <Head title="Category" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Category Breadcrumb -->

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
                >Category</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            as="button"
            :href="route('admin.categories.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <Link
          :href="route('admin.categories.create')"
          class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          <i class="fa-sharp fa-solid fa-plus cursor-pointer"></i>
          Add Category</Link
        >
        <!-- Search Input Form -->
        <SearchForm />
      </div>

      <TableContainer>
        <TableHeader>
          <HeaderTh> No </HeaderTh>
          <HeaderTh> Image </HeaderTh>
          <HeaderTh> Name </HeaderTh>
          <HeaderTh> Status </HeaderTh>
          <HeaderTh> Date </HeaderTh>
          <HeaderTh> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="categories.data.length">
          <Tr v-for="category in categories.data" :key="category.id">
            <BodyTh>{{ category.id }}</BodyTh>
            <Td>
              <img
                :src="category.image"
                class="w-[50px] h-[50px] rounded-full object-cover shadow-lg ring-2 ring-slate-300"
                alt=""
              />
            </Td>
            <Td>{{ category.name }}</Td>
            <Td>
              <ActiveStatus v-if="category.status == 'show'">
                {{ category.status }}
              </ActiveStatus>
              <InactiveStatus v-if="category.status == 'hide'">
                {{ category.status }}
              </InactiveStatus>
            </Td>
            <Td>{{ category.created_date }}</Td>
            <Td>
              <Link
                as="button"
                :href="route('admin.categories.edit', category.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-edit"></i>
                Edit
              </Link>
              <button
                @click="handleDelete(category.id)"
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
      <NotAvaliableData v-if="!categories.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="categories.links" />
    </div>
  </AdminDashboardLayout>
</template>



