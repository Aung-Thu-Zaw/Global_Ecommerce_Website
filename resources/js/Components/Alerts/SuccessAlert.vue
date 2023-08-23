<script setup>
</script>

<template>
  <div
    id="success-alert"
    class="flex items-center justify-center p-4 text-green-800 border-green-300 bg-green-100 dark:text-green-400"
    role="alert"
  >
    <i class="fa-solid fa-user"></i>
    <div class="ml-3 text-sm font-medium">
      {{
        __(
          "YOUR_ACCOUNT_HAS_BEEN_SUCCESSFULLY_REGISTERED_PLEASE_VERIFY_YOUR_EMAIL_IN_YOUR_EMAIL_INBOX_OR_SPAN_BOX"
        )
      }}
    </div>
  </div>
</template>

