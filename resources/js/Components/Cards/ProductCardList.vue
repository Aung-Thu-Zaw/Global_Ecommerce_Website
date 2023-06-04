<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import TotalAverageRatingStarForProduct from "@/Components/RatingStars/TotalAverageRatingStarForProduct.vue";

const props = defineProps({
  product: Object,
});

const averageRating = ref(null);

if (props.product.product_reviews) {
  const filteredProductReviews = props.product.product_reviews.filter(
    (review) => review.product_id === props.product.id
  );

  const sumOfRatings = filteredProductReviews.reduce(
    (sum, review) => sum + review.rating,
    0
  );

  averageRating.value = (sumOfRatings / filteredProductReviews.length).toFixed(
    2
  );
}

const handleTrackInteraction = () => {
  router.post(route("product.track-interaction"), {
    user_id: usePage().props.auth.user?.id,
    product_id: props.product.id,
  });
};

const handleGoToProductDetailPage = (slug) => {
  router.get(
    route("products.show", slug),
    {},
    {
      onSuccess: () => {
        if (usePage().props.auth.user) {
          handleTrackInteraction();
        }
      },
    }
  );
};
</script>

<template>
  <div v-if="product" class="w-full">
    <div
      @click="handleGoToProductDetailPage(product.slug)"
      class="border hover:shadow-md rounded-sm bg-white p-5 w-full h-[280px] flex items-start justify-between relative overflow-hidden cursor-pointer"
    >
      <div class="flex flex-col items-start w-[500px] mr-3">
        <img
          :src="product.image"
          alt=""
          class="h-[180px] object-contain rounded-md shadow border-2 border-slate-400"
        />

        <span
          v-if="product.special_offer"
          class="inline-block px-2 text-center py-1 text-[.6rem] font-bold w-[100px] bg-rose-200 bg-opacity-90 text-rose-600 absolute -right-6 top-4 rotate-45"
        >
          Special Offer
        </span>

        <div
          class="flex items-center space-x-1 mt-2 w-[250px] overflow-auto pb-1 scrollbar"
        >
          <img
            v-for="image in product.images"
            :key="image.id"
            :src="image.img_path"
            alt=""
            class="h-[50px] object-contain rounded-md shadow border-2 border-slate-400"
          />
        </div>
      </div>

      <div class="w-full">
        <h1 class="line-clamp-1 font-semibold text-slate-600 text-md mb-3">
          {{ product.name }}
        </h1>
        <p class="text-sm text-slate-500 line-clamp-6 mb-5">
          {{ product.description }}
        </p>


        <div class="flex items-start justify-between w-full">
          <div class="my-2">
            <div v-if="product.discount">
              <span class="font-semibold text-slate-600 block">
                ${{ product.discount }}
              </span>
              <span class="text-[.8rem] text-secondary-600 line-through mr-5">
                ${{ product.price }}
              </span>
              <span
                v-if="product.discount"
                class="text-[.6rem] px-2 py-1 bg-green-200 rounded-full text-green-600 font-bold"
              >
                {{
                  (
                    ((product.price - product.discount) / product.price) *
                    100
                  ).toFixed(1)
                }}% OFF
              </span>
            </div>
            <div v-else>
              <span class="font-semibold text-slate-600 mr-3">
                ${{ product.price }}
              </span>
            </div>
          </div>

          <TotalAverageRatingStarForProduct :averageRating="averageRating" />
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
  height: 8px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
