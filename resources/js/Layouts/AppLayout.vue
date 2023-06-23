<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
import CategoryNavbar from "@/Components/Navbars/CategoryNavbar.vue";
import EcommerceRightSideNavbar from "@/Components/Navbars/EcommerceRightSideNavbar.vue";
import { onMounted, watch } from "vue";
import { initFlowbite } from "flowbite";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage } from "@inertiajs/vue3";

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
});

watch(
  () => usePage().props.flash.successMessage,
  () => {
    toast.success(usePage().props.flash.successMessage, {
      autoClose: 2000,
    });
  }
);

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>


<template>
  <div class="z-50 fixed top-0 w-full">
    <EcommerceNavbar />
    <CategoryNavbar />
  </div>

  <EcommerceRightSideNavbar />
  <slot />
  <EcommerceFooter />
</template>


