<script setup>
import { computed, inject } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  shop: Object,
  followings: Object,
  followers: Object,
});

// Define Alert Variables
const swal = inject("$swal");

// Handle User is Online Or Offline
const currentTime = new Date();
const threshold = 1000 * 60 * 3; //3minutes in millseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "active" : "offline";
};

// Filter Follower For Shop
const filterFollowing = computed(() => {
  return props.followings.filter(
    (following) => following.followable_id === props.shop.id
  );
});

// Handle Follow Shop
const handleFollow = () => {
  router.post(
    route("shop.follow", {
      shop_id: props.shop.id,
    }),
    {},
    {
      preserveScroll: true,
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};

// Handle UnFollow Shop
const handleUnFollow = async () => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want unfollow this shop?",
    text: "If you unfollow selected shop, you won't be able to view the latest arrival and sales from them anymore.",
    showCancelButton: true,
    confirmButtonText: "Yes, Unfollow!",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("shop.unfollow", {
        shop_id: props.shop.id,
      })
    );
  }
};
</script>

<template>
  <div
    class="shadow border rounded-sm p-5 mb-5 flex items-center justify-between"
  >
    <div class="flex items-center">
      <img
        :src="shop.avatar"
        alt=""
        class="w-16 h-16 rounded-full object-cover mr-5 ring-2 ring-blue-500"
      />
      <div>
        <h3 class="text-2xl font-bold text-slate-700">
          {{ shop.shop_name }}
          <span
            class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.8rem]"
          >
            <i class="fa-solid fa-circle-check"></i>
            Verified
          </span>
        </h3>
        <span class="text-sm text-slate-500 block"
          >{{ followers.length }} Followers
        </span>

        <span
          class="capitalize text-sm text-green-500 animate-pulse font-bold"
          :class="{
            ' text-green-500': status(shop.last_activity) == 'active',
            ' text-red-500': status(shop.last_activity) == 'offline',
          }"
        >
          <i class="fa-solid fa-circle animate-pulse text-[.6rem]"></i>
          {{ status(shop.last_activity) }}
        </span>
      </div>
    </div>
    <div v-if="$page.props.auth.user?.id !== shop.id">
      <button
        class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-yellow-500 hover:bg-yellow-600 text-white"
      >
        <i class="fa-solid fa-message"></i>
        Chat Now
      </button>
      <button
        v-if="filterFollowing.length"
        @click="handleUnFollow"
        class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-blue-500 hover:bg-blue-600 text-white"
      >
        <i class="fa-solid fa-check"></i>
        Following
      </button>
      <button
        v-else
        @click="handleFollow"
        class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-blue-600 hover:bg-blue-700 text-white"
      >
        <i class="fa-solid fa-store"></i>
        Follow Store
      </button>
    </div>
  </div>
</template>

