<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head,Link } from "@inertiajs/vue3";

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
        >
          <li class="flex-grow basis-0 text-center h-full" role="presentation">
            <Link
              :href="route('my-account.edit')"
              :data="{ tab: 'edit-profile' }"
              class="block border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100"
              :class="{
                'bg-neutral-200':
                  $page.props.ziggy.query.tab === 'edit-profile' ||
                  !$page.props.ziggy.query.tab,
              }"
            >
              <i class="fa-solid fa-address-card mr-2 text-sm"></i>
              Edit Profile
            </Link>
          </li>
          <li class="flex-grow basis-0 text-center h-full" role="presentation">
            <Link
              :href="route('my-account.edit')"
              :data="{ tab: 'change-password' }"
              class="block border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100"
              :class="{
                'bg-neutral-200':
                  $page.props.ziggy.query.tab === 'change-password' ||
                  !$page.props.ziggy.query.tab,
              }"
            >
              <i class="fa-solid fa-key mr-2 text-sm"></i>
              Change Password
            </Link>
          </li>
          <li class="flex-grow basis-0 text-center h-full" role="presentation">
            <Link
              :href="route('my-account.edit')"
              :data="{ tab: 'delete-account' }"
              class="block border-transparent px-7 pt-4 pb-3.5 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100"
              :class="{
                'bg-neutral-200':
                  $page.props.ziggy.query.tab === 'delete-account' ||
                  !$page.props.ziggy.query.tab,
              }"
            >
              <i class="fa-solid fa-trash mr-2 text-sm"></i>
              Delete Account
            </Link>
          </li>
        </ul>

        <div class="mb-6 w-full min-h-[250px]">
          <div class="w-full">
            <div v-if="$page.props.ziggy.query.tab === 'edit-profile'">
              <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
              />
            </div>
            <div v-else-if="$page.props.ziggy.query.tab === 'change-password'">
              <UpdatePasswordForm />
            </div>
            <div v-else-if="$page.props.ziggy.query.tab === 'delete-account'">
              <DeleteUserForm />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
