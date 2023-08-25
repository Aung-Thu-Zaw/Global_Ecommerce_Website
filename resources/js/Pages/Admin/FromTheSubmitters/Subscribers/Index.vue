<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SubscriberBreadcrumb.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  subscribers: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Subscriber Trash List Permission
const subscriberTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "subscriber.trash.list"
      )
    : false;
});

// Subscriber Delete Permission
const subscriberDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "subscriber.delete"
      )
    : false;
});

// Query String Parameteres
const params = reactive({
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
});

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    route("admin.subscribers.index"),
    {
      search: usePage().props.ziggy.query?.search,
      page: usePage().props.ziggy.query?.page,
      per_page: usePage().props.ziggy.query?.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: usePage().props.ziggy.query?.created_from,
      created_until: usePage().props.ziggy.query?.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Handle Delete Subscriber
const handleDeleteSubscriber = async (subscriberId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_SUBSCRIBER"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_SUBSCRIBER_IN_THE_TRASH"),
    showCancelButton: true,
    confirmButtonText: __("YES_DELETE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.subscribers.destroy", {
        subscriber: subscriberId,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: __(usePage().props.flash.successMessage),
            });
          }
        },
      }
    );
  }
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('SUBSCRIBERS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="subscriberTrashList">
          <TrashButton href="admin.subscribers.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.subscribers.index"
            placeholder="SEARCH_BY_EMAIL"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.subscribers.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.subscribers.index" />
        </div>
      </div>

      <!-- Subscriber Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            {{ __("EMAIL") }}
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="subscriberDelete"> {{ __("ACTION") }} </HeaderTh>
        </TableHeader>

        <tbody v-if="subscribers.data.length">
          <Tr v-for="subscriber in subscribers.data" :key="subscriber.id">
            <BodyTh>
              {{ subscriber.id }}
            </BodyTh>

            <Td>
              {{ subscriber.email }}
            </Td>

            <Td>
              {{ subscriber.created_at }}
            </Td>

            <Td v-if="subscriberDelete">
              <!-- Delete Button -->
              <div v-if="subscriberDelete">
                <DeleteButton @click="handleDeleteSubscriber(subscriber.id)" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Subscriber Table End -->

      <!-- No Avaliable Data Row -->
      <NotAvaliableData v-if="!subscribers.data.length" />

      <!-- Pagination -->
      <div v-if="subscribers.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ subscribers.from }} - {{ subscribers.to }} of
          {{ subscribers.total }}
        </p>
        <Pagination :links="subscribers.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

