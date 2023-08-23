<script setup>
import SuccessAlert from "@/Components/Alerts/SuccessAlert.vue";
import HeaderMainSection from "@/Components/Headers/HeaderMainSection.vue";
import SubscribeNewsLetterSection from "@/Components/Sections/SubscribeNewsLetterSection.vue";
import WhyChooseUsSection from "@/Components/Sections/WhyChooseUsSection.vue";
import CollectionSection from "@/Components/Sections/CollectionSection.vue";
import ProductsForYourSection from "@/Components/Sections/ProductsForYourSection.vue";
import NewProductsSection from "@/Components/Sections/NewProductsSection.vue";
import FlashSaleProductsSection from "@/Components/Sections/FlashSaleProductsSection.vue";
import FeaturedProductsSection from "@/Components/Sections/FeaturedProductsSection.vue";
import CampaignBanner from "@/Components/Banners/CampaignBanner.vue";
import ProductBanner from "@/Components/Banners/ProductBanner.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { usePage, Head } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

defineProps({
  categories: Object,
  collections: Object,
  sliderBanners: Object,
  campaignBanner: Object,
  productBanners: Object,
  flashSale: Object,
  flashSaleProducts: Object,
  newProducts: Object,
  featuredProducts: Object,
  randomProducts: Object,
  socialMedia: Object,
});

if (usePage().props.flash.successMessage) {
  toast.success(__(usePage().props.flash.successMessage), {
    autoClose: 2000,
  });
}
</script>

<template>
  <AppLayout>
    <Head title="Global Online Shopping" />
    <div class="min-h-screen bg-gray-50 mt-40 w-full">
      <!-- Verify Email Alert -->
      <SuccessAlert
        v-if="$page.props.auth.user && !$page.props.auth.user.email_verified_at"
      />

      <!-- Header Main Section -->
      <HeaderMainSection
        :categories="categories"
        :sliderBanners="sliderBanners"
      />

      <!-- Featured Category Section -->
      <CollectionSection :collections="collections" />

      <!-- Campaign Banner  -->
      <CampaignBanner :campaignBanner="campaignBanner" />

      <!-- Flash Sale Products Section  -->
      <FlashSaleProductsSection
        :flashSale="flashSale"
        :flashSaleProducts="flashSaleProducts"
      />

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
      <SubscribeNewsLetterSection :socialMedia="socialMedia" />
    </div>
  </AppLayout>
</template>

