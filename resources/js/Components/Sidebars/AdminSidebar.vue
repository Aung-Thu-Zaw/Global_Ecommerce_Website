<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
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
        Global Ecommerce
      </Link>
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <NotificationDropdown />
        </li>
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
                Global Ecommerce
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
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Admin Web Control Area
        </h6>
        <!-- Dashboard -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
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
              Dashboard
            </Link>
          </li>

          <!-- Brand Section -->
          <li v-if="brandMenu" class="items-center">
            <Link
              :href="route('admin.brands.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/brands'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/brands'),
              }"
            >
              <i class="fa-solid fa-award mr-2 text-sm"></i>
              Brands
            </Link>
          </li>

          <!-- Collection Section -->
          <li v-if="collectionMenu" class="items-center">
            <Link
              :href="route('admin.collections.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/collections'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/collections'),
              }"
            >
              <i class="fa-solid fa-box mr-2 text-sm"></i>
              Collections
            </Link>
          </li>

          <!-- Category Section -->
          <li v-if="categoryMenu" class="items-center">
            <Link
              :href="route('admin.categories.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/categories'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/categories'),
              }"
            >
              <i class="fa-solid fa-list mr-2 text-sm"></i>
              Categories
            </Link>
          </li>

          <!-- Product Section -->
          <li v-if="productMenu" class="items-center">
            <Link
              :href="route('admin.products.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/products'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/products'),
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              Products
            </Link>
          </li>

          <!-- Coupon Section -->
          <li v-if="couponMenu" class="items-center">
            <Link
              :href="route('admin.coupons.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/coupons'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/coupons'),
              }"
            >
              <i class="fa-solid fa-ticket mr-2 text-sm"></i>
              Coupons
            </Link>
          </li>
        </ul>

        <!-- Banner Section -->
        <ul
          v-if="bannerMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="bannersIsHidden = !bannersIsHidden"
            >
              <span>
                <i class="fa-solid fa-ad mr-2 text-sm"></i>
                Banners
              </span>
              <i v-if="bannersIsHidden" class="fa-solid fa-chevron-right"></i>
              <i v-if="!bannersIsHidden" class="fa-solid fa-chevron-down"></i>
            </div>

            <ul
              v-if="!bannersIsHidden || bannersArea"
              class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
            >
              <Link
                :href="route('admin.slider-banners.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/slider-banners'
                  ),
                }"
              >
                Slider Banners
              </Link>
              <Link
                :href="route('admin.campaign-banners.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/campaign-banners'
                  ),
                }"
              >
                Campaign Banners
              </Link>
              <Link
                :href="route('admin.product-banners.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/product-banners'
                  ),
                }"
              >
                Product Banners
              </Link>
            </ul>
          </li>
        </ul>

        <!-- Shipping Areas Section -->
        <ul
          v-if="shippingAreaMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="shippingAreaIsHidden = !shippingAreaIsHidden"
            >
              <span>
                <i class="fa-solid fa-map-location-dot mr-2 text-sm"></i>
                Shipping Areas
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
              <Link
                :href="route('admin.countries.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600':
                    $page.url.startsWith('/admin/countries'),
                }"
              >
                Country
              </Link>
              <Link
                :href="route('admin.regions.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600':
                    $page.url.startsWith('/admin/regions'),
                }"
              >
                Region
              </Link>
              <Link
                :href="route('admin.cities.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600':
                    $page.url.startsWith('/admin/cities'),
                }"
              >
                City
              </Link>
              <Link
                :href="route('admin.townships.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600':
                    $page.url.startsWith('/admin/townships'),
                }"
              >
                Township
              </Link>
            </ul>
          </li>
        </ul>

        <hr
          v-if="
            orderManageMenu || returnOrderManageMenu || cancelOrderManageMenu
          "
          class="my-4 md:min-w-full"
        />

        <!-- Order Management Area -->
        <h6
          v-if="
            orderManageMenu || returnOrderManageMenu || cancelOrderManageMenu
          "
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Order Managements
        </h6>

        <!-- Order Manage -->
        <ul
          v-if="orderManageMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="orderManageIsHidden = !orderManageIsHidden"
            >
              <span>
                <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
                Order Manage
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
              <Link
                :href="route('admin.orders.pending.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/order-manage/pending-orders'
                  ),
                }"
              >
                Pending Orders
              </Link>
              <Link
                :href="route('admin.orders.confirmed.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/order-manage/confirmed-orders'
                  ),
                }"
              >
                Confirmed Orders
              </Link>
              <Link
                :href="route('admin.orders.processing.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/order-manage/processing-orders'
                  ),
                }"
              >
                Processing Orders
              </Link>
              <Link
                :href="route('admin.orders.shipped.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/order-manage/shipped-orders'
                  ),
                }"
              >
                Shipped Orders
              </Link>
              <Link
                :href="route('admin.orders.delivered.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/order-manage/delivered-orders'
                  ),
                }"
              >
                Delivered Orders
              </Link>
            </ul>
          </li>
        </ul>

        <!-- Return Order Manage -->
        <ul
          v-if="returnOrderManageMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="returnOrderManageIsHidden = !returnOrderManageIsHidden"
            >
              <span>
                <i class="fa-solid fa-rotate-left mr-2 text-sm"></i>
                Return Order Manage
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
              <Link
                :href="route('admin.return-orders.requested.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/return-order-manage/requested-return'
                  ),
                }"
              >
                Requested Return
              </Link>
              <Link
                :href="route('admin.return-orders.approved.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/return-order-manage/approved-return'
                  ),
                }"
              >
                Approved Return
              </Link>
              <Link
                :href="route('admin.return-orders.refunded.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/return-order-manage/refunded-return'
                  ),
                }"
              >
                Refunded Return
              </Link>
            </ul>
          </li>
        </ul>

        <!-- Cancel Order Manage -->
        <ul
          v-if="cancelOrderManageMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="cancelOrderManageIsHidden = !cancelOrderManageIsHidden"
            >
              <span>
                <i class="fa-solid fa-xmark mr-2 text-sm"></i>
                Cancel Order Manage
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
              <Link
                :href="route('admin.cancel-orders.requested.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/cancel-order-manage/requested-cancel'
                  ),
                }"
              >
                Requested Cancel
              </Link>
              <Link
                :href="route('admin.cancel-orders.approved.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/cancel-order-manage/approved-cancel'
                  ),
                }"
              >
                Approved Cancel
              </Link>
            </ul>
          </li>
        </ul>

        <hr
          v-if="vendorManageMenu || userManageMenu || adminManageMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Management Area -->
        <h6
          v-if="vendorManageMenu || userManageMenu || adminManageMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          User Managements
        </h6>

        <!-- Vendor Manage -->
        <ul
          v-if="vendorManageMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="vendorManageIsHidden = !vendorManageIsHidden"
            >
              <span>
                <i class="fas fa-store mr-2 text-sm"></i>
                Vendor Manage
              </span>
              <i
                v-if="vendorManageIsHidden"
                class="fa-solid fa-chevron-right"
              ></i>
              <i
                v-if="!vendorManageIsHidden"
                class="fa-solid fa-chevron-down"
              ></i>
            </div>

            <ul
              v-if="!vendorManageIsHidden || vendorManage"
              class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
            >
              <Link
                :href="route('admin.vendors.active.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/vendor-manage/active-vendors'
                  ),
                }"
              >
                Active Vendors
              </Link>
              <Link
                :href="route('admin.vendors.inactive.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/vendor-manage/inactive-vendors'
                  ),
                }"
              >
                Inactive Vendors
              </Link>
            </ul>
          </li>
        </ul>
        <!-- User Manage -->
        <ul
          v-if="userManageMenu"
          class="md:flex-col md:min-w-full flex flex-col list-none"
        >
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="userManageIsHidden = !userManageIsHidden"
            >
              <span>
                <i class="fas fa-users mr-2 text-sm"></i>
                User Manage
              </span>
              <i
                v-if="userManageIsHidden"
                class="fa-solid fa-chevron-right"
              ></i>
              <i
                v-if="!userManageIsHidden"
                class="fa-solid fa-chevron-down"
              ></i>
            </div>

            <ul
              v-if="!userManageIsHidden || userManage"
              class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
            >
              <Link
                :href="route('admin.users.register.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/user-manage/register-users'
                  ),
                }"
              >
                Register Users
              </Link>
              <Link
                :href="route('admin.vendors.register.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/user-manage/register-vendors'
                  ),
                }"
              >
                Register Vendors
              </Link>
            </ul>
          </li>
        </ul>
        <!-- Admin Manage -->
        <ul v-if="adminManageMenu">
          <li class="items-center">
            <Link
              :href="route('admin.admin-manage.index')"
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
              Admin Manage
            </Link>
          </li>
        </ul>

        <hr
          v-if="roleAndPermissionMenu || roleInPermissionsMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Authorization Management Area -->
        <h6
          v-if="roleAndPermissionMenu || roleInPermissionsMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Authority Managements
        </h6>

        <!-- Role And Permission Manage -->
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
                Roles & Permissions
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
              v-if="!roleAndPermissionManageIsHidden || roleAndPermissionManage"
              class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
            >
              <Link
                :href="route('admin.roles.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/roles-and-permissions/roles'
                  ),
                }"
              >
                Roles
              </Link>
              <Link
                :href="route('admin.permissions.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/roles-and-permissions/permissions'
                  ),
                }"
              >
                Permissions
              </Link>
            </ul>
          </li>
        </ul>

        <!-- Role In Permission Manage -->
        <ul v-if="roleInPermissionsMenu">
          <li class="items-center">
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
            >
              <i class="fa-solid fa-user-lock mr-2 text-sm"></i>
              Role In Permissions
            </Link>
          </li>
        </ul>

        <!-- <ul class="md:flex-col md:min-w-full flex flex-col list-none">
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
              <i class="fa-solid fa-paper-plane mr-2 text-sm"></i>
              Send Emails
            </Link>
          </li>

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
              <i class="fa-solid fa-star mr-2 text-sm"></i>
              Reviews
            </Link>
          </li>

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
              <i class="fa-solid fa-flag mr-2 text-sm"></i>
              Reports
            </Link>
          </li>

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
              <i class="fa-solid fa-laptop mr-2 text-sm"></i>
              Blogs
            </Link>
          </li>

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
              <i class="fa-solid fa-arrow-trend-up mr-2 text-sm"></i>
              Product Stocks
            </Link>
          </li>
        </ul> -->

        <hr
          v-if="blogCategoryMenu || blogPostMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Blog Management Area -->
        <h6
          v-if="blogCategoryMenu || blogPostMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Blog Managements
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li v-if="blogCategoryMenu" class="items-center">
            <Link
              :href="route('admin.blogs.categories.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/blogs/categories',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/blogs/categories',
              }"
            >
              <i class="fa-regular fa-rectangle-list mr-2 text-sm"></i>
              Blog Categories
            </Link>
          </li>
          <li class="items-center" v-if="blogPostMenu">
            <Link
              :href="route('admin.blogs.posts.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/blogs/posts',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/blogs/posts',
              }"
            >
              <i class="fa-solid fa-newspaper mr-2 text-sm"></i>
              Blog Posts
            </Link>
          </li>
        </ul>

        <hr
          v-if="websiteSettingMenu || seoSettingMenu"
          class="my-4 md:min-w-full"
        />

        <!-- Site Settings -->
        <h6
          v-if="websiteSettingMenu || seoSettingMenu"
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Site Settings
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li v-if="websiteSettingMenu" class="items-center">
            <Link
              :href="route('admin.website-settings.edit')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/website-settings',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/website-settings',
              }"
            >
              <i class="fa-solid fa-gear mr-2 text-sm"></i>
              Website Settings
            </Link>
          </li>
          <li v-if="seoSettingMenu" class="items-center">
            <Link
              :href="route('admin.seo-settings.edit')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/seo-settings',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/seo-settings',
              }"
            >
              <i class="fa-brands fa-searchengin mr-2 text-sm"></i>
              SEO Setting
            </Link>
          </li>
        </ul>

        <hr class="my-4 md:min-w-full" />
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          From The Submitters
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li v-if="suggestionMenu" class="items-center">
            <Link
              :href="route('admin.suggestions.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/suggestions',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/suggestions',
              }"
            >
              <i class="fa-solid fa-lightbulb mr-2 text-sm"></i>

              Suggestions
            </Link>
          </li>
          <li v-if="feedbackMenu" class="items-center">
            <Link
              :href="route('admin.website-feedbacks.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/website-feedbacks',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/website-feedbacks',
              }"
            >
              <i class="fa-solid fa-message mr-2 text-sm"></i>
              Feedbacks
            </Link>
          </li>
          <li v-if="subscriberMenu" class="items-center">
            <Link
              :href="route('admin.subscribers.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/admin/subscribers',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/admin/subscribers',
              }"
            >
              <i class="fa-solid fa-user-check mr-2 text-sm"></i>
              Subscribers
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>


<script>
import { Link } from "@inertiajs/vue3";
import NotificationDropdown from "@/Components/Dropdowns/NotificationDropdown.vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";

export default {
  data() {
    return {
      collapseShow: "hidden",
      categoriesIsHidden: true,
      bannersIsHidden: true,
      shippingAreaIsHidden: true,
      vendorManageIsHidden: true,
      userManageIsHidden: true,
      orderManageIsHidden: true,
      returnOrderManageIsHidden: true,
      cancelOrderManageIsHidden: true,
      roleAndPermissionManageIsHidden: true,
    };
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },
  },

  computed: {
    vendorManage() {
      if (
        this.$page.url.startsWith("/admin/vendor-manage/inactive-vendors") ||
        this.$page.url.startsWith("/admin/vendor-manage/active-vendors")
      ) {
        return (this.vendorManageIsHidden = false);
      }
    },
    userManage() {
      if (
        this.$page.url.startsWith("/admin/user-manage/register-users") ||
        this.$page.url.startsWith("/admin/user-manage/offline-users") ||
        this.$page.url.startsWith("/admin/user-manage/register-vendors") ||
        this.$page.url.startsWith("/admin/user-manage/offline-vendors")
      ) {
        return (this.userManageIsHidden = false);
      }
    },
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

    brandMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "brand.menu"
          )
        : false;
    },

    collectionMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "collection.menu"
          )
        : false;
    },

    categoryMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "category.menu"
          )
        : false;
    },

    productMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "product.menu"
          )
        : false;
    },

    couponMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "coupon.menu"
          )
        : false;
    },

    bannerMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "banner.menu"
          )
        : false;
    },

    shippingAreaMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "shipping-area.menu"
          )
        : false;
    },

    orderManageMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "order-manage.menu"
          )
        : false;
    },

    returnOrderManageMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "return-order-manage.menu"
          )
        : false;
    },

    cancelOrderManageMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "cancel-order-manage.menu"
          )
        : false;
    },

    vendorManageMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "vendor-manage.menu"
          )
        : false;
    },

    userManageMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "user-manage.menu"
          )
        : false;
    },

    adminManageMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "admin-manage.menu"
          )
        : false;
    },

    roleAndPermissionMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "role-and-permission.menu"
          )
        : false;
    },

    roleInPermissionsMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "role-in-permissions.menu"
          )
        : false;
    },

    blogCategoryMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "blog-category.menu"
          )
        : false;
    },

    blogPostMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "blog-post.menu"
          )
        : false;
    },

    websiteSettingMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "website-setting.menu"
          )
        : false;
    },
    seoSettingMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "seo-setting.menu"
          )
        : false;
    },

    suggestionMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "suggestion.menu"
          )
        : false;
    },
    feedbackMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "feedback.menu"
          )
        : false;
    },
    subscriberMenu() {
      return this.$page.props.auth.user.permissions.length
        ? this.$page.props.auth.user.permissions.some(
            (permission) => permission.name === "subscriber.menu"
          )
        : false;
    },
  },
  components: {
    NotificationDropdown,
    UserDropdown,
    Link,
  },
};
</script>
