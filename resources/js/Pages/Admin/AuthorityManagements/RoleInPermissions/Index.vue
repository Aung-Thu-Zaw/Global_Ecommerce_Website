<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RoleInPermissionBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

const props = defineProps({
  rolesWithPermissions: Object,
});

const swal = inject("$swal");

const handleSearchBox = () => {
  params.search = "";
};

const roleInPermissionsAdd = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "role-in-permissions.add"
      )
    : false;
});

const roleInPermissionsEdit = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "role-in-permissions.edit"
      )
    : false;
});

const roleInPermissionsDelete = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "role-in-permissions.delete"
      )
    : false;
});

const params = reactive({
  search: null,
  page: props.rolesWithPermissions.current_page
    ? props.rolesWithPermissions.current_page
    : 1,
  per_page: props.rolesWithPermissions.per_page
    ? props.rolesWithPermissions.per_page
    : 10,
  sort: "id",
  direction: "desc",
});

watch(
  () => params.search,
  () => {
    router.get(
      route("admin.role-in-permissions.index"),
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
  () => {
    router.get(
      route("admin.role-in-permissions.index"),
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
    route("admin.role-in-permissions.index"),
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

const handleDelete = async (role) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete this role in permissions?",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.role-in-permissions.destroy", {
        role: role.id,
        page: params.page,
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

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Role In Permissions" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <Breadcrumb />
      </div>

      <div class="mb-5 flex items-center justify-between">
        <Link
          v-if="roleInPermissionsAdd"
          as="button"
          :href="route('admin.role-in-permissions.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          <i class="fa-sharp fa-solid fa-plus cursor-pointer"></i>
          Add Role In Permissions</Link
        >
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
          <HeaderTh @click="updateSorting('name')">
            Role Name
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
          <HeaderTh>Permissions</HeaderTh>
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
          <HeaderTh v-if="roleInPermissionsEdit || roleInPermissionsDelete">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="rolesWithPermissions.data.length">
          <Tr
            v-for="roleWithPermissions in rolesWithPermissions.data"
            :key="roleWithPermissions.id"
          >
            <BodyTh v-if="roleWithPermissions.permissions.length">{{
              roleWithPermissions.id
            }}</BodyTh>
            <Td v-if="roleWithPermissions.permissions.length">{{
              roleWithPermissions.name
            }}</Td>
            <Td
              v-if="roleWithPermissions.permissions.length"
              class="w-[1000px] flex items-start"
            >
              <span
                v-for="permission in roleWithPermissions.permissions"
                :key="permission.id"
                class="bg-blue-700 text-white rounded-full px-3 py-1 mr-3 my-2"
              >
                {{ permission.name }}
              </span>
            </Td>
            <Td v-if="roleWithPermissions.permissions.length">{{
              roleWithPermissions.created_at
            }}</Td>
            <Td
              v-if="
                roleWithPermissions.permissions.length &&
                (roleInPermissionsEdit || roleInPermissionsDelete)
              "
            >
              <Link
                v-if="roleInPermissionsEdit"
                as="button"
                :href="
                  route(
                    'admin.role-in-permissions.edit',
                    roleWithPermissions.id
                  )
                "
                :data="{
                  page: props.rolesWithPermissions.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-edit"></i>
                Edit
              </Link>
              <button
                v-if="roleInPermissionsDelete"
                @click="handleDelete(roleWithPermissions)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <NotAvaliableData v-if="!rolesWithPermissions.data.length" />

      <Pagination class="mt-6" :links="rolesWithPermissions.links" />
    </div>
  </AdminDashboardLayout>
</template>

