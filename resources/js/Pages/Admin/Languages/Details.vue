<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Link, Head, useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  language: Object,
  jsonData: Array,
});

const form = useForm({
  key: [],
  value: [],
  captcha_token: null,
});

const formValue = (value) => {
  form.value = value;
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="language.name" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
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
                >{{ language.name }}</span
              >
            </div>
          </li>
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
                >Details</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <Link
            as="button"
            :href="route('admin.languages.index')"
            :data="{
              page: props.queryStringParams.page,
              per_page: props.queryStringParams.per_page,
              sort: props.queryStringParams.sort,
              direction: props.queryStringParams.direction,
            }"
            class="goback-btn"
          >
            <span>
              <i class="fa-solid fa-circle-left"></i>
              Go Back
            </span>
          </Link>
        </div>
      </div>

      <!-- Language Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh> Key </HeaderTh>

          <HeaderTh> Value </HeaderTh>
        </TableHeader>

        <tbody>
          <Tr v-for="(json, index) in jsonData" :key="index">
            <Td class="max-w-[280px] border-r">
              <!-- class= border-transparent bg-white outline-none focus:border-transparent focus:ring-0 placeholder:text-gray-400 placeholder:text-sm" -->
              <span
                class="w-full block border px-2 py-[14px] bg-white rounded-md border-gray-300 overflow-x-scroll"
              >
                {{ index }}
              </span>
            </Td>
            <Td class="max-w-[500px]">
              <!-- <input type="text" v-model="form.key" /> -->
              <!-- <input
                type="text"
                class="w-full block border px-2 py-[12px] bg-white rounded-md border-gray-300 overflow-x-scroll focus:ring-0 focus:border-gray-300"
                v-model="form.value"
              /> -->

              {{ json }}
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Language Table End -->
    </div>
  </AdminDashboardLayout>
</template>
