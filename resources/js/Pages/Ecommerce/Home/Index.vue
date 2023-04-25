<script setup>
import HeaderMainSection from "@/Components/Headers/HeaderMainSection.vue";
import SubscribeNewsLetterSection from "@/Components/Sections/SubscribeNewsLetterSection.vue";
import WhyChooseUsSection from "@/Components/Sections/WhyChooseUsSection.vue";
import CollectionSection from "@/Components/Sections/CollectionSection.vue";
import ProductsForYourSection from "@/Components/Sections/ProductsForYourSection.vue";
import NewProductsSection from "@/Components/Sections/NewProductsSection.vue";
import HotDealProductsSection from "@/Components/Sections/HotDealProductsSection.vue";
import FeaturedProductsSection from "@/Components/Sections/FeaturedProductsSection.vue";
import CampaignBanner from "@/Components/Banners/CampaignBanner.vue";
import ProductBanner from "@/Components/Banners/ProductBanner.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage } from "@inertiajs/vue3";

defineProps({
  categories: Object,
  collections: Object,
  sliderBanners: Object,
  campaignBanner: Object,
  productBanners: Object,
  newProducts: Object,
  featuredProducts: Object,
  hotDealProducts: Object,
  randomProducts: Object,
});

// Success flash message
if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <AppLayout>
    <div class="min-h-screen bg-gray-50 mt-40 w-full">
      <!-- Header Main Section -->
      <HeaderMainSection
        :categories="categories"
        :sliderBanners="sliderBanners"
      />

      <!-- Featured Category Section -->
      <CollectionSection :collections="collections" />

      <!-- Campaign Banner  -->
      <CampaignBanner :campaignBanner="campaignBanner" />

      <!-- Hot Deal Products Section  -->
      <HotDealProductsSection :hotDealProducts="hotDealProducts" />

      <!-- New Products Section  -->
      <NewProductsSection :newProducts="newProducts" />

      <!-- Featured Products Section  -->
      <FeaturedProductsSection :featuredProducts="featuredProducts" />

      <!-- Products For You Section -->
      <ProductsForYourSection :randomProducts="randomProducts" />

      <!-- Product Banner  -->
      <ProductBanner :productBanners="productBanners" />

      <!-- Why Choose Us Section -->
      <WhyChooseUsSection />

      <!-- Subscribe NewsLetter Section -->
      <SubscribeNewsLetterSection />
    </div>
  </AppLayout>
</template>

