<template>
  <AdminDashboardLayout>
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Breadcrumb start -->

      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb start -->

        <nav class="flex text-md" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a
                href="#"
                class="inline-flex items-center font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
              >
                <svg
                  aria-hidden="true"
                  class="w-4 h-4 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                  ></path>
                </svg>
                Dashboard
              </a>
            </li>
            <li>
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
                  class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                  >Categories</span
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
                  >Category</span
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
                  >Create</span
                >
              </div>
            </li>
          </ol>
        </nav>

        <!-- Breadcrumb end -->

        <div>
          <Link
            :href="route('admin.categories.index')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <!-- Breadcrumb end -->

      <div class="border shadow-md p-10">
        <!-- <div class="mb-10 flex items-center justify-between">
          <img
            :src="inactiveVendor.avatar"
            alt=""
            class="w-48 h-48 rounded-md object-cover ring-4 mb-5"
          />
          <h2
            class="uppercase text-md text-red-600 font-bold px-3 py-2 bg-red-100 rounded-md"
          >
            Shop is {{ inactiveVendor.status }}
          </h2>
        </div> -->
        <form>
          <div class="mb-6">
            <InputLabel for="name" value="Category Name *" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              placeholder="Enter Category Name"
            />

            <InputError class="mt-2" :message="form.errors.name" />
          </div>
          <div class="mb-6">
            <InputLabel for="slug" value="Category Slug *" />

            <TextInput
              id="slug"
              type="text"
              class="mt-1 block w-full"
              v-model="form.slug"
              required
              placeholder="Enter Category Slug"
            />

            <InputError class="mt-2" :message="form.errors.slug" />
          </div>

          <div class="mb-6">
            <InputLabel for="status" value="Status *" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.status"
            >
              <option value="" selected disabled>Select Status</option>
              <option value="show">Show</option>
              <option value="hide">Hide</option>
            </select>

            <InputError class="mt-2" :message="form.errors.status" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { inject } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import InputContainer from "@/Components/Form/InputContainer.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import FormButton from "@/Components/Form/FormButton.vue";

const form = useForm({
  name: "",
  slug: "",
  status: "",
  image: "",
  captcha_token: null,
});
</script>

      <style>
</style>
