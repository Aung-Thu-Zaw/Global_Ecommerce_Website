<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

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
          class="mx-auto h-full object-cover"
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
        <!-- <span
          class="px-3 rounded-sm py-1 font-bold uppercase text-[0.7rem] text-white bg-fuchsia-600"
        >
          <i class="fas fa-crown"></i>
          Official
        </span> -->
        <h6 class="text-md mt-2">
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

        <div v-if="averageRating != 'NaN'" class="flex items-center">
          <svg
            aria-hidden="true"
            class="w-4 h-4"
            :class="{
              'text-yellow-400': averageRating >= 1,
              'text-gray-300': averageRating < 1,
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
            class="w-4 h-4"
            :class="{
              'text-yellow-400': averageRating >= 2,
              'text-gray-300': averageRating < 2 || averageRating >= 3,
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
            class="w-4 h-4"
            :class="{
              'text-yellow-400': averageRating >= 3,
              'text-gray-300': averageRating < 3 || averageRating >= 4,
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
            class="w-4 h-4"
            :class="{
              'text-yellow-400': averageRating >= 4,
              'text-gray-300': averageRating < 4 || averageRating >= 5,
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
            class="w-4 h-4"
            :class="{
              'text-yellow-400': averageRating >= 5,
              'text-gray-300': averageRating < 5,
            }"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
            ></path>
          </svg>
        </div>
      </div>
    </article>
  </div>
</template>

