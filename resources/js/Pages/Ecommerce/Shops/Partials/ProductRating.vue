<script setup>
import Pagination from "@/Components/Paginations/Pagination.vue";
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import TotalAverageRatingStarWithProgressBar from "@/Components/RatingStars/TotalAverageRatingStarWithProgressBar.vue";
import TotalReviewAvgStars from "@/Components/RatingStars/TotalReviewAvgStars.vue";
import ProductReviewerReviewCard from "@/Components/Cards/ProductReviewerReviewCard.vue";

const props = defineProps({
  paginateProductReviews: Object,
  productReviews: Object,
  productReviewsAvg: Object,
});

// Total Product Review Avg
const reviewAvg = computed(() =>
  parseFloat(props.productReviewsAvg).toFixed(2)
);

// Filter Product Rating Stars
const oneStarRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 1
  );

  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const twoStarsRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 2
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const threeStarsRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 3
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const fourStarsRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 4
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const fiveStarsRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 5
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});
</script>

<template>
  <section class="container mx-auto py-10">
    <!-- Product Avg Stars With Progress Bar -->
    <div v-if="productReviews.length" class="text-center mb-5 p-5">
      <div class="border shadow-md w-[350px] mx-auto px-3 py-5 mb-5 rounded-md">
        <h1 class="text-lg font-bold text-slate-600">
          <i class="fa-solid fa-star"></i>
          Ratings & Reviews For Products
        </h1>
      </div>

      <div class="flex items-center justify-center">
        <TotalReviewAvgStars :reviewAvg="reviewAvg" />
      </div>

      <p class="text-sm text-slate-400">
        Based on {{ productReviews.length }} customer ratings
      </p>

      <TotalAverageRatingStarWithProgressBar
        :oneStarRating="oneStarRating"
        :twoStarsRating="twoStarsRating"
        :threeStarsRating="threeStarsRating"
        :fourStarsRating="fourStarsRating"
        :fiveStarsRating="fiveStarsRating"
      />
    </div>

    <!-- Customer Product Review  -->
    <div v-if="paginateProductReviews.data.length" class="p-5">
      <h1 class="font-bold text-slate-600 text-xl my-3">
        Customer Product Reviews
      </h1>

      <div>
        <!-- Produt Review  -->
        <div
          v-for="productReview in paginateProductReviews.data"
          :key="productReview.id"
          class="shadow border rounded-md p-5 flex flex-col items-start w-full my-3 mb-10"
        >
          <div class="w-full">
            <!-- Product -->
            <div class="flex items-start">
              <img
                :src="productReview.product.image"
                alt=""
                class="h-28 object-cover border shadow rounded-sm mr-5"
              />
              <div>
                <Link
                  :href="route('products.show', productReview.product.slug)"
                  class="font-bold text-lg text-slate-700"
                >
                  {{ productReview.product.name }}
                </Link>
                <p class="text-sm text-slate-600">
                  Brand :
                  {{
                    productReview.product.brand
                      ? productReview.product.brand.name
                      : "No Brand"
                  }}
                </p>
                <p
                  v-if="productReview.product.sizes.length"
                  class="text-sm text-slate-600"
                >
                  Sizes :
                  <span
                    v-for="(size, index) in productReview.product.sizes"
                    :key="size.id"
                  >
                    {{ size.name }}
                    <span
                      v-if="index !== productReview.product.sizes.length - 1"
                      >,</span
                    >
                  </span>
                </p>
                <p
                  v-if="productReview.product.colors.length"
                  class="text-sm text-slate-600"
                >
                  Colors :
                  <span
                    v-for="(color, index) in productReview.product.colors"
                    :key="color.id"
                  >
                    {{ color.name }}
                    <span
                      v-if="index !== productReview.product.colors.length - 1"
                      >,</span
                    >
                  </span>
                </p>
              </div>
            </div>

            <!-- Product Reviewer Review  -->
            <ProductReviewerReviewCard
              :paginateProductReviews="paginateProductReviews"
              :productReview="productReview"
            />
          </div>
        </div>

        <!-- Pagination -->
        <Pagination class="mt-6" :links="paginateProductReviews.links" />
      </div>
    </div>

    <div v-else class="my-20">
      <div class="font-bold text-center text-sm text-slate-600 my-10">
        <i class="fa-solid fa-star text-3xl mb-5 animate-bounce"></i>
        <p>Any product reviews do not exist in this shop.</p>
      </div>
    </div>
  </section>
</template>

