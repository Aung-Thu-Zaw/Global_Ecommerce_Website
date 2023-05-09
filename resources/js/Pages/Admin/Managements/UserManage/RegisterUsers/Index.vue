<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/UserManage/Breadcrumb.vue";
import SearchForm from "@/Components/Form/SearchForm.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Table/ActiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { reactive, watch, inject, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  users: Object,
});

const params = reactive({
  search: null,
  page: props.users.current_page ? props.users.current_page : 1,
  per_page: props.users.per_page ? props.users.per_page : 10,
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
      "/admin/user-manage/register-users",
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
      "/admin/user-manage/register-users",
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
    "/admin/user-manage/register-users",
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

const swal = inject("$swal");

const currentTime = new Date();
const threshold = 1000 * 60 * 5; //5minutes in millseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "Online" : "Offline";
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="All Register Users" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Vendor Breadcrumb -->
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
            <span class="ml-1 font-medium text-gray-500 md:ml-2"
              >All Register Users</span
            >
          </div>
        </li>
      </Breadcrumb>

      <!-- Search Input Form -->
      <div class="flex items-center justify-end mb-5">
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

      <!-- Table  -->
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
          <HeaderTh>Avatar</HeaderTh>
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
          <HeaderTh @click="updateSorting('email')">
            Email Address
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'email',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'email',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'email',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'email',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('phone')">
            Phone No
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'phone',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'phone',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'phone',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'phone',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Role </HeaderTh>
          <HeaderTh> Status </HeaderTh>
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

        <tbody v-if="users.data.length">
          <Tr v-for="user in users.data" :key="user.id">
            <BodyTh>{{ user.id }}</BodyTh>
            <Td>
              <img :src="user.avatar" alt="" class="h-[50px] object-cover" />
            </Td>
            <Td>{{ user.name }}</Td>
            <Td>{{ user.email }}</Td>
            <Td>{{ user.phone }}</Td>
            <Td>
              <span
                class="capitalize bg-sky-200 text-sky-500 px-3 py-1 font-bold text-sm rounded-md"
              >
                {{ user.role }}
              </span>
            </Td>
            <Td>
              <span
                class="capitalize px-3 py-1 font-bold text-sm rounded-md"
                :class="{
                  'bg-green-200 text-green-500':
                    status(user.last_activity) == 'Online',
                  'bg-red-200 text-red-500':
                    status(user.last_activity) == 'Offline',
                }"
              >
                <i class="fa-solid fa-circle animate-pulse text-[.6rem]"></i>
                {{ status(user.last_activity) }}
              </span>
            </Td>
            <Td>{{ user.created_at }}</Td>
            <Td>
              <!-- <button
                @click="handleInactive(user.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3"
              >
                <i class="fa-solid fa-xmark"></i>
                Inactive
              </button>
              <Link
                as="button"
                :href="route('admin.vendors.active.show', user.id)"
                :data="{
                  page: props.users.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-sky-600 text-white hover:bg-sky-700"
              >
                <i class="fa-solid fa-eye"></i>
                Details
              </Link> -->
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!users.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="users.links" />
    </div>
  </AdminDashboardLayout>
</template>

