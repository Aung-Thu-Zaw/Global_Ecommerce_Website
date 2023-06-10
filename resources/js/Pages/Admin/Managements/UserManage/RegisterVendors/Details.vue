<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/UserManageBreadcrumb.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  paginate: Object,
  user: Object,
});

const currentTime = new Date();
const threshold = 1000 * 60 * 3; //3minutes in millseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "active" : "offline";
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="user.name + ' Details'" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
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
              <span class="ml-1 font-medium text-gray-500 md:ml-2"
                >All Register Vendors</span
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
            as="button"
            :href="route('admin.vendors.register.index')"
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
        <div class="mb-5 flex items-center justify-center">
          <img
            :src="user.avatar"
            alt=""
            class="w-48 h-48 rounded-full object-cover ring-4 ring-slate-300 mb-5"
          />
        </div>

        <p class="text-lg text-slate-600 font-bold capitalize mb-5 text-center">
          Account Status -
          <span
            v-if="user.status === 'active'"
            class="bg-green-200 text-green-500 px-3 text-sm uppercase py-1 rounded-full"
          >
            {{ user.status }}
          </span>
          <span
            v-else
            class="bg-red-200 text-red-500 px-3 text-sm uppercase py-1 rounded-full"
          >
            {{ user.status }}
          </span>
        </p>
        <p class="text-lg text-slate-600 font-bold capitalize mb-5 text-center">
          Online Status -
          <span
            class="px-3 py-1 font-bold uppercase text-sm rounded-full"
            :class="{
              'bg-green-200 text-green-500':
                status(user.last_activity) == 'online',
              'bg-red-200 text-red-500':
                status(user.last_activity) == 'offline',
            }"
          >
            <i class="fa-solid fa-circle animate-pulse text-[.6rem]"></i>
            {{ status(user.last_activity) }}
          </span>
        </p>

        <form>
          <div class="mb-6">
            <InputLabel for="name" value="Name" />

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="user.name"
              disabled
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-user text-gray-600"></i>
                </span>
              </template>
            </TextInput>
          </div>
          <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
              <InputLabel for="companyName" value="Company Name" />

              <TextInput
                id="companyName"
                type="text"
                class="mt-1 block w-full"
                v-model="user.company_name"
                disabled
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-building text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
            </div>

            <div>
              <InputLabel for="shopName" value="Shop Name" />

              <TextInput
                id="shopName"
                type="text"
                class="mt-1 block w-full"
                v-model="user.shop_name"
                disabled
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-store text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
            </div>
            <div>
              <InputLabel for="email" value="Email" />

              <TextInput
                type="email"
                class="mt-1 block w-full"
                v-model="user.email"
                disabled
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-envelope text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
            </div>

            <div>
              <InputLabel for="phone" value="Phone" />

              <TextInput
                type="text"
                class="mt-1 block w-full"
                v-model="user.phone"
                disabled
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-phone text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
            </div>

            <div>
              <InputLabel for="gender" value="Gender" />

              <TextInput
                type="text"
                class="mt-1 block w-full"
                v-model="user.gender"
                disabled
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-venus-mars text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
            </div>

            <div>
              <InputLabel for="birthday" value="Birthday" />

              <TextInput
                type="text"
                class="mt-1 block w-full"
                v-model="user.birthday"
                disabled
              >
                <template v-slot:icon>
                  <span>
                    <i class="fa-solid fa-calendar-days text-gray-600"></i>
                  </span>
                </template>
              </TextInput>
            </div>
          </div>
          <div class="mb-6">
            <InputLabel for="address" value="Address" />
            <TextInput
              type="text"
              class="mt-1 block w-full"
              v-model="user.address"
              disabled
            >
              <template v-slot:icon>
                <span>
                  <i class="fa-solid fa-map-location-dot text-gray-600"></i>
                </span>
              </template>
            </TextInput>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>




