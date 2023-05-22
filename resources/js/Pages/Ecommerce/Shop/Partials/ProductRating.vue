<script setup>
import Pagination from "@/Components/Pagination.vue";
import { computed } from "vue";
import ProductRatingStar from "@/Components/ProductRatingStar.vue";

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

const twoStarRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 2
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const threeStarRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 3
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const fourStarRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 4
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

const fiveStarRating = computed(() => {
  const totalRatings = props.productReviews.filter(
    (review) => review.rating == 5
  );
  return ((totalRatings.length / props.productReviews.length) * 100).toFixed(0);
});

// const filterVerifiedPurchaser = computed(() => {
//   const ordefrs = props.paginateProductReviews.user.orders.filter((order) =>
//     order.order_items.filter(
//       (orderItem) =>
//         orderItem.produt_id === props.paginateProductReviews.product_id &&
//         orderItem.vendor_id === props.paginateProductReviews.vendor_id
//     )
//   );

//   return ordefrs.length ? true : false;
// });
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
          <p class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ reviewAvg }} out of 5
          </p>
        </div>
      </div>

      <p class="text-sm text-slate-400">
        Based on {{ productReviews.length }} user ratings
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
                <h1 class="font-bold text-lg text-slate-700">
                  {{ productReview.product.name }}
                </h1>
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

