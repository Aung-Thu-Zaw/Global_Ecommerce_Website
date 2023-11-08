<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import InputLabel from "@/Components/Forms/Fields/InputLabel.vue";
import InputError from "@/Components/Forms/Fields/InputError.vue";
import InputField from "@/Components/Forms/Fields/InputField.vue";
import TextAreaField from "@/Components/Forms/Fields/TextAreaField.vue";
import FormButton from "@/Components/Buttons/FormButton.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";

const collectionList = "admin.collections.index";

const { queryStringParams } = useQueryStringParams();

const { form, processing, errors, createAction } = useResourceActions({
  title: null,
  description: null,
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Create :label', { label: __('Collection') })" />
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="collectionList" icon="fa-box" label="Collections">
          <BreadcrumbItem label="Create" />
        </Breadcrumb>

        <div class="w-full flex items-center justify-end">
          <GoBackButton :to="collectionList" />

          <InertiaLinkButton :to="collectionList" :data="queryStringParams">
            <i class="fa-solid fa-left-long"></i>
            {{ __("Go Back") }}
          </InertiaLinkButton>
        </div>
      </div>

      <!-- Form Start -->
      <div class="border p-10 bg-white rounded-md">
        <form
          @submit.prevent="
            createAction('Collection', 'admin.collections.store')
          "
          class="space-y-4 md:space-y-6"
        >
          <div>
            <InputLabel :label="__('Collection Title')" required />

            <InputField
              type="text"
              name="collection-title"
              v-model="form.title"
              :placeholder="__('Enter Collection Title')"
              autofocus
              required
            />

            <InputError :message="errors?.name" />
          </div>

          <div>
            <InputLabel :label="__('Collection Description')" required />

            <TextAreaField
              name="collection-description"
              v-model="form.description"
              :placeholder="__('Enter Collection Description')"
              required
            />

            <InputError :message="errors?.description" />
          </div>

          <InputError :message="errors?.captcha_token" />

          <FormButton type="submit" :processing="processing">
            {{ __("Create") }}
          </FormButton>
        </form>
      </div>
      <!-- Form End -->
    </div>
  </AdminDashboardLayout>
</template>
