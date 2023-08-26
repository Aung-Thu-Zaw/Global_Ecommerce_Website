<script setup>
import SellerDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SellerDashboardGuideBreadcrumb.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  sellerDashboardGuides: Object,
});
</script>

<template>
  <SellerDashboardLayout>
    <Head title="Dashboard Guide" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div
        id="accordion-color"
        data-accordion="collapse"
        data-active-classes="bg-blue-100  text-blue-600 "
      >
        <div v-for="guide in sellerDashboardGuides" :key="guide.id">
          <h2 :id="'accordion-color-heading-' + guide.id">
            <button
              type="button"
              class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-300 focus:ring-0 hover:bg-blue-100"
              :data-accordion-target="'#accordion-color-body-' + guide.id"
              aria-expanded="true"
              :aria-controls="'accordion-color-body-' + guide.id"
            >
              <span>{{ guide.title }}</span>
              <svg
                data-accordion-icon
                class="w-3 h-3 rotate-180 shrink-0"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 10 6"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 5 5 1 1 5"
                />
              </svg>
            </button>
          </h2>
          <div
            :id="'accordion-color-body-' + guide.id"
            class="hidden"
            :aria-labelledby="'accordion-color-heading-' + guide.id"
          >
            <div class="p-5 border border-gray-200">
              <p v-html="guide.description" class="mb-2 text-gray-500"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </SellerDashboardLayout>
</template>




