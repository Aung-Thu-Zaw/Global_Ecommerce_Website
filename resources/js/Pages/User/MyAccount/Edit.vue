<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});
</script>

<template>
  <Head title="My Account" />

  <AppLayout>
    <div
      class="container mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
    >
      <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
        <i class="fa-solid fa-user"></i>
        My Account
      </h1>
      <div class="w-full flex flex-col items-start mx-auto">
        <ul
          class="mb-5 flex list-none flex-col flex-wrap items-center justify-between w-full border-b-2 pl-0 md:flex-row"
          role="tablist"
          data-te-nav-ref
        >
          <li role="presentation" class="flex-grow basis-0 text-center h-full">
            <a
              href="#tabs-home02"
              class="block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
              data-te-toggle="pill"
              data-te-target="#tabs-home02"
              data-te-nav-active
              role="tab"
              aria-controls="tabs-home02"
              aria-selected="true"
            >
              <i class="fa-solid fa-address-card"></i>
              Edit Profile
            </a>
          </li>
          <li role="presentation" class="flex-grow basis-0 text-center h-full">
            <a
              href="#tabs-profile02"
              class="focus:border-transparen block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
              data-te-toggle="pill"
              data-te-target="#tabs-profile02"
              role="tab"
              aria-controls="tabs-profile02"
              aria-selected="false"
            >
              <i class="fa-solid fa-key"></i>
              Change Password
            </a>
          </li>
          <li role="presentation" class="flex-grow basis-0 text-center h-full">
            <a
              href="#tabs-messages02"
              class="block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
              data-te-toggle="pill"
              data-te-target="#tabs-messages02"
              role="tab"
              aria-controls="tabs-messages02"
              aria-selected="false"
            >
              <i class="fa-solid fa-trash"></i>
              Delete Account
            </a>
          </li>
        </ul>

        <div class="mb-6 w-full min-h-[250px]">
          <div
            class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-home02"
            role="tabpanel"
            aria-labelledby="tabs-home-tab02"
            data-te-tab-active
          >
            <UpdateProfileInformationForm
              :must-verify-email="mustVerifyEmail"
              :status="status"
            />
          </div>
          <div
            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-profile02"
            role="tabpanel"
            aria-labelledby="tabs-profile-tab02"
          >
            <UpdatePasswordForm />
          </div>
          <div
            class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
            id="tabs-messages02"
            role="tabpanel"
            aria-labelledby="tabs-profile-tab02"
          >
            <DeleteUserForm />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
