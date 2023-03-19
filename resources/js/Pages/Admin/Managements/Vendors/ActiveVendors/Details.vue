<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/VendorManage/Breadcrumb.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputContainer from "@/Components/Form/InputContainer.vue";
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  paginate: Object,
  activeVendor: Object,
});

const form = useForm({
  company_name: props.activeVendor.company_name,
  shop_name: props.activeVendor.shop_name,
  name: props.activeVendor.name,
  email: props.activeVendor.email,
  phone: props.activeVendor.phone,
  about: props.activeVendor.about,
  captcha_token: null,
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="activeVendor.name + ' Details'" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Vendor Breadcrumb -->
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
                >Active Vendor</span
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

        <div>
          <Link
            :href="route('admin.vendors.active.index')"
            :data="{
              page: props.paginate.page,
              per_page: props.paginate.per_page,
            }"
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
            :src="activeVendor.avatar"
            alt=""
            class="w-48 h-48 rounded-md object-cover ring-4 mb-5"
          />
          <h2
            class="uppercase text-md text-green-600 font-bold px-3 py-2 bg-green-100 rounded-md"
          >
            Shop is {{ activeVendor.status }}
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




