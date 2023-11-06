import { useFormatFunctions } from "@/Composables/useFormatFunctions";
import { useReCaptcha } from "vue-recaptcha-v3";
import { __ } from "@/Services/translations-inside-setup.js";
import { inject, reactive, ref } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";

export function useResourceActions(formFields = {}) {
    const swal = inject("$swal");
    const processing = ref(false);
    const errors = ref(null);

    // Use Format Functions
    const { formatToSnakeCase, formatToTitleCase } = useFormatFunctions();

    // URI Query String Parameters
    const queryStringParams = reactive({
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: usePage().props.ziggy.query?.sort,
        direction: usePage().props.ziggy.query?.direction,
    });

    // Dynamic Form Fields For ( Create and Edit )
    const form = useForm({ ...formFields, captcha_token: null });

    // Google ReCaptcha Version 3
    const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

    // Create Action
    const createAction = async (model, createRouteName) => {
        await recaptchaLoaded();
        form.captcha_token = await executeRecaptcha(
            `create_${formatToSnakeCase(model)}`
        );
        processing.value = true;

        router.post(
            route(createRouteName),
            {
                ...form,
                page: 1,
                per_page: queryStringParams.per_page,
                sort: "id",
                direction: "desc",
            },
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    const successMessage = usePage().props.flash.successMessage;
                    if (successMessage) {
                        swal({
                            icon: "success",
                            title: successMessage,
                        });
                    }
                },
                onFinish: () => (processing.value = false),
                onError: (backendErrors) => {
                    errors.value = backendErrors;
                },
            }
        );
    };

    // Edit Action
    const editAction = async (
        model,
        editRouteName,
        targetIdentifier,
        method = "patch"
    ) => {
        await recaptchaLoaded();
        form.captcha_token = await executeRecaptcha(
            `edit_${formatToSnakeCase(model)}`
        );
        processing.value = true;

        router.post(
            route(editRouteName, {
                [formatToSnakeCase(model)]: targetIdentifier,
            }),
            {
                _method:
                    method === "put" || method === "patch" ? method : undefined,
                ...form,
                ...queryStringParams,
            },
            {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    const successMessage = usePage().props.flash.successMessage;
                    if (successMessage) {
                        swal({
                            icon: "success",
                            title: successMessage,
                        });
                    }
                },
                onFinish: () => (processing.value = false),
                onError: (backendErrors) => {
                    errors.value = backendErrors;
                },
            }
        );
    };

    // Soft Delete Action
    const softDeleteAction = async (
        model,
        deleteRouteName,
        targetIdentifier
    ) => {
        const result = await swal({
            icon: "question",
            title: `Delete ${formatToTitleCase(model)}`,
            text: `Are you sure you want to delete this? It can be restored within 60 days.`,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d52222",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.delete(
                route(deleteRouteName, {
                    [formatToSnakeCase(model)]: targetIdentifier,
                    ...queryStringParams,
                }),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;
                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    // Selected Soft Delete Action
    const selectedSoftDeleteAction = async (
        model,
        deleteRouteName,
        selectedItems
    ) => {
        const result = await swal({
            icon: "question",
            title: `Delete Selected ${formatToTitleCase(model)}`,
            text: `Are you sure you want to delete these ${model.toLowerCase()}? This action can be undone within 60 days.`,
            showCancelButton: true,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d52222",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.delete(
                route(deleteRouteName, {
                    selectedItems,
                    ...queryStringParams,
                }),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;
                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    // Soft Delete All Action
    const softDeleteAllAction = async (model, deleteRouteName) => {
        const result = await swal({
            icon: "question",
            title: `Delete All ${formatToTitleCase(model)}`,
            text: `Are you sure you want to delete all ${model.toLowerCase()}? This action can be undone within 60 days.`,
            showCancelButton: true,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d52222",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.delete(
                route(deleteRouteName, {
                    ...queryStringParams,
                }),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;
                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    // Restore Action
    const restoreAction = async (model, restoreRouteName, targetIdentifier) => {
        const result = await swal({
            icon: "question",
            title: `Restore ${formatToTitleCase(model)}`,
            text: `Are you sure you want to restore this?`,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#2562c4",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.post(
                route(restoreRouteName, {
                    id: targetIdentifier,
                }),
                {
                    ...queryStringParams,
                },
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;

                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    // Permanent Delete Action
    const permanentDeleteAction = async (
        model,
        deleteRouteName,
        targetIdentifier
    ) => {
        const result = await swal({
            icon: "question",
            title: `Permanently Delete ${formatToTitleCase(model)}`,
            text: `This action cannot be undone. Are you sure you want to permanently delete this?`,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d52222",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.delete(
                route(deleteRouteName, {
                    id: targetIdentifier,
                    ...queryStringParams,
                }),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;
                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    // Selected Permanent Delete Action
    const permanentDeleteSelectedAction = async (
        model,
        deleteRouteName,
        selectedItems
    ) => {
        const result = await swal({
            icon: "question",
            title: `Permanently Delete Selected ${formatToTitleCase(model)}`,
            text: `This action will permanently delete the selected ${model.toLowerCase()} items. Are you sure you want to proceed? This action cannot be undone.`,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d52222",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.delete(
                route(deleteRouteName, {
                    selectedItems,
                    ...queryStringParams,
                }),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;
                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    // Permanent Delete All Action
    const permanentDeleteAllAction = async (model, deleteRouteName) => {
        const result = await swal({
            icon: "question",
            title: `Permanently Delete All ${formatToTitleCase(model)}`,
            text: `This action cannot be undone. Are you sure you want to permanently delete all items in the trash?`,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#d52222",
            cancelButtonColor: "#626262",
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true,
        });

        if (result.isConfirmed) {
            router.delete(
                route(deleteRouteName, {
                    ...queryStringParams,
                }),
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        const successMessage =
                            usePage().props.flash.successMessage;
                        if (successMessage) {
                            swal({
                                icon: "success",
                                title: successMessage,
                            });
                        }
                    },
                }
            );
        }
    };

    return {
        form,
        processing,
        createAction,
        editAction,
        softDeleteAction,
        selectedSoftDeleteAction,
        softDeleteAllAction,
        restoreAction,
        permanentDeleteAction,
        permanentDeleteSelectedAction,
        permanentDeleteAllAction,
        errors,
    };
}
