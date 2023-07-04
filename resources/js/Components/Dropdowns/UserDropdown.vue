<template>
  <div>
    <a
      class="text-slate-500 block"
      href="#pablo"
      ref="btnDropdownRef"
      v-on:click="toggleDropdown($event)"
    >
      <div class="items-center flex">
        <span
          class="w-12 h-12 text-sm text-white bg-slate-200 inline-flex items-center justify-center rounded-full ring-2"
        >
          <img
            alt=""
            class="w-full h-full object-cover rounded-full align-middle border-none shadow-lg ring-2 ring-slate-400"
            :src="$page.props.auth.user.avatar"
          />
        </span>

        <span
          v-if="
            $page.url.startsWith('/admin') || $page.url.startsWith('/vendor')
          "
          class="font-bold ml-2"
          :class="{
            'text-slate-600 md:text-white':
              $page.url === '/admin/dashboard' ||
              $page.url === '/vendor/dashboard',

            'text-white':
              $page.url !== '/admin/dashboard' ||
              $page.url !== '/vendor/dashboard',
          }"
          >{{ $page.props.auth.user.name }}
        </span>
        <span v-else class="font-bold ml-2 text-slate-600"
          >{{ $page.props.auth.user.name }}
        </span>
      </div>
    </a>
    <div
      ref="popoverDropdownRef"
      class="bg-white text-base z-50 border-2 float-left py-2 list-none text-left rounded shadow-lg min-w-48"
      v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow,
      }"
    >
      <Link
        :href="route('my-account.edit')"
        :data="{ tab: 'edit-profile' }"
        as="button"
        class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-address-card mr-3"></i>
        {{ __("MY_ACCOUNT") }}
      </Link>
      <Link
        v-if="$page.props.auth.user?.role === 'vendor'"
        :href="route('shop.show', $page.props.auth.user.uuid)"
        :data="{ tab: 'home' }"
        as="button"
        class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-store mr-3"></i>
        {{ __("MY_SHOP") }}
      </Link>
      <Link
        :href="route('my-orders.index')"
        :data="{ tab: 'all-orders' }"
        as="button"
        class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-bag-shopping mr-3"></i>
        {{ __("MY_ORDERS") }}
      </Link>

      <Link
        :href="route('return-orders.index')"
        :data="{ tab: 'requested-return-orders' }"
        as="button"
        class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-rotate-left mr-3"></i>
        {{ __("RETURN_ORDERS_AND_ITEMS") }}
      </Link>

      <Link
        :href="route('cancel-orders.index')"
        :data="{ tab: 'requested-cancel-orders' }"
        as="button"
        class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-xmark mr-3"></i>
        {{ __("CANCEL_ORDERS_AND_ITEMS") }}
      </Link>

      <Link
        :href="route('watchlist.index')"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-heart mr-3"></i>
        {{ __("MY_WATCHLIST") }}
      </Link>
      <Link
        :href="route('user.shop.followed')"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-store mr-3"></i>
        {{ __("FOLLOWED_SHOPS") }}
      </Link>

      <Link
        :href="route('logout')"
        method="post"
        as="button"
        class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
      >
        <i class="fa-solid fa-right-from-bracket mr-3"></i>

        {{ __("LOGOUT") }}
      </Link>
    </div>
  </div>
</template>

  <script>
import { Link } from "@inertiajs/vue3";
import { createPopper } from "@popperjs/core";

import image from "@/assets/img/team-1-800x800.jpg";

export default {
  components: {
    Link,
  },
  data() {
    return {
      dropdownPopoverShow: false,
      image: image,
    };
  },
  methods: {
    toggleDropdown: function (event) {
      event.preventDefault();
      if (this.dropdownPopoverShow) {
        this.dropdownPopoverShow = false;
      } else {
        this.dropdownPopoverShow = true;
        createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          placement: "bottom-start",
        });
      }
    },
  },
};
</script>
