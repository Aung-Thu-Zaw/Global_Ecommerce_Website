<script setup>
import WatchListItem from "@/Components/WatchListItem.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({ shops: Object, watchlists: Object });
</script>


<template>
  <AppLayout>
    <section class="py-5 sm:py-7 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h2 class="text-4xl text-slate-700 font-semibold mb-2">My Watchlist</h2>
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

              <!-- item-cart -->
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

    <!-- SECTION-RECOMMENDED -->
    <section class="pt-10 pb-20 bg-gray-100">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h2 class="text-2xl font-semibold mb-8">Recommended products</h2>

        <!-- <div
          v-if="products"
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
        >
          <div v-for="product in products" :key="product.id">
            <ProductCard :product="product"></ProductCard>
          </div>
        </div>
        <div v-else>
          <p class="text-center text-xl font-bold text-red-600 animate-bounce">
            No Product Found!
          </p>
        </div> -->
      </div>
    </section>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
