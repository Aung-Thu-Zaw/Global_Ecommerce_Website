<script setup>
import ProductCard from "@/Components/Cards/ProductCard.vue";
</script>


<template>
  <section>
    <div class="w-full flex items-center justify-center my-5">
      <img
        src="https://img.freepik.com/free-vector/dark-blue-banner-with-arrow-style-yellow-shapes_1017-32328.jpg"
        alt=""
        class="h-[200px] object-cover"
      />
    </div>

    <div class="w-full my-5">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        <div
          class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow mx-auto"
        >
          <a href="#">
            <img
              class="p-8 rounded-t-lg"
              src="https://www.junglescout.com/wp-content/uploads/2021/01/product-photo-water-bottle-hero.png"
              alt="product image"
            />
          </a>
          <div class="px-5 pb-5">
            <a href="#">
              <h5 class="text-xl font-semibold tracking-tight text-gray-900">
                Apple Watch Series 7 GPS, Aluminium Case, Starlight Sport
              </h5>
            </a>
          </div>
        </div>
        <div
          class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow mx-auto"
        >
          <a href="#">
            <img
              class="p-8 rounded-t-lg"
              src="https://www.junglescout.com/wp-content/uploads/2021/01/product-photo-water-bottle-hero.png"
              alt="product image"
            />
          </a>
          <div class="px-5 pb-5">
            <a href="#">
              <h5 class="text-xl font-semibold tracking-tight text-gray-900">
                Apple Watch Series 7 GPS, Aluminium Case, Starlight Sport
              </h5>
            </a>
          </div>
        </div>
        <div
          class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow mx-auto"
        >
          <a href="#">
            <img
              class="p-8 rounded-t-lg"
              src="https://www.junglescout.com/wp-content/uploads/2021/01/product-photo-water-bottle-hero.png"
              alt="product image"
            />
          </a>
          <div class="px-5 pb-5">
            <a href="#">
              <h5 class="text-xl font-semibold tracking-tight text-gray-900">
                Apple Watch Series 7 GPS, Aluminium Case, Starlight Sport
              </h5>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="my-5">
      <h1 class="text-2xl text-slate-700 font-bold">Just For You</h1>
      <ProductCard></ProductCard>
    </div>
  </section>
</template>
