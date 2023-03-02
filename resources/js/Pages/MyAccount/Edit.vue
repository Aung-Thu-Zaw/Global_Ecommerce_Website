<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
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

  <AuthenticatedLayout>
    <template #header>
      <Link :href="route('my-account.edit')">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Manage My Account
        </h2>
      </Link>
    </template>

    <div
      class="w-full flex flex-col items-start p-12 md:w-[80%] border mx-auto mt-36 rounded-md shadow-md bg-white"
    >
      <ul
        class="mb-5 flex list-none flex-col flex-wrap items-center justify-between w-full border-b-0 pl-0 md:flex-row"
        role="tablist"
        data-te-nav-ref
      >
        <li role="presentation" class="flex-grow basis-0 text-center">
          <a
            href="#tabs-home02"
            class="my-2 block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
            data-te-toggle="pill"
            data-te-target="#tabs-home02"
            data-te-nav-active
            role="tab"
            aria-controls="tabs-home02"
            aria-selected="true"
            >Edit Profile</a
          >
        </li>
        <li role="presentation" class="flex-grow basis-0 text-center">
          <a
            href="#tabs-profile02"
            class="focus:border-transparen my-2 block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
            data-te-toggle="pill"
            data-te-target="#tabs-profile02"
            role="tab"
            aria-controls="tabs-profile02"
            aria-selected="false"
            >Change Password</a
          >
        </li>
        <li role="presentation" class="flex-grow basis-0 text-center">
          <a
            href="#tabs-messages02"
            class="my-2 block border-x-0 border-t-0 border-b-2 border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
            data-te-toggle="pill"
            data-te-target="#tabs-messages02"
            role="tab"
            aria-controls="tabs-messages02"
            aria-selected="false"
            >Delete Account</a
          >
        </li>
      </ul>

      <div class="mb-6 w-full">
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
  </AuthenticatedLayout>
</template>
