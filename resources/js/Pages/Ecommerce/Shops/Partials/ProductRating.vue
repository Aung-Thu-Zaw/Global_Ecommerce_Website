<script setup>
import Pagination from "@/Components/Paginations/Pagination.vue";
import { computed } from "vue";
import ProductRatingStar from "@/Components/RatingStars/ProductRatingStar.vue";
import { Link } from "@inertiajs/vue3";
import TotalAverageRatingStarWithProgressBar from "@/Components/RatingStars/TotalAverageRatingStarWithProgressBar.vue";
import TotalReviewAvgStars from "@/Components/RatingStars/TotalReviewAvgStars.vue";

const props = defineProps({
  paginateProductReviews: Object,
  productReviews: Object,
  productReviewsAvg: Object,
});

const reviewAvg = computed(() =>
  parseFloat(props.productReviewsAvg).toFixed(2)
);

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

const filterVerifiedPurchaser = computed(() => {
  const orders = props.paginateProductReviews.data.filter(
    (paginateProductReview) => {
      paginateProductReview.user.orders.filter((order) => {
        order.order_items.filter((orderItem) => {
          orderItem.produt_id === props.paginateProductReviews.product_id &&
            orderItem.vendor_id === props.paginateProductReviews.vendor_id;
        });
      });
    }
  );

  return orders.length ? true : false;
});
</script>

<template>
  <section class="container mx-auto py-10">
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

    <div v-if="paginateProductReviews.data.length" class="p-5">
      <h1 class="font-bold text-slate-600 text-xl my-3">
        Customer Product Reviews
      </h1>

      <div>
        <!-- Produt Review  -->
        <div
          v-for="productReview in paginateProductReviews.data"
          :key="productReview.id"
          class="shadow border rounded-md p-5 flex flex-col items-start my-3 mb-10"
        >
          <div>
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

            <!-- Card  -->
            <div
              class="shadow border rounded-md p-5 flex flex-col items-start my-3"
            >
              <div class="flex items-start">
                <div class="flex flex-col items-center justify-center mr-5">
                  <img
                    :src="productReview.user.avatar"
                    alt=""
                    class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
                  />

                  <ProductRatingStar :rating="productReview.rating" />
                </div>

                <div class="flex flex-col items-end">
                  <div class="flex items-center justify-between w-full mb-1">
                    <div class="flex flex-col">
                      <h3 class="text-lg font-bold text-slate-700">
                        {{ productReview.user.name }}
                        <span
                          v-if="filterVerifiedPurchaser"
                          class="text-green-500 text-[.8rem] font-bold ml-3"
                        >
                          <i class="fa-solid fa-circle-check"></i>
                          Verified Purchaser
                        </span>
                      </h3>
                      <p class="text-[.8rem] text-slate-400 mb-2">
                        Review From {{ productReview.user.name }}
                      </p>
                    </div>

                    <span class="text-slate-600 text-sm font-bold">
                      {{ productReview.updated_at }}
                    </span>
                  </div>
                  <p class="w-full text-sm font-normal text-slate-900">
                    {{ productReview.review_text }}
                  </p>
                </div>
              </div>

              <!-- Reply  -->

              <div v-if="productReview.reply" class="w-[95%] ml-auto">
                <hr class="mt-4" />

                <div class="flex items-start justify-between my-3">
                  <div class="flex items-center">
                    <img
                      :src="productReview.reply.user.avatar"
                      alt=""
                      class="w-10 h-10 object-cover rounded-full mr-5"
                    />
                    <div>
                      <h4 class="text-lg font-bold text-slate-700">
                        {{ productReview.reply.user.shop_name }}

                        <span
                          class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.7rem] ml-2"
                        >
                          <i class="fa-solid fa-circle-check"></i>
                          Verified
                        </span>
                      </h4>
                      <p class="text-[.8rem] text-slate-400">Reply From Shop</p>
                    </div>
                  </div>
                  <div class="">
                    <span class="text-slate-600 text-sm font-bold">
                      {{ productReview.reply.updated_at }}
                    </span>
                  </div>
                </div>
                <p class="w-[92%] text-sm font-normal text-slate-900 ml-auto">
                  {{ productReview.reply.reply_text }}
                </p>
              </div>
            </div>
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

