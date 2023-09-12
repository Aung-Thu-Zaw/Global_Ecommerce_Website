<script setup>
import WatchListItem from "@/Components/Items/WatchListItem.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import RecommendedProductSection from "@/Components/Sections/RecommendedProductSection.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  shops: Object,
  watchlists: Object,
  recommendedProducts: Object,
});
</script>


<template>
  <AppLayout>
    <Head :title="__('MY_WATCHLIST')" />
    <section class="py-5 sm:py-7 mt-44">
      <!-- Title -->
      <div class="container max-w-screen-xl mx-auto px-4">
        <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
          {{ __("MY_WATCHLIST") }}
        </h1>
      </div>
    </section>

    <section v-if="watchlists.length || shops.length" class="py-5">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-4">
          <main class="md:w-full">
            <article
              v-for="shop in shops"
              :key="shop.id"
              class="border border-gray-200 bg-white shadow-sm rounded mb-5"
            >
              <div
                class="border-b px-3 py-2 lg:px-5 font-bold text-slate-600 text-md"
              >
                <span class="text-sm text-slate-500">
                  Item(s) from
                  <span class="text-slate-700">{{ shop.shop_name }}</span>
                </span>
              </div>

              <!--  watchlist item-cart -->
              <div v-for="watchlist in watchlists" :key="watchlist.id">
                <div v-if="watchlist.shop_id == shop.id">
                  <WatchListItem :watchlist="watchlist" />
                </div>
              </div>
              <hr />
            </article>
          </main>
        </div>
      </div>
    </section>
    <section v-else class="min-h-[400px] flex flex-col items-center py-10">
      <h2 class="font-semibold text-lg text-center text-slate-600 mb-20">
        <i class="fas fa-heart"></i>
        <br />
        There are no favorites yet.
        <br />
        Add your favorites to wishlist and they will show here.
      </h2>
      <Link
        :href="route('home')"
        class="border border-blue-600 px-5 py-3 shadow animate-bounce font-semibold text-blue-600 rounded text-sm hover:bg-blue-600 hover:text-white transition-all"
      >
        <i class="fa-solid fa-cart-shopping"></i>
        Continue Shopping
      </Link>
    </section>

    <!-- Recommended Product Section -->
    <div v-if="recommendedProducts.length">
      <RecommendedProductSection :recommendedProducts="recommendedProducts" />
    </div>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
