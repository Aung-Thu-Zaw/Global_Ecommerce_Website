<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
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

const formattedPrice = computed(() => {
  const price = parseFloat(props.product.price);

  if (Number.isInteger(price)) {
    return price.toFixed(0);
  } else {
    return price.toFixed(2);
  }
});

const formattedDiscount = computed(() => {
  const discount = parseFloat(props.product.discount);

  if (Number.isInteger(discount)) {
    return discount.toFixed(0);
  } else {
    return discount.toFixed(2);
  }
});

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
  <div v-if="product">
    <article
      class="shadow-sm rounded bg-white border border-gray-200 p-2 overflow-hidden h-[460px]"
    >
      <h3
        @click="handleGoToProductDetailPage(product.slug)"
        class="relative block h-[250px] cursor-pointer"
      >
        <img
          :src="product.image"
          class="mx-auto h-full w-full object-cover"
          :alt="product.name"
        />
        <span
          v-if="product.special_offer"
          class="inline-block px-2 text-center py-1 text-[.6rem] font-bold w-[100px] bg-rose-200 bg-opacity-90 text-rose-600 absolute -right-8 top-2 rotate-45"
        >
          Special Offer
        </span>
      </h3>
      <div class="p-4 border-t border-t-gray-200">
        <span
          v-if="product.shop.offical"
          class="px-3 rounded-sm py-1 font-bold uppercase text-[0.6rem] text-white bg-fuchsia-600"
        >
          <i class="fas fa-crown"></i>
          Official
        </span>
        <h6 class="text-md mt-1">
          <h3
            @click="handleGoToProductDetailPage(product.slug)"
            class="text-gray-600 line-clamp-2 cursor-pointer"
          >
            {{ product.name }}
          </h3>
        </h6>

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
    </article>
  </div>
</template>

