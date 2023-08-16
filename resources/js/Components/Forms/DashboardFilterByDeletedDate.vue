<script setup>
import ResetFilterButton from "@/Components/Buttons/ResetFilterButton.vue";
import datepicker from "vue3-datepicker";
import { router, usePage } from "@inertiajs/vue3";
import { watch, ref, reactive, computed } from "vue";

const props = defineProps({
  href: String,
});

const isFilterBoxOpened = ref(false);
const deletedFrom = ref(
  usePage().props.ziggy.query.deleted_from
    ? new Date(usePage().props.ziggy.query.deleted_from)
    : ""
);
const deletedUntil = ref(
  usePage().props.ziggy.query.deleted_until
    ? new Date(usePage().props.ziggy.query.deleted_until)
    : ""
);

// Formatted Date
const formattedDeletedFrom = computed(() => {
  const year = deletedFrom.value ? deletedFrom.value.getFullYear() : "";
  const month = deletedFrom.value ? deletedFrom.value.getMonth() + 1 : "";
  const day = deletedFrom.value ? deletedFrom.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

const formattedDeletedUntil = computed(() => {
  const year = deletedUntil.value ? deletedUntil.value.getFullYear() : "";
  const month = deletedUntil.value ? deletedUntil.value.getMonth() + 1 : "";
  const day = deletedUntil.value ? deletedUntil.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  deleted_from: usePage().props.ziggy.query.deleted_from
    ? usePage().props.ziggy.query.deleted_from
    : formattedDeletedFrom,
  deleted_until: usePage().props.ziggy.query.deleted_until
    ? usePage().props.ziggy.query.deleted_until
    : formattedDeletedUntil,
});

// Filtered By Only Deleted From
const filteredByDeletedFrom = () => {
  router.get(
    route(props.href),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      deleted_from: formattedDeletedFrom.value,
      deleted_until: params.deleted_until,
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

// Filtered By Only Deleted Until
const filteredByDeletedUntil = () => {
  router.get(
    route(props.href),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      deleted_from: params.deleted_from,
      deleted_until: formattedDeletedUntil.value,
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
  deletedFrom.value = "";
  deletedUntil.value = "";
  router.get(
    route(props.href),
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

// Watching Deleted From Datepicker
watch(
  () => params.deleted_from,
  () => {
    if (params.deleted_from === "") {
      resetFilteredDate();
    } else {
      filteredByDeletedFrom();
    }
  }
);

// Watching Deleted Unitl Datepicker
watch(
  () => params.deleted_until,
  () => {
    if (params.deleted_until === "") {
      resetFilteredDate();
    } else {
      filteredByDeletedUntil();
    }
  }
);
</script>


<template>
  <button
    @click="isFilterBoxOpened = !isFilterBoxOpened"
    class="text-sm border px-5 py-3 rounded-md ml-5 border-slate-300 hover:bg-gray-50 text-gray-600 hover:text-gray-700"
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
      <span class="font-bold text-sm text-gray-700 mb-5">Deleted from</span>
      <div>
        <datepicker
          class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
          :placeholder="__('SELECT_DATE')"
          v-model="deletedFrom"
        />
      </div>
    </div>
    <div class="w-full mb-3">
      <span class="font-bold text-sm text-gray-700 mb-5">Deleted until</span>
      <div>
        <datepicker
          class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
          :placeholder="__('SELECT_DATE')"
          v-model="deletedUntil"
        />
      </div>
    </div>

    <div
      v-if="params.deleted_from || params.deleted_until"
      class="w-full flex items-center"
    >
      <ResetFilterButton @click="resetFilteredDate" />
    </div>
  </div>
</template>
