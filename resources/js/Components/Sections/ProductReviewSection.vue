
<script setup>
import ReplyCard from "@/Components/Cards/ReplyCard.vue";
import ReviewCard from "@/Components/Cards/ReviewCard.vue";
import ProductReviewForm from "@/Components/Form/ProductReviewForm.vue";
import { Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({ product: Object, productReviews: Object });
</script>

<template>
  <div class="text-center mb-5 p-5">
    <h1 class="font-bold text-slate-600 text-xl my-3">Product Reviews</h1>

    <div class="flex items-center justify-center">
      <div class="flex items-center mb-3">
        <svg
          aria-hidden="true"
          class="w-5 h-5 text-yellow-400"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>First star</title>
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
          ></path>
        </svg>
        <svg
          aria-hidden="true"
          class="w-5 h-5 text-yellow-400"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Second star</title>
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
          ></path>
        </svg>
        <svg
          aria-hidden="true"
          class="w-5 h-5 text-yellow-400"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Third star</title>
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
          ></path>
        </svg>
        <svg
          aria-hidden="true"
          class="w-5 h-5 text-yellow-400"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Fourth star</title>
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
          ></path>
        </svg>
        <svg
          aria-hidden="true"
          class="w-5 h-5 text-gray-300 dark:text-gray-500"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Fifth star</title>
          <path
            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
          ></path>
        </svg>
        <p class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
          4.95 out of 5
        </p>
      </div>
    </div>

    <p class="text-sm text-slate-400">Based on 123 users ratings</p>

    <div class="flex items-center mt-4 justify-center">
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >5 star</span
      >
      <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
        <div class="h-5 bg-yellow-400 rounded" style="width: 70%"></div>
      </div>
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >70%</span
      >
    </div>
    <div class="flex items-center mt-4 justify-center">
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >4 star</span
      >
      <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
        <div class="h-5 bg-yellow-400 rounded" style="width: 17%"></div>
      </div>
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >17%</span
      >
    </div>
    <div class="flex items-center mt-4 justify-center">
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >3 star</span
      >
      <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
        <div class="h-5 bg-yellow-400 rounded" style="width: 8%"></div>
      </div>
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >8%</span
      >
    </div>
    <div class="flex items-center mt-4 justify-center">
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >2 star</span
      >
      <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
        <div class="h-5 bg-yellow-400 rounded" style="width: 4%"></div>
      </div>
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >4%</span
      >
    </div>
    <div class="flex items-center mt-4 justify-center">
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >1 star</span
      >
      <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
        <div class="h-5 bg-yellow-400 rounded" style="width: 1%"></div>
      </div>
      <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
        >1%</span
      >
    </div>
  </div>

  <hr />

  <div class="p-5">
    <h1 class="font-bold text-slate-600 text-xl my-3">
      Customer Product Reviews
    </h1>

    <!-- Card  -->
    <div
      v-for="productReview in productReviews.data"
      :key="productReview.id"
      class="shadow border rounded-md p-5 flex flex-col items-start my-3"
    >
      <ReviewCard :productReview="productReview" />

      <ReplyCard />
    </div>

    <!-- Pagination -->
    <div>
      <pagination class="mt-6" :links="productReviews.links" />
    </div>
  </div>
  <hr />

  <div
    v-if="$page.props.auth.user && $page.props.auth.user.id !== product.user_id"
  >
    <ProductReviewForm :product="product" />
  </div>
  <div v-else-if="!$page.props.auth.user" class="px-5 my-5">
    <p class="font-bold text-sm text-slate-600 text-center">
      If you want to review this product you need to login first. Here
      <Link :href="route('login')" class="text-blue-600 underline">
        Login
      </Link>
      Or
      <Link :href="route('register')" class="text-blue-600 underline">
        Register
      </Link>
    </p>
  </div>
</template>


