<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SuggestionBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

const props = defineProps({
  suggestions: Object,
});

const swal = inject("$swal");

const suggestionTrashList = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "suggestion.trash.list"
      )
    : false;
});

const suggestionDetail = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "suggestion.detail"
      )
    : false;
});

const suggestionDelete = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "suggestion.delete"
      )
    : false;
});

// formattedString() {
//       // Split the string at each underscore
//       const words = this.stringToFormat.split('_');

//       // Capitalize the first letter of each word
//       const capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));

//       // Join the words back together with a space in between
//       const formattedString = capitalizedWords.join(' ');

//       return formattedString;
//     },

const formatSuggestionType = (suggestionType) => {
  const words = suggestionType.split("_");
  const capitalizedWords = words.map(
    (word) => word.charAt(0).toUpperCase() + word.slice(1)
  );
  const formattedString = capitalizedWords.join(" ");

  return formattedString;
};

const params = reactive({
  search: null,
  page: props.suggestions.current_page ? props.suggestions.current_page : 1,
  per_page: props.suggestions.per_page ? props.suggestions.per_page : 10,
  sort: "id",
  direction: "desc",
});

const handleSearchBox = () => {
  params.search = "";
};

watch(
  () => params.search,
  () => {
    router.get(
      route("admin.suggestions.index"),
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
      route("admin.suggestions.index"),
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
    route("admin.suggestions.index"),
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

const handleDelete = async (suggestion) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete this suggestion?",
    text: "You will be able to restore this suggestion in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.suggestions.destroy", {
        suggestion: suggestion.id,
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
    <Head title="Suggestions" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <Breadcrumb />

        <div v-if="suggestionTrashList">
          <Link
            as="button"
            :href="route('admin.suggestions.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
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
          <HeaderTh @click="updateSorting('email')">
            Email
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
          <HeaderTh @click="updateSorting('type')">
            Suggestion Type
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'type',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'type',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'type',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'type',
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
          <HeaderTh v-if="suggestionDelete || suggestionDetail">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="suggestions.data.length">
          <Tr v-for="suggestion in suggestions.data" :key="suggestion.id">
            <BodyTh>{{ suggestion.id }}</BodyTh>
            <Td>{{ suggestion.email }}</Td>
            <Td class="capitalize">{{
              formatSuggestionType(suggestion.type)
            }}</Td>
            <Td>{{ suggestion.created_at }}</Td>
            <Td v-if="suggestionDelete || suggestionDetail">
              <button
                v-if="suggestionDelete"
                @click="handleDelete(suggestion)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
              <Link
                v-if="suggestionDetail"
                as="button"
                :href="route('admin.suggestions.show', suggestion.id)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-sky-600 text-white hover:bg-sky-700 my-1"
              >
                <i class="fa-solid fa-eye"></i>
                Details
              </Link>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <NotAvaliableData v-if="!suggestions.data.length" />

      <Pagination class="mt-6" :links="suggestions.links" />
    </div>
  </AdminDashboardLayout>
</template>

