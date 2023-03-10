<template>
  <VendorDashboardLayout>
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
    <div v-else class="mt-28 mx-auto p-5 bg-orange-100">
      <h2 class="text-md font-bold text-slate-700">
        Your shop has been successfully registered 🎉. At the moment, Your shop
        is inactive.Admin will check and contact you.
      </h2>
    </div>
  </VendorDashboardLayout>
</template>

  <script setup>
import VendorHeaderStats from "@/Components/Headers/VendorHeaderStats.vue";
import VendorDashboardLayout from "@/Layouts/VendorDashboardLayout.vue";
</script>

<style>
</style>
