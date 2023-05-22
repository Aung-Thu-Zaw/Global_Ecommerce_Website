<script setup>
import ShopReviewCard from "@/Components/Cards/ShopReviewCard.vue";
import ShopReplyCard from "@/Components/Cards/ShopReplyCard.vue";
import ShopReviewForm from "@/Components/Form/ShopReviewForm.vue";
import { computed } from "vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
  paginateShopReviews: Object,
  shopReviews: Object,
  shopReviewsAvg: Object,
  shop: Object,
});

const reviewAvg = computed(() => parseFloat(props.shopReviewsAvg).toFixed(2));

const oneStarRating = computed(() => {
  const totalRatings = props.shopReviews.filter((review) => review.rating == 1);

  return ((totalRatings.length / props.shopReviews.length) * 100).toFixed(0);
});

const twoStarRating = computed(() => {
  const totalRatings = props.shopReviews.filter((review) => review.rating == 2);
  return ((totalRatings.length / props.shopReviews.length) * 100).toFixed(0);
});

const threeStarRating = computed(() => {
  const totalRatings = props.shopReviews.filter((review) => review.rating == 3);
  return ((totalRatings.length / props.shopReviews.length) * 100).toFixed(0);
});

const fourStarRating = computed(() => {
  const totalRatings = props.shopReviews.filter((review) => review.rating == 4);
  return ((totalRatings.length / props.shopReviews.length) * 100).toFixed(0);
});

const fiveStarRating = computed(() => {
  const totalRatings = props.shopReviews.filter((review) => review.rating == 5);
  return ((totalRatings.length / props.shopReviews.length) * 100).toFixed(0);
});
</script>

<template>
  <section class="container mx-auto py-10">
    <div class="flex items-start">
      <div
        v-if="shopReviews.length"
        class="border w-1/3 text-center py-5 shadow rounded-md mr-3"
      >
        <h1 class="text-lg font-bold text-slate-600 mb-5 pb-2 border-b-4">
          <i class="fa-solid fa-star"></i>
          Ratings & Reviews For Shop
        </h1>

        <div class="w-full">
          <div class="flex items-center justify-center">
            <div class="flex items-center mb-3">
              <svg
                aria-hidden="true"
                class="w-5 h-5"
                :class="{
                  'text-yellow-400': reviewAvg >= 1,
                  'text-gray-300': reviewAvg < 1,
                }"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5"
                :class="{
                  'text-yellow-400': reviewAvg >= 2,
                  'text-gray-300': reviewAvg < 2 || reviewAvg >= 3,
                }"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5"
                :class="{
                  'text-yellow-400': reviewAvg >= 3,
                  'text-gray-300': reviewAvg < 3 || reviewAvg >= 4,
                }"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5"
                :class="{
                  'text-yellow-400': reviewAvg >= 4,
                  'text-gray-300': reviewAvg < 4 || reviewAvg >= 5,
                }"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5"
                :class="{
                  'text-yellow-400': reviewAvg >= 5,
                  'text-gray-300': reviewAvg < 5,
                }"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p
                class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                {{ reviewAvg }} out of 5
              </p>
            </div>
          </div>

          <p class="text-sm text-slate-400">
            Based on {{ shopReviews.length }} customer ratings
          </p>

          <div class="flex items-center mt-4 justify-center">
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >5 star</span
            >
            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
              <div
                class="h-5 bg-yellow-400 rounded"
                :style="{ width: `${fiveStarRating}%` }"
              ></div>
            </div>
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >{{ fiveStarRating }}%</span
            >
          </div>
          <div class="flex items-center mt-4 justify-center">
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >4 star</span
            >
            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
              <div
                class="h-5 bg-yellow-400 rounded"
                :style="{ width: `${fourStarRating}%` }"
              ></div>
            </div>
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >{{ fourStarRating }}%</span
            >
          </div>
          <div class="flex items-center mt-4 justify-center">
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >3 star</span
            >
            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
              <div
                class="h-5 bg-yellow-400 rounded"
                :style="{ width: `${threeStarRating}%` }"
              ></div>
            </div>
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >{{ threeStarRating }}%</span
            >
          </div>
          <div class="flex items-center mt-4 justify-center">
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >2 star</span
            >
            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
              <div
                class="h-5 bg-yellow-400 rounded"
                :style="{ width: `${twoStarRating}%` }"
              ></div>
            </div>
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >{{ twoStarRating }}%</span
            >
          </div>
          <div class="flex items-center mt-4 justify-center">
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >1 star</span
            >
            <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
              <div
                class="h-5 bg-yellow-400 rounded"
                :style="{ width: `${oneStarRating}%` }"
              ></div>
            </div>
            <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
              >{{ oneStarRating }}%</span
            >
          </div>
        </div>
      </div>

      <div class="w-full border rounded-sm shadow-md">
        <div class="p-5">
          <h1
            v-if="shopReviews.length"
            class="font-bold text-slate-600 text-xl my-3"
          >
            Customer Reviews ({{ shopReviews.length }})
          </h1>

          <div v-if="paginateShopReviews.data.length">
            <div
              v-for="paginateShopReview in paginateShopReviews.data"
              :key="paginateShopReview.id"
              class="shadow border rounded-md p-5 flex flex-col items-start my-3"
            >
              <ShopReviewCard :paginateShopReview="paginateShopReview" />
              <div v-if="paginateShopReview.reply" class="w-full">
                <ShopReplyCard :paginateShopReview="paginateShopReview" />
              </div>
            </div>

            <!-- Pagination -->
            <div>
              <Pagination class="mt-6" :links="paginateShopReviews.links" />
            </div>
          </div>
          <div v-else>
            <div class="font-bold text-center text-sm text-slate-600 my-10">
              <i class="fa-solid fa-star text-3xl mb-5 animate-bounce"></i>
              <p>This shop has no reviews.</p>
              <p>
                Let others know what you think and be the first to write a
                review.
              </p>
            </div>
          </div>
        </div>

        <hr v-if="shopReviews.length" />

        <div
          v-if="$page.props.auth.user && $page.props.auth.user.id !== shop.id"
        >
          <ShopReviewForm :shop="shop" />
        </div>

        <div v-else-if="!$page.props.auth.user" class="px-5 my-5">
          <p class="font-bold text-sm text-slate-600 text-center">
            If you want to review this shop you need to login first. Here
            <Link :href="route('login')" class="text-blue-600 underline">
              Login
            </Link>
            Or
            <Link :href="route('register')" class="text-blue-600 underline">
              Register
            </Link>
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

