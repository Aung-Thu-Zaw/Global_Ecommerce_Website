<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6 scrollbar"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
      >
        <i class="fas fa-bars"></i>
      </button>
      <Link
        :href="route('home')"
        class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
      >
        Global E-commerce
      </Link>
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <UserDropdown />
        </li>
      </ul>
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow"
      >
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-slate-200"
        >
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <Link
                :href="route('home')"
                class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
              >
                Global E-commerce
              </Link>
            </div>
            <div class="w-6/12 flex justify-end">
              <button
                type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input
              type="text"
              placeholder="Search"
              class="px-3 py-2 h-12 border border-solid border-slate-500 placeholder-slate-300 text-slate-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal"
            />
          </div>
        </form>

        <hr class="my-4 md:min-w-full" />

        <!-- Admin Dashboard Web Control Area Section Title -->
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("ECOMMERCE_CONTROL_AREA") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Dashboard Section -->
          <li class="items-center">
            <Link
              :href="route('admin.dashboard')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/dashboard',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/dashboard',
              }"
            >
              <i class="fa-solid fa-chart-line mr-2 text-sm"></i>

              {{ __("DASHBOARD") }}
            </Link>
          </li>

          <!-- Brand Section -->
          <li v-if="brandMenu" class="items-center">
            <Link
              :href="route('admin.brands.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/brands'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/brands'),
              }"
            >
              <i class="fa-solid fa-award mr-2 text-sm"></i>
              {{ __("BRANDS") }}
            </Link>
          </li>

          <!-- Collection Section -->
          <li v-if="collectionMenu" class="items-center">
            <Link
              :href="route('admin.collections.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/collections'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/collections'),
              }"
            >
              <i class="fa-solid fa-box mr-2 text-sm"></i>
              {{ __("COLLECTIONS") }}
            </Link>
          </li>

          <!-- Category Section -->
          <li v-if="categoryMenu" class="items-center">
            <Link
              :href="route('admin.categories.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/categories'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/categories'),
              }"
            >
              <i class="fa-solid fa-list mr-2 text-sm"></i>
              {{ __("CATEGORIES") }}
            </Link>
          </li>

          <!-- Product Section -->
          <li v-if="productMenu" class="items-center">
            <Link
              :href="route('admin.products.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/products'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/products'),
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              {{ __("PRODUCTS") }}
            </Link>
          </li>

          <!-- Coupon Section -->
          <li v-if="couponMenu" class="items-center">
            <Link
              :href="route('admin.coupons.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/coupons'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/coupons'),
              }"
            >
              <i class="fa-solid fa-ticket mr-2 text-sm"></i>
              {{ __("COUPONS") }}
            </Link>
          </li>

          <!-- Flash Sale Section -->
          <li v-if="flashSaleMenu" class="items-center">
            <Link
              :href="route('admin.flash-sales.edit')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/flash-sales'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/flash-sales'),
              }"
            >
              <i class="fa-solid fa-bolt-lightning mr-2 text-sm"></i>
              {{ __("FLASH_SALES") }}
            </Link>
          </li>

          <!-- Banner Sections -->
          <li v-if="bannerMenu" class="items-center">
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="bannersIsHidden = !bannersIsHidden"
                >
                  <span>
                    <i class="fa-solid fa-ad mr-2 text-sm"></i>
                    {{ __("BANNERS") }}
                  </span>
                  <i
                    v-if="bannersIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!bannersIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!bannersIsHidden || bannersArea"
                  class="text-[.84rem] ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Slider Banner Section -->

                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/slider-banners'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.slider-banners.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("SLIDER_BANNERS") }}
                    </Link>
                  </li>

                  <!-- Campaign Banner Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/campaign-banners'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.campaign-banners.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("CAMPAIGN_BANNERS") }}
                    </Link>
                  </li>

                  <!-- Product Banner Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/product-banners'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.product-banners.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("PRODUCT_BANNERS") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- Shipping Areas Section -->
          <li v-if="shippingAreaMenu" class="items-center">
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="shippingAreaIsHidden = !shippingAreaIsHidden"
                >
                  <span>
                    <i class="fa-solid fa-map-location-dot mr-2 text-sm"></i>
                    {{ __("SHIPPING_AREAS") }}
                  </span>
                  <i
                    v-if="shippingAreaIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!shippingAreaIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!shippingAreaIsHidden || shippingArea"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Country Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600':
                        $page.url.startsWith('/admin/countries'),
                    }"
                  >
                    <Link
                      :href="route('admin.countries.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      Country
                    </Link>
                  </li>

                  <!-- Region Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600':
                        $page.url.startsWith('/admin/regions'),
                    }"
                  >
                    <Link
                      :href="route('admin.regions.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      Region
                    </Link>
                  </li>

                  <!-- City Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600':
                        $page.url.startsWith('/admin/cities'),
                    }"
                  >
                    <Link
                      :href="route('admin.cities.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      City
                    </Link>
                  </li>

                  <!-- Township Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600':
                        $page.url.startsWith('/admin/townships'),
                    }"
                  >
                    <Link
                      :href="route('admin.townships.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      Township
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>

        <hr
          v-if="
            orderManageMenu || returnOrderManageMenu || cancelOrderManageMenu
          "
          class="my-4 md:min-w-full"
        />

        <!-- Order Managements Section Title -->
        <h6
          v-if="
            orderManageMenu || returnOrderManageMenu || cancelOrderManageMenu
          "
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("ORDER_MANAGEMENTS") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Order Manage Section -->
          <li v-if="orderManageMenu" class="items-center">
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="orderManageIsHidden = !orderManageIsHidden"
                >
                  <span>
                    <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
                    {{ __("ORDER_MANAGE") }}
                  </span>
                  <i
                    v-if="orderManageIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!orderManageIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!orderManageIsHidden || orderManage"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Pending Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/order-manage/pending-orders'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.orders.pending.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("PENDING_ORDERS") }}
                    </Link>
                  </li>

                  <!-- Confirmed Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/order-manage/confirmed-orders'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.orders.confirmed.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("CONFIRMED_ORDERS") }}
                    </Link>
                  </li>

                  <!-- Processing Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/order-manage/processing-orders'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.orders.processing.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("PROCESSING_ORDERS") }}
                    </Link>
                  </li>

                  <!-- Shipped Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/order-manage/shipped-orders'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.orders.shipped.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("SHIPPED_ORDERS") }}
                    </Link>
                  </li>

                  <!-- Delivered Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/order-manage/delivered-orders'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.orders.delivered.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("DELIVERED_ORDERS") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- Return Order Manage Section -->
          <li v-if="returnOrderManageMenu" class="items-center">
            <!-- Return Order Manage -->
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="
                    returnOrderManageIsHidden = !returnOrderManageIsHidden
                  "
                >
                  <span>
                    <i class="fa-solid fa-rotate-left mr-2 text-sm"></i>
                    {{ __("RETURN_ORDER_MANAGE") }}
                  </span>
                  <i
                    v-if="returnOrderManageIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!returnOrderManageIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!returnOrderManageIsHidden || returnOrderManage"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Requested Return Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/return-order-manage/requested-return'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.return-orders.requested.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("REQUESTED_RETURNS") }}
                    </Link>
                  </li>

                  <!-- Approved Return Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/return-order-manage/approved-return'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.return-orders.approved.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("APPROVED_RETURNS") }}
                    </Link>
                  </li>

                  <!-- Refunded Return Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/return-order-manage/refunded-return'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.return-orders.refunded.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("REFUNDED_RETURNS") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- Cancel Order Manage Section -->
          <li v-if="cancelOrderManageMenu" class="items-center">
            <!-- Cancel Order Manage -->
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="
                    cancelOrderManageIsHidden = !cancelOrderManageIsHidden
                  "
                >
                  <span>
                    <i class="fa-solid fa-xmark mr-2 text-sm"></i>
                    {{ __("CANCEL_ORDER_MANAGE") }}
                  </span>
                  <i
                    v-if="cancelOrderManageIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!cancelOrderManageIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!cancelOrderManageIsHidden || cancelOrderManage"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Requested Cancel Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/cancel-order-manage/requested-cancel'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.cancel-orders.requested.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("REQUESTED_CANCELS") }}
                    </Link>
                  </li>

                  <!-- Approved Cancel Order Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/cancel-order-manage/approved-cancel'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.cancel-orders.approved.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("APPROVED_CANCELS") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>

        <hr
          v-if="productReviewMenu || shopReviewMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Review Managements Section Title -->
        <h6
          v-if="productReviewMenu || shopReviewMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("REVIEW_MANAGEMENTS") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Product Reviews Section -->
          <li v-if="productReviewMenu" class="items-center">
            <Link
              :href="route('admin.product-reviews.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/product-reviews'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/product-reviews'
                ),
              }"
            >
              <i class="fa-solid fa-star mr-2 text-sm"></i>
              {{ __("PRODUCT_REVIEWS") }}
            </Link>
          </li>

          <!-- Shop Reviews Section -->
          <li v-if="shopReviewMenu" class="items-center">
            <Link
              :href="route('admin.shop-reviews.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/shop-reviews'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/shop-reviews'
                ),
              }"
            >
              <i class="fa-solid fa-shop mr-2 text-sm"></i>
              {{ __("SHOP_REVIEWS") }}
            </Link>
          </li>
        </ul>

        <hr
          v-if="sellerManageMenu || registeredAccountMenu || adminManageMenu"
          class="my-4 md:min-w-full"
        />

        <!-- User Managements Section Title -->
        <h6
          v-if="sellerManageMenu || registeredAccountMenu || adminManageMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("USER_MANAGEMENTS") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Seller Manage Section -->
          <li v-if="sellerManageMenu" class="items-center">
            <Link
              :href="route('admin.seller-manage.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/seller-manage'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/seller-manage'
                ),
              }"
            >
              <i class="fas fa-shop mr-2 text-sm"></i>
              {{ __("SELLER_MANAGE") }}
            </Link>
          </li>

          <!-- Registered Account Manage Section -->
          <li v-if="registeredAccountMenu" class="items-center">
            <Link
              :href="route('admin.registered-accounts.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/registered-accounts'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/registered-accounts'
                ),
              }"
            >
              <i class="fas fa-users mr-2 text-sm"></i>
              {{ __("REGISTERED_ACCOUNTS") }}
            </Link>
          </li>

          <!-- Admin Manage Section -->
          <li v-if="adminManageMenu" class="items-center">
            <Link
              :href="route('admin.admin-manage.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/admin-manage'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/admin-manage'
                ),
              }"
            >
              <i class="fa-solid fa-user-gear mr-2 text-sm"></i>
              {{ __("ADMIN_MANAGE") }}
            </Link>
          </li>
        </ul>

        <hr
          v-if="roleAndPermissionMenu || roleInPermissionsMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Authority Managements Section Title -->
        <h6
          v-if="roleAndPermissionMenu || roleInPermissionsMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("AUTHORITY_MANAGEMENTS") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Roles And Permissions Section -->
          <li class="items-center">
            <ul
              v-if="roleAndPermissionMenu"
              class="md:flex-col md:min-w-full flex flex-col list-none"
            >
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="
                    roleAndPermissionManageIsHidden =
                      !roleAndPermissionManageIsHidden
                  "
                >
                  <span>
                    <i class="fa-solid fa-user-shield mr-2 text-sm"></i>
                    {{ __("ROLES_AND_PERMISSIONS") }}
                  </span>
                  <i
                    v-if="roleAndPermissionManageIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!roleAndPermissionManageIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="
                    !roleAndPermissionManageIsHidden || roleAndPermissionManage
                  "
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Roles Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/roles-and-permissions/roles'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.roles.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("ROLES") }}
                    </Link>
                  </li>

                  <!-- Permissions Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/roles-and-permissions/permissions'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.permissions.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("PERMISSIONS") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- Role In Permissions Section -->
          <li v-if="roleInPermissionsMenu" class="items-center">
            <Link
              :href="route('admin.role-in-permissions.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/role-in-permissions'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/role-in-permissions'
                ),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-user-lock mr-2 text-sm"></i>
              {{ __("ROLE_IN_PERMISSIONS") }}
            </Link>
          </li>
        </ul>

        <hr
          v-if="blogCategoryMenu || blogPostMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Blog Managements Section Title -->
        <h6
          v-if="blogCategoryMenu || blogPostMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("BLOG_MANAGEMENTS") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Blog Category Section -->
          <li v-if="blogCategoryMenu" class="items-center">
            <Link
              :href="route('admin.blogs.categories.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/blogs/categories'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/blogs/categories'
                ),
              }"
            >
              <i class="fa-regular fa-rectangle-list mr-2 text-sm"></i>
              {{ __("BLOG_CATEGORIES") }}
            </Link>
          </li>

          <!-- Blog Post Section -->
          <li v-if="blogPostMenu" class="items-center">
            <Link
              :href="route('admin.blogs.posts.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/blogs/posts'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/blogs/posts'),
              }"
            >
              <i class="fa-solid fa-newspaper mr-2 text-sm"></i>
              {{ __("BLOG_POSTS") }}
            </Link>
          </li>

          <!-- Blog Comment Section -->
          <li v-if="blogCommentMenu" class="items-center">
            <Link
              :href="route('admin.blogs.comments.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/blogs/comments'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/blogs/comments'
                ),
              }"
            >
              <i class="fa-solid fa-comment mr-2 text-sm"></i>
              {{ __("BLOG_COMMENTS") }}
            </Link>
          </li>
        </ul>

        <hr v-if="settingMenu || pageMenu" class="my-4 md:min-w-full" />

        <!-- Admin Dashboard Web Control Area Section Title -->
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("ADMIN_WEB_CONTROL_AREA") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Settings Section -->
          <li v-if="settingMenu" class="items-center">
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="settingManageIsHidden = !settingManageIsHidden"
                >
                  <span>
                    <i class="fa-solid fa-gear mr-2 text-sm"></i>
                    {{ __("SETTINGS") }}
                  </span>
                  <i
                    v-if="settingManageIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!settingManageIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!settingManageIsHidden || settingManage"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Website Setting Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/settings/website-settings'
                      ),
                    }"
                  >
                    <Link :href="route('admin.website-settings.edit')">
                      {{ __("WEBSITE_SETTING") }}
                    </Link>
                  </li>

                  <!-- SEO Setting Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/settings/seo-settings'
                      ),
                    }"
                  >
                    <Link :href="route('admin.seo-settings.edit')">
                      {{ __("SEO_SETTING") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- Pages Section -->
          <li v-if="pageMenu" class="items-center">
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="pageManageIsHidden = !pageManageIsHidden"
                >
                  <span>
                    <i class="fa-solid fa-file-lines mr-2 text-sm"></i>
                    {{ __("PAGES") }}
                  </span>
                  <i
                    v-if="pageManageIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!pageManageIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!pageManageIsHidden || pageManage"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Offices Section -->
                  <!-- <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/return-order-manage/requested-return'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.return-orders.requested.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("OUR_OFFICES") }}
                    </Link>
                  </li> -->

                  <!-- Terms And Conditions Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/pages/terms-and-conditions'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.pages.terms-and-conditions.edit')"
                    >
                      {{ __("TERMS_AND_CONDITIONS") }}
                    </Link>
                  </li>
                  <!-- Privacy And Policy Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/pages/privacy-policy'
                      ),
                    }"
                  >
                    <Link :href="route('admin.pages.privacy-policy.edit')">
                      {{ __("PRIVACY_POLICY") }}
                    </Link>
                  </li>
                  <!-- Returns And Refunds Section -->
                  <!-- <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/return-order-manage/requested-return'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.return-orders.requested.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("RETURNS_AND_REFUNDS") }}
                    </Link>
                  </li> -->
                </ul>
              </li>
            </ul>
          </li>

          <!-- FAQ Categories Section -->
          <li v-if="faqCategoryMenu" class="items-center">
            <ul class="md:flex-col md:min-w-full flex flex-col list-none">
              <li class="items-center cursor-pointer">
                <div
                  class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                  @click="faqCategoriesIsHidden = !faqCategoriesIsHidden"
                >
                  <span>
                    <i class="fa-solid fa-clipboard-list mr-2 text-sm"></i>
                    {{ __("FAQ_CATEGORIES") }}
                  </span>
                  <i
                    v-if="faqCategoriesIsHidden"
                    class="fa-solid fa-chevron-right"
                  ></i>
                  <i
                    v-if="!faqCategoriesIsHidden"
                    class="fa-solid fa-chevron-down"
                  ></i>
                </div>

                <ul
                  v-if="!faqCategoriesIsHidden || faqCategoryMange"
                  class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
                >
                  <!-- Faq Category Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/faq-categories/categories'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.faq-categories.categories.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("CATEGORIES") }}
                    </Link>
                  </li>

                  <!-- Faq Sub Category Section -->
                  <li
                    class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                    :class="{
                      'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                        '/admin/faq-categories/sub-categories'
                      ),
                    }"
                  >
                    <Link
                      :href="route('admin.faq-categories.sub-categories.index')"
                      :data="{
                        page: 1,
                        per_page: 10,
                        sort: 'id',
                        direction: 'desc',
                      }"
                    >
                      {{ __("SUBCATEGORIES") }}
                    </Link>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- Admin Manage Section -->
          <li v-if="faqMenu" class="items-center">
            <Link
              :href="route('admin.faqs.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/faqs'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/faqs'),
              }"
            >
              <i class="fa-solid fa-circle-question mr-2 text-sm"></i>
              {{ __("FAQS") }}
            </Link>
          </li>
        </ul>

        <hr v-if="chatMenu" class="my-4 md:min-w-full" />

        <!-- Support Contact Service Section Title -->
        <h6
          v-if="chatMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("CONTACT_SERVICES") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Chats Section -->
          <li v-if="chatMenu" class="items-center">
            <Link
              :href="route('admin.chats.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/chats'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/chats'),
              }"
            >
              <i class="fa-solid fa-comment mr-2 text-sm"></i>
              {{ __("CHATS") }}
            </Link>
          </li>

          <!-- Email Section -->
          <li class="items-center">
            <Link
              href="#"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/emails'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/emails'),
              }"
            >
              <i class="fa-solid fa-envelope mr-2 text-sm"></i>
              {{ __("EMAILS") }}
            </Link>
          </li>

          <!-- Phone Call Section -->
          <li class="items-center">
            <Link
              href="#"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/phone-calls'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/phone-calls'),
              }"
            >
              <i class="fa-solid fa-phone mr-2 text-sm"></i>
              {{ __("PHONE_CALLS") }}
            </Link>
          </li>
        </ul>

        <hr
          v-if="subscriberMenu || suggestionMenu || websiteFeedbackMenu"
          class="my-4 md:min-w-full"
        />

        <!-- From The Submitters Section Title -->
        <h6
          v-if="subscriberMenu || suggestionMenu || websiteFeedbackMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("FROM_THE_SUBMITTERS") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Subscriber Section -->
          <li v-if="subscriberMenu" class="items-center">
            <Link
              :href="route('admin.subscribers.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/subscribers'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/subscribers'),
              }"
            >
              <i class="fa-solid fa-user-check mr-2 text-sm"></i>
              {{ __("SUBSCRIBERS") }}
            </Link>
          </li>

          <!-- Suggestion Section -->
          <li v-if="suggestionMenu" class="items-center">
            <Link
              :href="route('admin.suggestions.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/suggestions'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/suggestions'),
              }"
            >
              <i class="fa-solid fa-lightbulb mr-2 text-sm"></i>

              {{ __("SUGGESTIONS") }}
            </Link>
          </li>

          <!-- Website Feedback Section -->
          <li v-if="websiteFeedbackMenu" class="items-center">
            <Link
              :href="route('admin.website-feedbacks.index')"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/admin/website-feedbacks'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/admin/website-feedbacks'
                ),
              }"
            >
              <i class="fa-solid fa-message mr-2 text-sm"></i>
              {{ __("WEBSITE_FEEDBACKS") }}
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>


<script>
import { Link } from "@inertiajs/vue3";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";

export default {
  data() {
    return {
      collapseShow: "hidden",
      categoriesIsHidden: true,
      bannersIsHidden: true,
      shippingAreaIsHidden: true,
      sellerManageIsHidden: true,
      userManageIsHidden: true,
      orderManageIsHidden: true,
      settingManageIsHidden: true,
      pageManageIsHidden: true,
      returnOrderManageIsHidden: true,
      faqCategoriesIsHidden: true,
      cancelOrderManageIsHidden: true,
      shopReviewManageIsHidden: true,
      productReviewManageIsHidden: true,
      roleAndPermissionManageIsHidden: true,
      permissions: this.$page.props.auth.user.permissions,
    };
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },
  },

  computed: {
    orderManage() {
      if (
        this.$page.url.startsWith("/admin/order-manage/pending-orders") ||
        this.$page.url.startsWith("/admin/order-manage/confirmed-orders") ||
        this.$page.url.startsWith("/admin/order-manage/processing-orders") ||
        this.$page.url.startsWith("/admin/order-manage/shipped-orders") ||
        this.$page.url.startsWith("/admin/order-manage/delivered-orders")
      ) {
        return (this.orderManageIsHidden = false);
      }
    },
    settingManage() {
      if (
        this.$page.url.startsWith("/admin/settings/website-settings") ||
        this.$page.url.startsWith("/admin/settings/seo-settings")
      ) {
        return (this.settingManageIsHidden = false);
      }
    },
    pageManage() {
      if (
        this.$page.url.startsWith("/admin/pages/privacy-policy") ||
        this.$page.url.startsWith("/admin/pages/terms-and-conditions")
      ) {
        return (this.pageManageIsHidden = false);
      }
    },
    faqCategoryMange() {
      if (
        this.$page.url.startsWith("/admin/faq-categories/categories") ||
        this.$page.url.startsWith("/admin/faq-categories/sub-categories")
      ) {
        return (this.faqCategoriesIsHidden = false);
      }
    },
    returnOrderManage() {
      if (
        this.$page.url.startsWith(
          "/admin/return-order-manage/requested-return"
        ) ||
        this.$page.url.startsWith(
          "/admin/return-order-manage/approved-return"
        ) ||
        this.$page.url.startsWith("/admin/return-order-manage/refunded-return")
      ) {
        return (this.returnOrderManageIsHidden = false);
      }
    },
    cancelOrderManage() {
      if (
        this.$page.url.startsWith(
          "/admin/cancel-order-manage/requested-cancel"
        ) ||
        this.$page.url.startsWith("/admin/cancel-order-manage/approved-cancel")
      ) {
        return (this.cancelOrderManageIsHidden = false);
      }
    },

    categoriesArea() {
      if (
        this.$page.url.startsWith("/admin/categories") ||
        this.$page.url.startsWith("/admin/sub-categories")
      ) {
        return (this.categoriesIsHidden = false);
      }
    },
    bannersArea() {
      if (
        this.$page.url.startsWith("/admin/slider-banners") ||
        this.$page.url.startsWith("/admin/campaign-banners") ||
        this.$page.url.startsWith("/admin/product-banners")
      ) {
        return (this.bannersIsHidden = false);
      }
    },
    shippingArea() {
      if (
        this.$page.url.startsWith("/admin/countries") ||
        this.$page.url.startsWith("/admin/regions") ||
        this.$page.url.startsWith("/admin/cities") ||
        this.$page.url.startsWith("/admin/townships")
      ) {
        return (this.shippingAreaIsHidden = false);
      }
    },
    roleAndPermissionManage() {
      if (
        this.$page.url.startsWith("/admin/roles-and-permissions/roles") ||
        this.$page.url.startsWith("/admin/roles-and-permissions/permissions")
      ) {
        return (this.roleAndPermissionManageIsHidden = false);
      }
    },
    productReviewManage() {
      if (
        this.$page.url.startsWith("/admin/product-reviews/pending-reviews") ||
        this.$page.url.startsWith("/admin/product-reviews/published-reviews")
      ) {
        return (this.productReviewManageIsHidden = false);
      }
    },
    shopReviewManage() {
      if (
        this.$page.url.startsWith("/admin/shop-reviews/pending-reviews") ||
        this.$page.url.startsWith("/admin/shop-reviews/published-reviews")
      ) {
        return (this.shopReviewManageIsHidden = false);
      }
    },

    brandMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "brand.menu"
          )
        : false;
    },

    collectionMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "collection.menu"
          )
        : false;
    },

    categoryMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "category.menu"
          )
        : false;
    },

    productMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "product.menu"
          )
        : false;
    },

    couponMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "coupon.menu"
          )
        : false;
    },

    flashSaleMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "flash-sale.menu"
          )
        : false;
    },

    bannerMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "banner.menu"
          )
        : false;
    },

    shippingAreaMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "shipping-area.menu"
          )
        : false;
    },

    languageMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "language.menu"
          )
        : false;
    },

    orderManageMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "order-manage.menu"
          )
        : false;
    },

    returnOrderManageMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "return-order-manage.menu"
          )
        : false;
    },

    cancelOrderManageMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "cancel-order-manage.menu"
          )
        : false;
    },

    sellerManageMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "seller-manage.menu"
          )
        : false;
    },

    productReviewMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "product-review.menu"
          )
        : false;
    },

    shopReviewMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "shop-review.menu"
          )
        : false;
    },

    registeredAccountMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "registered-account.menu"
          )
        : false;
    },

    adminManageMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "admin-manage.menu"
          )
        : false;
    },

    roleAndPermissionMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "role-and-permission.menu"
          )
        : false;
    },

    roleInPermissionsMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "role-in-permissions.menu"
          )
        : false;
    },

    blogCategoryMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "blog-category.menu"
          )
        : false;
    },

    blogPostMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "blog-post.menu"
          )
        : false;
    },

    blogCommentMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "blog-comment.menu"
          )
        : false;
    },

    settingMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "setting.menu"
          )
        : false;
    },

    pageMenu() {
      return this.permissions.length
        ? this.permissions.some((permission) => permission.name === "page.menu")
        : false;
    },

    faqCategoryMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "faq-category.menu"
          )
        : false;
    },

    faqMenu() {
      return this.permissions.length
        ? this.permissions.some((permission) => permission.name === "faq.menu")
        : false;
    },

    chatMenu() {
      return this.permissions.length
        ? this.permissions.some((permission) => permission.name === "chat.menu")
        : false;
    },

    suggestionMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "suggestion.menu"
          )
        : false;
    },
    websiteFeedbackMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "website-feedback.menu"
          )
        : false;
    },
    subscriberMenu() {
      return this.permissions.length
        ? this.permissions.some(
            (permission) => permission.name === "subscriber.menu"
          )
        : false;
    },
  },
  components: {
    UserDropdown,
    Link,
  },
};
</script>
