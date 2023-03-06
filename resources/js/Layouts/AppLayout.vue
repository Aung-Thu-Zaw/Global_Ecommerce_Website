<template>
  <EcommerceNavbar />

  <slot />
  <EcommerceFooter />
</template>

<script>
import EcommerceFooter from "../Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "../Components/Navbars/EcommerceNavbar.vue";
export default {
  components: {
    EcommerceFooter,
    EcommerceNavbar,
  },
};
</script>

<style>
</style>
