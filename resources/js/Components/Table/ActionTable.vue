<script setup>
import Checkbox from "@/Components/Forms/Fields/Checkbox.vue";
import { ref, watch } from "vue";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});

const isSelectedAll = ref(false);
const selectedItems = ref([]);

watch(selectedItems, () => {
  isSelectedAll.value = selectedItems.value.length === props.items.length;
});

const selectAllItems = () => {
  if (isSelectedAll.value) {
    selectedItems.value = props.items.map((item) => item.id);
  } else {
    selectedItems.value = [];
  }
};

const selectAll = () => {
  selectedItems.value = props.items.map((item) => item.id);
};

const deselectAll = () => {
  selectedItems.value = [];
};
</script>

<template>
  <div
    v-show="selectedItems.length !== 0 && items.length !== 0"
    class="px-5 py-3 bg-[#F9FAFB] text-sm flex items-center justify-between w-full"
  >
    <div class="flex items-center space-x-1">
      <span class="font-semibold text-slate-700">
        {{ selectedItems.length }} records selected
      </span>

      <div class="hs-dropdown relative inline-flex">
        <button
          id="hs-dropdown-custom-icon-trigger"
          type="button"
          class="hs-dropdown-toggle p-2 inline-flex justify-center items-center gap-2 font-medium text-gray-700 align-middle transition-all text-sm"
        >
          <svg
            class="w-4 h-4 text-gray-600"
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            fill="currentColor"
            viewBox="0 0 16 16"
          >
            <path
              d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"
            />
          </svg>
        </button>

        <div
          class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem] bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-gray-800 dark:border dark:border-gray-700"
          aria-labelledby="hs-dropdown-custom-icon-trigger"
        >
          <slot name="actions" :selectedItems="selectedItems"></slot>
        </div>
      </div>
    </div>
    <div class="flex items-center space-x-5 font-bold">
      <span
        v-show="selectedItems.length < items.length"
        @click="selectAll"
        class="text-blue-600 cursor-pointer hover:bg-blue-200 px-2 py-1.5 rounded-md"
      >
        Select all
      </span>
      <button
        type="button"
        @click="deselectAll"
        class="text-red-600 cursor-pointer hover:bg-red-200 px-2 py-1.5 rounded-md"
      >
        Deselect all
      </button>
    </div>
  </div>
  <table class="w-full text-sm text-left text-gray-500">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
      <tr>
        <th v-show="items.length !== 0" class="pl-4">
          <Checkbox v-model:checked="isSelectedAll" @change="selectAllItems" />
        </th>
        <slot name="table-header"></slot>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(item, index) in items"
        :key="item.id"
        :class="{
          'border-b': index !== items.length - 1,
        }"
      >
        <td class="pl-4">
          <Checkbox v-model:checked="selectedItems" :value="item.id" />
        </td>
        <slot name="table-data" :item="item" />
      </tr>
    </tbody>
  </table>
</template>
