<script setup>
import ReportBugNotificationCard from "@/Components/Cards/ReportBugNotificationCard.vue";
import RequestFeatureNotificationCard from "@/Components/Cards/Notifications/RequestFeatureNotificationCard.vue";

const props = defineProps({
  notification: Object,
});
</script>

<template>
  <ReportBugNotificationCard :notification="notification" />
  <RequestFeatureNotificationCard :notification="notification" />
</template>
