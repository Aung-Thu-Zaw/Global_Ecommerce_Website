<template>
  <AdminDashboardLayout>
    <div class="px-4 md:px-10 mx-auto w-full py-32">
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
                  >Vendor Manage</span
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
                  >Inactive Vendor</span
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
          </ol>
        </nav>

        <!-- Breadcrumb end -->

        <div>
          <Link
            :href="route('admin.vendors.inactive.index')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <div class="mb-10 flex items-center justify-between">
          <img
            :src="inactiveVendor.avatar"
            alt=""
            class="w-48 h-48 rounded-md object-cover ring-4 mb-5"
          />
          <h2
            class="uppercase text-md text-red-600 font-bold px-3 py-2 bg-red-100 rounded-md"
          >
            Shop is Inactive
          </h2>
        </div>
        <form>
          <div class="mb-6">
            <InputLabel for="name" value="Name *" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.name"
              required
              placeholder="Enter Your Fullname"
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-user text-gray-600"></i>
                </span>
              </template>
            </TextInput>

            <InputError class="mt-2" :message="form.errors.name" />
          </div>
          <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
              <InputLabel for="companyName" value="Company Name *" />

              <TextInput
                id="companyName"
                type="text"
                class="mt-1 block w-full"
                v-model="form.company_name"
                required
                placeholder="Enter Company Name"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-building text-gray-600"></i>
                  </span>
                </template>
              </TextInput>

              <InputError class="mt-2" :message="form.errors.company_name" />
            </div>

            <div>
              <InputLabel for="shopName" value="Shop Name *" />

              <TextInput
                id="shopName"
                type="text"
                class="mt-1 block w-full"
                v-model="form.shop_name"
                required
                placeholder="Enter Shop Name"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-store text-gray-600"></i>
                  </span>
                </template>
              </TextInput>

              <InputError class="mt-2" :message="form.errors.shop_name" />
            </div>

            <div>
              <InputLabel for="email" value="Email *" />

              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                placeholder="Enter Your Email Address"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-envelope text-gray-600"></i>
                  </span>
                </template>
              </TextInput>

              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
              <InputLabel for="phone" value="Phone *" />

              <TextInput
                id="email"
                type="text"
                class="mt-1 block w-full"
                v-model="form.phone"
                required
                placeholder="Enter Your Phone Number"
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-phone text-gray-600"></i>
                  </span>
                </template>
              </TextInput>

              <InputError class="mt-2" :message="form.errors.phone" />
            </div>
          </div>
          <div class="mb-6">
            <InputLabel for="about" value="About *" />

            <InputContainer>
              <textarea
                id="about"
                cols="30"
                rows="10"
                class="p-2 w-full border-transparent outline-none focus:border-transparent focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
                v-model="form.about"
              ></textarea>
            </InputContainer>

            <InputError class="mt-2" :message="form.errors.about" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<script setup>
// import { useReCaptcha } from "vue-recaptcha-v3";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputContainer from "@/Components/Form/InputContainer.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import FormButton from "@/Components/Form/FormButton.vue";

const props = defineProps({
  inactiveVendor: Object,
});
const form = useForm({
  company_name: props.inactiveVendor.company_name,
  shop_name: props.inactiveVendor.shop_name,
  name: props.inactiveVendor.name,
  email: props.inactiveVendor.email,
  phone: props.inactiveVendor.phone,
  about: props.inactiveVendor.about,
  captcha_token: null,
});
</script>

<style>
</style>
