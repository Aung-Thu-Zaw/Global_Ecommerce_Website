<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/Products/ProductCard.vue";
import { ref } from "vue";
import { usePage, router, Head } from "@inertiajs/vue3";

const props = defineProps({
  products: Object,
  collection: Object,
});

const isLoading = ref(false);

const products = ref(props.products.data);

const url = usePage().url;

// Handle Load More Button
const loadMoreProduct = () => {
  if (props.products.next_page_url === null) {
    return;
  }

  isLoading.value = true;

  router.get(
    props.products.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["products"],
      onSuccess: () => {
        products.value = [...products.value, ...props.products.data];
        window.history.replaceState({}, "", url);
      },
    }
  );
};
</script>

<template>
  <AppLayout>
    <Head :title="collection.title" />
    <section class="container mx-auto py-10 mt-44">
      <!-- Title And Description -->
      <div
        class="relative w-full h-[150px] mb-10 shadow-md rounded-md overflow-hidden border"
      >
        <img
          src="https://w0.peakpx.com/wallpaper/1012/299/HD-wallpaper-dark-blur-abstract-blur-abstract-deviantart.jpg"
          class="w-full h-full object-cover"
        />
        <div
          class="absolute top-[50%] right-[50%] translate-x-[50%] -translate-y-[50%] text-xl font-semibold text-white"
        >
          <p>{{ collection.title }}</p>
          <p class="text-sm font-normal text-center my-3 text-slate-300">
            {{ collection.description }}
          </p>
        </div>
      </div>

      <!-- Products -->
      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"
      >
        <div v-for="product in products" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>

      <div
        v-if="props.products.next_page_url != null"
        class="my-5 flex items-center justify-center"
      >
        <!-- Loading Animation  -->
        <img
          v-if="isLoading"
          src="../../../assets/images/loading.gif"
          class="w-14 h-14"
          alt=""
        />

        <!-- Load More Button  -->
        <button
          v-else
          @click="loadMoreProduct"
          class="border-2 border-slate-500 text-slate-600 rounded-sm px-5 py-2 shadow-md font-bold hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all"
        >
          {{ __("LOAD_MORE_PRODUCTS") }}
        </button>
      </div>
      <p v-else class="my-5 text-slate-600 text-center">
        {{ __("YOU_HAVE_REACH_THE_END_OF_THE_PAGE") }}
      </p>
    </section>
  </AppLayout>
</template>


