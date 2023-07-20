<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <footer class="bg-blue-600">
    <section class="py-10 text-white">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-wrap">
          <aside class="w-full md:w-1/3 lg:w-1/4 mb-5">
            <h2 class="text-2xl font-bold">Global Ecommerce</h2>
            <p class="my-4">
              © 2018- 2021 Templatemount. <br />
              All rights reserved.
            </p>
          </aside>
          <aside class="w-1/2 sm:w-auto flex-auto mb-5">
            <h3 class="font-semibold">Store</h3>
            <ul class="mt-2 space-y-1">
              <li>
                <Link
                  :href="route('vendor.register')"
                  class="opacity-70 hover:opacity-100"
                >
                  Join us
                </Link>
              </li>
              <li>
                <Link
                  :href="route('shop.index')"
                  class="opacity-70 hover:opacity-100"
                >
                  Find store
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Categories
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Partnership
                </Link>
              </li>
            </ul>
          </aside>
          <aside class="w-1/2 sm:w-auto flex-auto mb-5">
            <h3 class="font-semibold">About</h3>
            <ul class="mt-2 space-y-1">
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  About us
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Our history
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Our team
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Offices
                </Link>
              </li>
            </ul>
          </aside>
          <aside class="w-1/2 sm:w-auto flex-auto mb-5">
            <h3 class="font-semibold">Help</h3>
            <ul class="mt-2 space-y-1">
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Contact us
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  FAQs
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Refunds
                </Link>
              </li>
            </ul>
          </aside>
          <aside class="w-1/2 sm:w-auto flex-auto mb-5">
            <h3 class="font-semibold">Links</h3>
            <ul class="mt-2 space-y-1">
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Our terms
                </Link>
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Privacy setting</Link
                >
              </li>
              <li>
                <Link href="#" class="opacity-70 hover:opacity-100">
                  Sign up
                </Link>
              </li>
            </ul>
          </aside>
          <aside class="w-1/2 sm:w-auto lg:w-40 mb-5">
            <h3 class="font-semibold">Apps</h3>
            <a href="#" class="mt-3 inline-block">
              <img
                class="h-10"
                src="../../assets/images/btn-appstore.png"
                height="38"
              />
            </a>
            <a href="#" class="inline-block">
              <img
                class="h-10"
                src="../../assets/images/btn-market.png"
                height="38"
              />
            </a>
          </aside>
        </div>
      </div>
    </section>

    <section class="bg-blue-700 py-6 text-white">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="lg:flex justify-between">
          <div class="mb-3">
            <img
              src="../../assets/images/payments.png"
              height="24"
              class="h-6"
              alt="Payment methods"
            />
          </div>
          <div class="space-x-6">
            <nav class="text-sm space-x-4">
              <a href="#" class="opacity-70 hover:opacity-100"> Support </a>
              <a href="#" class="opacity-70 hover:opacity-100">
                Privacy &amp; Cookies
              </a>
              <a href="#" class="opacity-70 hover:opacity-100">
                Accessibility
              </a>
            </nav>
          </div>
        </div>
      </div>
    </section>
  </footer>
</template>
