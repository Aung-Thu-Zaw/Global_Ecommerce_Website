// <script setup>
// import { useQueryStringParams } from "@/Composables/useQueryStringParams";
// import { Link } from "@inertiajs/vue3";
// import { computed } from "vue";

// const props = defineProps({
//   to: String,

//   class: {
//     type: String,
//     default: "text-white bg-blue-600 ring-2 ring-blue-300 hover:bg-blue-700",
//   },
// });

// const computedClasses = computed(() => props.class);

// const { queryStringParams } = useQueryStringParams();
// </script>

// <template>
//   <Link
//     as="button"
//     :href="route(to)"
//     :data="{
//       ...queryStringParams,
//     }"
//     class="text-xs px-4 shadow-md py-3 font-bold rounded-[4px] active:animate-press"
//     :class="computedClasses"
//   >
//     <i class="fa-solid fa-left-long"></i>
//     {{ __("Go Back") }}
//   </Link>
// </template>
