<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/ProductCard.vue";
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";

const props = defineProps({ specialOfferProducts: Object });

const products = ref(props.specialOfferProducts.data);
const url = usePage().url;

const loadMoreProduct = () => {
  if (props.specialOfferProducts.next_page_url === null) {
    return;
  }

  router.get(
    props.specialOfferProducts.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["specialOfferProducts"],
      onSuccess: () => {
        products.value = [
          ...products.value,
          ...props.specialOfferProducts.data,
        ];
        window.history.replaceState({}, "", url);
      },
    }
  );
};
</script>


<template>
  <AppLayout>
    <section class="container mx-auto py-10">
      <div
        class="relative w-full h-[150px] mb-10 shadow-md rounded-md overflow-hidden border"
      >
        <img
          src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSV8gE_vyLRmsqLoTXUL_cC3P2SZ2t2OkGy8_sDdxJlUIp_KzYEQiTZPUwprpaEPShT9nY&usqp=CAU"
          class="w-full h-full object-cover"
        />
        <div
          class="absolute top-[50%] right-[50%] translate-x-[50%] -translate-y-[50%] text-2xl font-semibold text-white"
        >
          <p class="text-center uppercase">Special Offer Products</p>
          <!-- <p class="text-sm font-normal text-center my-3 text-slate-200">
            These products are between the current and the last 30 days ago.
          </p> -->
        </div>
      </div>
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"
      >
        <div v-for="product in products" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>

      <div
        v-if="props.specialOfferProducts.next_page_url != null"
        class="my-5 flex items-center justify-center"
      >
        <button
          @click="loadMoreProduct"
          class="border-2 border-slate-500 text-slate-600 rounded-sm px-5 py-2 shadow-md font-bold hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all"
        >
          LOAD MORE PRODUCTS
        </button>
      </div>
      <p v-else class="my-5 text-slate-600 text-center">
        You have reached the end of the page.
      </p>
    </section>
  </AppLayout>
</template>


