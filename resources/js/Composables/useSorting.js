import { usePage, router } from "@inertiajs/vue3";
import { reactive } from "vue";

export function useSorting(routeName) {
    const params = reactive({
        sort: usePage().props.ziggy.query?.sort,
        direction: usePage().props.ziggy.query?.direction,
    });

    const updateSorting = (sort = "id") => {
        params.sort = sort;
        params.direction = params.direction === "asc" ? "desc" : "asc";
        router.get(
            route(routeName),
            {
                search: usePage().props.ziggy.query?.search,
                page: usePage().props.ziggy.query?.page,
                per_page: usePage().props.ziggy.query?.per_page,
                sort: params.sort,
                direction: params.direction,
            },
            {
                replace: true,
                preserveState: true,
            }
        );
    };

    return {
        params,
        updateSorting,
    };
}
