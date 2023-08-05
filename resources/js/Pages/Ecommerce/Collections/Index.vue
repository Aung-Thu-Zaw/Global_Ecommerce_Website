<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CollectionCard from "@/Components/Cards/CollectionCard.vue";
import { ref } from "vue";
import { usePage, router, Head } from "@inertiajs/vue3";

const props = defineProps({
  collections: Object,
});

const isLoading = ref(false);

const collections = ref(props.collections?.data);

const url = usePage().url;

// Handle Load More Button
const loadMoreCollection = () => {
  if (props.collections.next_page_url === null) {
    return;
  }

  isLoading.value = true;

  router.get(
    props.collections.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["collections"],
      onSuccess: () => {
        isLoading.value = false;
        collections.value = [...collections.value, ...props.collections.data];
        window.history.replaceState({}, "", url);
      },
    }
  );
};
</script>

<template>
  <AppLayout>
    <Head :title="__('ALL_COLLECTIONS')" />
    <section class="pt-10 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <!-- Collections Card -->
        <div
          v-if="collections"
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3"
        >
          <CollectionCard :collections="collections" />
        </div>
        <div v-else>
          <p class="text-center text-xl font-bold text-red-600 animate-bounce">
            {{ __("NO_COLLECTION_FOUND") }}!
          </p>
        </div>
      </div>
      <div
        v-if="props.collections.next_page_url != null"
        class="my-5 flex items-center justify-center"
      >
        <!-- Loading Animation  -->
        <img
          v-if="isLoading"
          src="../../../assets/images/loading.gif"
          class="w-14 h-14"
          alt=""
        />

        <!-- Load More Button  -->
        <button
          v-else
          @click="loadMoreCollection"
          class="border-2 border-slate-500 text-slate-600 rounded-sm px-5 py-2 shadow-md font-bold hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all"
        >
          {{ __("LOAD_MORE_COLLECTIONS") }}
        </button>
      </div>
      <p v-else class="my-5 text-slate-600 text-center">
        {{ __("YOU_HAVE_REACH_THE_END_OF_THE_PAGE") }}
      </p>
    </section>
  </AppLayout>
</template>


