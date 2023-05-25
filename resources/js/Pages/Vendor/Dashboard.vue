<script setup>
import VendorHeaderStats from "@/Components/Headers/VendorHeaderStats.vue";
import VendorDashboardLayout from "@/Layouts/VendorDashboardLayout.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage, Head } from "@inertiajs/vue3";


// Success flash message
if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <VendorDashboardLayout>
    <Head title="Vendor Dashboard" />
    <div
      v-if="
        $page.props.auth.user.role === 'vendor' &&
        $page.props.auth.user.status === 'active'
      "
    >
      <VendorHeaderStats />
      <div class="px-4 md:px-10 mx-auto w-full -m-24 border">
        <div class="relative z-10"></div>
      </div>
    </div>
    <div v-else class="mt-28 mx-auto p-5 bg-green-100">
      <h2 class="text-md font-bold text-green-700">
        Your shop has been successfully registered 🎉.Please verify your email
        in your email inbox or spam box.
      </h2>
    </div>
    <div
      v-if="!$page.props.auth.user.email_verified_at"
      class="mt-2 mx-auto p-5 bg-orange-100"
    >
      <h2 class="text-md font-bold text-slate-700">
        At the moment, Your shop is inactive. Admin will check and contact you.
      </h2>
    </div>
  </VendorDashboardLayout>
</template>
