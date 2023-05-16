<script setup>
import FromTheSameStore from "@/Components/FromTheSameStore.vue";
import AskQuestionSection from "@/Components/Sections/AskQuestionSection.vue";
import ProductReviewSection from "@/Components/Sections/ProductReviewSection.vue";

const props = defineProps({
  productQuestions: Object,
  productReviews: Object,
  specificShopProducts: Object,
  product: Object,
});
</script>

<template>
  <section class="bg-gray-100 py-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="flex flex-wrap -mx-2">
        <div class="lg:w-3/4 px-2">
          <div class="border mb-10">
            <div class="border border-gray-200 shadow-sm rounded bg-white">
              <ul
                class="flex flex-wrap -mb-px text-sm font-medium text-center"
                id="myTab"
                data-tabs-toggle="#myTabContent"
                role="tablist"
              >
                <li class="mr-2" role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 rounded-t-lg"
                    id="description-tab"
                    data-tabs-target="#description"
                    type="button"
                    role="tab"
                    aria-controls="description"
                    aria-selected="false"
                  >
                    Description
                  </button>
                </li>
                <li class="mr-2" role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                    id="delivery-tab"
                    data-tabs-target="#delivery"
                    type="button"
                    role="tab"
                    aria-controls="delivery"
                    aria-selected="false"
                  >
                    Delievery & Services
                  </button>
                </li>
                <li class="mr-2" role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                    id="payment-tab"
                    data-tabs-target="#payment"
                    type="button"
                    role="tab"
                    aria-controls="payment"
                    aria-selected="false"
                  >
                    Available Payments
                  </button>
                </li>

                <li role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                    id="reviews-tab"
                    data-tabs-target="#reviews"
                    type="button"
                    role="tab"
                    aria-controls="reviews"
                    aria-selected="false"
                  >
                    Product Reviews
                  </button>
                </li>
              </ul>
            </div>
            <div id="myTabContent" class="">
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="description"
                role="tabpanel"
                aria-labelledby="description-tab"
              >
                <p
                  v-html="product.description"
                  class="text-sm text-gray-600 font-medium dark:text-gray-400"
                ></p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="delivery"
                role="tabpanel"
                aria-labelledby="delivery-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400"></p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="payment"
                role="tabpanel"
                aria-labelledby="payment-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400">Wavepay</p>
              </div>

              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 bg-white"
                id="reviews"
                role="tabpanel"
                aria-labelledby="reviews-tab"
              >
                <ProductReviewSection
                  :product="product"
                  :productReviews="productReviews"
                />
              </div>
            </div>
          </div>
          <div>
            <AskQuestionSection
              :product="product"
              :productQuestions="productQuestions"
            />
          </div>
        </div>

        <FromTheSameStore :specificShopProducts="specificShopProducts" />
      </div>
    </div>
  </section>
</template>
