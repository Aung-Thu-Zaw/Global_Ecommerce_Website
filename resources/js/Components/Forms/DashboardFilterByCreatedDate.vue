<script setup>
import ResetFilterButton from "@/Components/Buttons/ResetFilterButton.vue";
import datepicker from "vue3-datepicker";
import { router, usePage } from "@inertiajs/vue3";
import { watch, ref, reactive, computed } from "vue";

const props = defineProps({
  href: String,
});

const isFilterBoxOpened = ref(false);
const createdFrom = ref(
  usePage().props.ziggy.query.created_from
    ? new Date(usePage().props.ziggy.query.created_from)
    : ""
);
const createdUntil = ref(
  usePage().props.ziggy.query.created_until
    ? new Date(usePage().props.ziggy.query.created_until)
    : ""
);

// Formatted Date
const formattedCreatedFrom = computed(() => {
  const year = createdFrom.value ? createdFrom.value.getFullYear() : "";
  const month = createdFrom.value ? createdFrom.value.getMonth() + 1 : "";
  const day = createdFrom.value ? createdFrom.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

const formattedCreatedUntil = computed(() => {
  const year = createdUntil.value ? createdUntil.value.getFullYear() : "";
  const month = createdUntil.value ? createdUntil.value.getMonth() + 1 : "";
  const day = createdUntil.value ? createdUntil.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  created_from: usePage().props.ziggy.query.created_from
    ? usePage().props.ziggy.query.created_from
    : formattedCreatedFrom,
  created_until: usePage().props.ziggy.query.created_until
    ? usePage().props.ziggy.query.created_until
    : formattedCreatedUntil,
});

// Filtered By Only Created From
const filteredByCreatedFrom = () => {
  router.get(
    route(props.href),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: formattedCreatedFrom.value,
      created_until: params.created_until,
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

// Filtered By Only Created Until
const filteredByCreatedUntil = () => {
  router.get(
    route(props.href),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: formattedCreatedUntil.value,
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
  createdFrom.value = "";
  createdUntil.value = "";
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

// Watching Created From Datepicker
watch(
  () => params.created_from,
  () => {
    if (params.created_from === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedFrom();
    }
  }
);

// Watching Created Unitl Datepicker
watch(
  () => params.created_until,
  () => {
    if (params.created_until === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedUntil();
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
      <span class="font-bold text-sm text-gray-700 mb-5">Created from</span>
      <div>
        <datepicker
          class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
          :placeholder="__('SELECT_DATE')"
          v-model="createdFrom"
        />
      </div>
    </div>
    <div class="w-full mb-3">
      <span class="font-bold text-sm text-gray-700 mb-5">Created until</span>
      <div>
        <datepicker
          class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
          :placeholder="__('SELECT_DATE')"
          v-model="createdUntil"
        />
      </div>
    </div>

    <div
      v-if="params.created_from || params.created_until"
      class="w-full flex items-center"
    >
      <ResetFilterButton @click="resetFilteredDate" />
    </div>
  </div>
</template>
