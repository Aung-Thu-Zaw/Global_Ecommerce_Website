<script setup>
import TotalAverageRatingStarForProduct from "@/Components/RatingStars/TotalAverageRatingStarForProduct.vue";
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
  product: Object,
});

// Handle Product Review Avg
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

// Formatted Price
const formattedPrice = computed(() => {
  const price = parseFloat(props.product.price);

  if (Number.isInteger(price)) {
    return price.toFixed(0);
  } else {
    return price.toFixed(2);
  }
});

// Formatted Discount
const formattedDiscount = computed(() => {
  const discount = parseFloat(props.product.discount);

  if (Number.isInteger(discount)) {
    return discount.toFixed(0);
  } else {
    return discount.toFixed(2);
  }
});

// Handle Product Interaction Tracking
const handleTrackInteraction = () => {
  router.post(route("product.track-interaction"), {
    user_id: usePage().props.auth.user?.id,
    product_id: props.product.id,
  });
};

// Handle Go To Product Detail
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
        <span
          v-if="product.shop.offical"
          class="px-3 rounded-sm py-1 font-bold uppercase text-[0.6rem] text-white bg-fuchsia-600"
        >
          <i class="fas fa-crown"></i>
          Official
        </span>
        <h1 class="line-clamp-1 font-semibold text-slate-600 text-md mb-3">
          {{ product.name }}
        </h1>
        <p class="text-sm text-slate-500 line-clamp-5 mb-5">
          {{ product.description }}
        </p>

        <div class="flex items-start justify-between w-full">
          <div class="my-2">
            <div v-if="product.discount">
              <span class="font-semibold text-slate-600 block">
                ${{ formattedDiscount }}
              </span>
              <span class="text-[.8rem] text-secondary-600 line-through mr-5">
                ${{ formattedPrice }}
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
                ${{ formattedPrice }}
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
