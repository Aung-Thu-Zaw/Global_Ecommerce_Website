<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";

const props = defineProps({ collections: Object });

const collections = ref(props.collections.data);
const url = usePage().url;

const loadMoreProduct = () => {
  if (props.collections.next_page_url === null) {
    return;
  }

  router.get(
    props.collections.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["collections"],
      onSuccess: () => {
        collections.value = [...collections.value, ...props.collections.data];
        window.history.replaceState({}, "", url);
      },
    }
  );
};
</script>


<template>
  <AppLayout>
    <section class="pt-10">
      <div class="container max-w-screen-xl mx-auto px-4">
        <nav
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3"
        >
          <Link
            v-for="collection in collections"
            :key="collection.id"
            class="group border py-4 bg-slate-50 hover:shadow-lg hover:bg-slate-100 transition-all rounded-md"
            :href="route('collections.show', collection.slug)"
          >
            <div class="flex items-center justify-between">
              <div
                class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
              >
                <img
                  :src="collection.products[0].image"
                  class="h-full object-cover"
                />
              </div>

              <div
                class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
              >
                <img
                  :src="collection.products[1].image"
                  class="h-full object-cover"
                />
              </div>

              <div
                class="flex items-center justify-center w-16 h-16 mx-auto mb-2 rounded-md border overflow-hidden"
              >
                <img
                  :src="collection.products[2].image"
                  class="h-full object-cover"
                />
              </div>
            </div>

            <p
              class="text-center text-gray-600 group-hover:text-blue-600 text-md font-bold"
            >
              {{ collection.title }}
            </p>

            <p class="text-sm text-center text-secondary-600 my-2">
              {{ collection.products.length }} products
            </p>
          </Link>
        </nav>
      </div>
      <div
        v-if="props.collections.next_page_url != null"
        class="my-5 flex items-center justify-center"
      >
        <button
          @click="loadMoreProduct"
          class="border-2 border-slate-500 text-slate-600 rounded-sm px-5 py-2 shadow-md font-bold hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all"
        >
          LOAD MORE COLLECTIONS
        </button>
      </div>
      <p v-else class="my-5 text-slate-600 text-center">
        You have reached the end of the page.
      </p>
      <!-- container //end -->
    </section>
  </AppLayout>
</template>


