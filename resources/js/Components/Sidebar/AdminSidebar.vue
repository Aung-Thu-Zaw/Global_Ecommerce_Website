<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
      >
        <i class="fas fa-bars"></i>
      </button>
      <!-- Brand -->
      <a
        href="#"
        class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
      >
        Global Ecommerce
      </a>
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <NotificationDropdown />
        </li>
        <li class="inline-block relative">
          <UserDropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow"
      >
        <!-- Collapse header -->
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-slate-200"
        >
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <a
                href="#"
                class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
              >
                Global Ecommerce
              </a>
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
        <!-- Form -->
        <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input
              type="text"
              placeholder="Search"
              class="px-3 py-2 h-12 border border-solid border-slate-500 placeholder-slate-300 text-slate-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal"
            />
          </div>
        </form>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Admin Control Area
        </h6>
        <!-- Navigation -->
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
          <!-- <li class="items-center">
            <Link
              :href="route('admin.sliders.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/sliders'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/sliders'),
              }"
            >
              <i class="fa-solid fa-tag mr-2 text-sm"></i>
              Sliders
            </Link>
          </li>
          <li class="items-center">
            <Link
              :href="route('admin.banners.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/banners'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/banners'),
              }"
            >
              <i class="fa-solid fa-ad mr-2 text-sm"></i>
              Banners
            </Link>
          </li> -->

          <!-- Navigation -->
          <ul class="md:flex-col md:min-w-full flex flex-col list-none">
            <li class="items-center cursor-pointer">
              <div
                class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
                @click="categoriesIsHidden = !categoriesIsHidden"
              >
                <span>
                  <i class="fa-solid fa-laptop mr-2 text-sm"></i>
                  Categories
                </span>
                <i
                  v-if="categoriesIsHidden"
                  class="fa-solid fa-chevron-right"
                ></i>
                <i
                  v-if="!categoriesIsHidden"
                  class="fa-solid fa-chevron-down"
                ></i>
              </div>
              <!-- </Link> -->

              <ul
                v-if="!categoriesIsHidden || categoriesArea"
                class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
              >
                <Link
                  :href="route('admin.categories.index')"
                  class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                  :class="{
                    'text-blue-500 hover:text-blue-600':
                      $page.url.startsWith('/admin/categories'),
                  }"
                >
                  Category
                </Link>
                <Link
                  :href="route('admin.subcategories.index')"
                  class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                  :class="{
                    'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                      '/admin/sub-categories'
                    ),
                  }"
                >
                  Sub Category
                </Link>
              </ul>
            </li>
          </ul>
          <ul class="md:flex-col md:min-w-full flex flex-col list-none">
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
              <!-- </Link> -->

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
                  Slider Banner
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
                  Campaign Banner
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
                  Product Banner
                </Link>
              </ul>
            </li>
          </ul>

          <li class="items-center">
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

          <li class="items-center">
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
        </ul>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          Managements
        </h6>
        <!-- Navigation -->
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li class="items-center cursor-pointer">
            <div
              class="text-xs flex items-center justify-between uppercase py-3 font-bold text-slate-700 hover:text-slate-500"
              @click="vendorManageIsHidden = !vendorManageIsHidden"
            >
              <span>
                <i class="fas fa-store mr-2 text-sm"></i>
                Vendors Manage
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
            <!-- </Link> -->

            <ul
              v-if="!vendorManageIsHidden || vendorManage"
              class="text-sm ml-10 font-bold text-slate-500 h-auto flex flex-col items-center"
            >
              <Link
                :href="route('admin.vendors.active.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/managements/active-vendors'
                  ),
                }"
              >
                Active Vendor
              </Link>
              <Link
                :href="route('admin.vendors.inactive.index')"
                class="p-2 hover:text-slate-700 text-left w-full hover:bg-slate-100"
                :class="{
                  'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                    '/admin/managements/inactive-vendors'
                  ),
                }"
              >
                Inactive Vendor
              </Link>
            </ul>
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
      vendorManageIsHidden: true,
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
        this.$page.url.startsWith("/admin/managements/inactive-vendors") ||
        this.$page.url.startsWith("/admin/managements/active-vendors")
      ) {
        return (this.vendorManageIsHidden = false);
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
  },
  components: {
    NotificationDropdown,
    UserDropdown,
    Link,
  },
};
</script>
