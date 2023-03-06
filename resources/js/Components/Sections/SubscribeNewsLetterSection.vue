<template>
  <!-- SECTION-NEWSLETTER -->
  <section class="bg-gray-100 border-t py-6">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div
        class="flex items-center flex-col lg:flex-row space-y-7 lg:space-y-0"
      >
        <!-- heading info start -->
        <div class="flex items-center mr-10">
          <div
            class="flex mr-5 items-center justify-center mr-4 rounded w-11 h-11 bg-white shadow-sm"
          >
            <i class="fa fa-envelope fa-lg text-blue-400"></i>
          </div>
          <div>
            <p class="font-semibold text-lg">Subscribe</p>
            <p class="text-sm text-gray-600">Get notified on offers</p>
          </div>
        </div>
        <!-- heading info end -->

        <!-- email start-->
        <form class="flex w-80">
          <input
            class="text-black w-full appearance-none border border-gray-200 bg-white py-2 px-3 rounded-tl-md rounded-bl-md focus:outline-none focus:border-blue-600 hover:border-gray-400"
            type="email"
            placeholder="Email"
          />
          <button
            class="px-4 py-2 text-blue-600 bg-white border border-gray-200 rounded-tr-md rounded-br-md hover:text-white hover:bg-blue-600"
          >
            Subscribe
          </button>
        </form>
        <!-- email end-->

        <!-- socials start -->
        <nav class="flex lg:ml-auto space-x-2">
          <a
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-blue-600"
            href="#"
          >
            <span class="sr-only">YouTube</span>
            <i class="w-4 fab fa-youtube"></i>
          </a>
          <a
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-blue-600"
            href="#"
          >
            <span class="sr-only">Facebook</span>
            <i class="fab fa-facebook-square"></i>
          </a>
          <a
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-blue-600"
            href="#"
          >
            <span class="sr-only">Twitter</span>
            <i class="fab fa-twitter"></i>
          </a>
          <a
            class="px-3 py-2 inline-block text-center text-gray-500 bg-white shadow-sm border border-gray-200 rounded-md hover:text-blue-600"
            href="#"
          >
            <span class="sr-only">Instagram</span>
            <i class="fab fa-instagram"></i>
          </a>
        </nav>
        <!-- socials end -->
      </div>
    </div>
    <!-- container .// -->
  </section>
  <!-- SECTION-NEWSLETTER //END -->
</template>

<script>
export default {};
</script>

<style>
</style>
