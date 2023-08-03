<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { reactive } from "vue";

defineProps({
  topQuestions: Object,
  faqSubCategories: Object,
});

const params = reactive({
  search_question: usePage().props.ziggy.query?.search_question,
  page: usePage().props.ziggy.query?.page,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("help-center.questions.search"),
    {
      search_question: params.search_question,
      page: params.page,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search_question = "";
  router.get(
    route("help-center.questions.search"),
    {},
    {
      replace: true,
      preserveState: true,
    }
  );
};
</script>

<template>
  <AppLayout>
    <Head title="Phone Call" />

    <div class="min-h-[1700px] h-auto mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="text-center my-5 font-bold text-gray-700 text-2xl">
          Global E-commerce Support will call you.
        </h1>

        <div class="p-5 border shadow rounded-sm w-[500px] mx-auto mt-10">
          <form>
            <!-- Name Input -->
            <div class="mb-6">
              <InputLabel for="name" value="Name *" />

              <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                required
                placeholder="Enter Your Name"
              />

              <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
            </div>
            <!-- Email Input -->
            <div class="mb-6">
              <InputLabel for="email" value="Email *" />

              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                required
                placeholder="Enter Your Email Address"
              />

              <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
            </div>
            <!-- Phone Name Input -->
            <div class="mb-6">
              <InputLabel for="phone" value="Phone Number *" />

              <TextInput
                id="phone"
                type="text"
                class="mt-1 block w-full"
                required
                placeholder="Enter Your Phone Number"
              />

              <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

