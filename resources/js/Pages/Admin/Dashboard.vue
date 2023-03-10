<template>
  <AdminDashboardLayout>
    <AdminHeaderStats />
    <div class="px-4 md:px-10 mx-auto w-full -m-24 border">
      <div class="relative z-10"></div>
    </div>
  </AdminDashboardLayout>
</template>

<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage } from "@inertiajs/vue3";

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
autoClose: 2000,
  });
}
</script>

<style>
</style>
