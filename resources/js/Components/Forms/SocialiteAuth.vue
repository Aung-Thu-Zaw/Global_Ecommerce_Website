<template>
  <div
    class="flex flex-col items-center justify-center w-full md:flex-row md:justify-between"
  >
    <a href="/auth/redirect/facebook" class="social-btn">
      <span class="mr-2">
        <img
          src="../../assets/images/facebook-logo-2019.ico"
          alt=""
          class="w-6"
        />
      </span>
      <span class="md:hidden"> Sign in with facebook </span>
      <span class="hidden md:block"> {{ __("SIGN_IN") }}</span>
    </a>
    <a href="/auth/redirect/google" class="social-btn">
      <span class="mr-2">
        <img src="../../assets/images/google.ico" alt="" class="w-6" />
      </span>
      <span class="md:hidden"> Sign in with google </span>
      <span class="hidden md:block">{{ __("SIGN_IN") }}</span>
    </a>
  </div>
</template>
