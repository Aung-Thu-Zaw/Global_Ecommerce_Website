<script setup>
import SellerHeaderStats from "@/Components/Headers/SellerHeaderStats.vue";
import SellerDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage, Head, Link } from "@inertiajs/vue3";

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <SellerDashboardLayout>
    <Head :title="__('SELLER_DASHBOARD')" />
    <div
      v-if="
        $page.props.auth.user.role === 'seller' &&
        $page.props.auth.user.status === 'active'
      "
    >
      <SellerHeaderStats />
      <div class="px-4 md:px-10 mx-auto w-full -m-24 border">
        <div class="relative z-10"></div>
      </div>
    </div>
    <div v-else class="mt-28">
      <div
        v-if="!$page.props.auth.user.email_verified_at"
        class="mx-auto p-5 bg-green-100"
      >
        <h2 class="text-md font-bold text-green-700">
          {{
            __(
              "YOUR_SHOP_HAS_BEEN_SUCCESSFULLY_REGISTERED_PLEASE_VERIFY_YOUR_EMAIL_IN_YOUR_EMAIL_INBOX_OR_SPAN_BOX"
            )
          }}
        </h2>
      </div>
    </div>
    <div class="mt-2 mx-auto p-5 bg-orange-100">
      <h2 class="text-md font-bold text-slate-700">
        {{
          __(
            "AT_THE_MONENT_YOUR_SHOP_IS_INACTIVE_ADMIN_WILL_CHECK_AND_CONTACT_YOU"
          )
        }}
      </h2>
    </div>

    <div
      v-if="$page.props.auth.user.status !== 'active'"
      class="mt-48 flex items-center justify-center"
    >
      <Link
        :href="route('home')"
        as="button"
        class="border border-blue-600 px-5 animate-bounce py-3 shadow font-semibold text-blue-600 rounded text-sm hover:bg-blue-600 hover:text-white transition-all"
      >
        <i class="fa-solid fa-home"></i>
        {{ __("GO_TO_HOME_PAGE") }}
      </Link>
    </div>
  </SellerDashboardLayout>
</template>
