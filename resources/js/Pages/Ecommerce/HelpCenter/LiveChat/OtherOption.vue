<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
</script>
<template>
  <Head title="Other Support Options" />

  <AppLayout>
    <div class="container mx-auto mt-48 mb-10 p-10">
      <div class="flex items-center justify-center">
        <img src="../../../../assets/images/support.jpg" class="h-72" />
      </div>
      <div class="text-center text-sm text-slate-700">
        <h1 class="font-semibold mb-2">
          {{ __("SORRY_NO_AGENT_ARE_AVALIABLE_RIGHT_NOW") }}
        </h1>
        <p>
          {{ __("WE_APOLOGIZE_FOR_ANY_INCONVENIENCE") }}
        </p>
        <p class="mb-3">{{ __("PLEASE_CONSIDER_ONE_OF_THE_FOLLOWING_OPTIONS") }}:</p>

        <ul class="space-y-3">
          <li>
            <strong>1. {{ __("SEND_AN_EMAIL") }}:</strong><br />
            You can send us an email at
            <span class="text-blue-600 font-bold">support@example.com</span>.
          </li>
          <li>
            <strong>2. {{ __("FILL_OUT_A_CONTACT_FORM") }}:</strong><br />
            Visit our
            <Link href="#" class="text-blue-600 font-bold underline">
              Contact Us
            </Link>
            page and fill out the contact form.
          </li>
          <li>
            <strong>3. {{ __("VISIT_OUR_HELP_CENTER") }}:</strong><br />
            You can find answers to common questions in our
            <Link
              :href="route('help-center.index')"
              class="text-blue-600 font-bold underline"
            >
              Help Center </Link
            >.
          </li>
          <li>
            <strong>4. {{ __("CHECK_OUR_FAQS") }}:</strong><br />
            Frequently Asked Questions (FAQs) are available
            <Link
              :href="route('faqs.index')"
              class="text-blue-600 font-bold underline"
            >
              here </Link
            >.
          </li>
          <li>
            <strong>5. {{ __("CALL_US") }}:</strong><br />
            If you prefer to speak with someone, you can reach us at

            <span class="text-blue-600 font-bold">+95 9935385834</span>.
          </li>
        </ul>

        <p class="my-2 font-semibold">
          {{ __("THANK_YOU_FOR_YOUR_UNDERSTANDING") }}
        </p>
      </div>
    </div>
  </AppLayout>
</template>

