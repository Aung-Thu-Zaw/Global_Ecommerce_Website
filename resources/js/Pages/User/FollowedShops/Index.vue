<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import RecommendedProductSection from "@/Components/Sections/RecommendedProductSection.vue";
import JustForYouProductSection from "@/Components/Sections/JustForYouProductSection.vue";
import { Link, Head, router } from "@inertiajs/vue3";
import { inject } from "vue";

const props = defineProps({
  followedShops: Object,
  recommendedProducts: Object,
  justForYouProducts: Object,
});

const swal = inject("$swal");

const handleUnfollowShop = async (shop_id) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want unfollow this shop?",
    text: "If you unfollow selected stores, you won't be able to view the latest arrival and sales from them anymore.",
    showCancelButton: true,
    confirmButtonText: "Yes, unfollow!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(route("user.shop.unfollow", { shop_id }));
  }
};
</script>


<template>
  <AppLayout>
    <Head title="Followed Shops" />
    <section class="py-5 sm:py-7 mt-44">
      <!-- Title -->
      <div class="container max-w-screen-xl mx-auto px-4">
        <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
          Followed Shops
        </h1>
      </div>
    </section>

    <section v-if="followedShops.length" class="py-5 min-h-[400px]">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col items-center space-y-6">
          <!-- Followed Shops -->
          <div
            v-for="followedShop in followedShops"
            :key="followedShop.id"
            class="shadow-md rounded-sm p-5 flex items-center justify-between border w-full"
          >
            <div class="flex items-center">
              <img
                :src="followedShop.followable.avatar"
                alt=""
                class="w-14 h-14 object-cover rounded-full ring-2 ring-slate-300 shadow-md mr-5"
              />
              <h2 class="text-lg font-bold text-slate-700">
                <Link :href="route('shop.show', followedShop.followable.id)">
                  {{ followedShop.followable.shop_name }}
                </Link>

                <span
                  class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.7rem] ml-2"
                >
                  <i class="fa-solid fa-circle-check"></i>
                  Verified
                </span>
              </h2>
            </div>
            <div class="flex items-center">
              <button
                @click="handleUnfollowShop(followedShop.followable_id)"
                class="bg-blue-500 text-sm font-bold px-5 rounded-sm shadow-sm text-white mx-2 py-3 hover:bg-blue-600"
              >
                <i class="fa-solid fa-check"></i>
                Following
              </button>
              <Link
                :href="route('shop.show', followedShop.followable.uuid)"
                class="bg-blue-500 text-sm font-bold px-5 rounded-sm shadow-sm text-white mx-2 py-3 hover:bg-blue-600"
              >
                <i class="fa-solid fa-shop"></i>
                Visit Shop
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section v-else class="min-h-[400px] flex flex-col items-center py-10">
      <h2 class="font-semibold text-lg text-center text-slate-600 mb-20">
        <i class="fas fa-shop"></i>
        You didn't follow any shop
      </h2>
      <Link
        :href="route('home')"
        class="border border-blue-600 px-5 py-3 shadow animate-bounce font-semibold text-blue-600 rounded text-sm hover:bg-blue-600 hover:text-white transition-all"
      >
        <i class="fa-solid fa-home"></i>
        Go To Home Page
      </Link>
    </section>

    <!-- Recommended Product Section -->
    <div v-if="recommendedProducts">
      <RecommendedProductSection :recommendedProducts="recommendedProducts" />
    </div>

    <!-- Recommended Product Section -->
    <div v-else-if="justForYouProducts">
      <JustForYouProductSection :justForYouProducts="justForYouProducts" />
    </div>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
