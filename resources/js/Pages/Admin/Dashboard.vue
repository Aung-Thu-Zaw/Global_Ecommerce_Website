<template>
  <AdminDashboardLayout :avatarUrl="avatarUrl"> </AdminDashboardLayout>
</template>

    <script>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
export default {
  props: { avatarUrl: String },
  components: {
    AdminDashboardLayout,
  },
};
</script>

    <style>
</style>
