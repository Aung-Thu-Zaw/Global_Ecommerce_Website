<script setup>
import InputError from "@/Components/Form/InputError.vue";
import InputLabel from "@/Components/Form/InputLabel.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  email: "",
  phone: "",
  address: "",
  region: "",
  city: "",
  township: "",
  additional_information: "",
});
</script>
<template>
  <div class="border shadow p-5 mb-5">
    <form action="#">
      <div class="mb-3">
        <InputLabel for="name" value="Full Name *" />

        <TextInput
          id="name"
          type="name"
          class="mt-1 block w-full"
          required
          placeholder="Enter Your Full Name"
        >
          <template v-slot:icon>
            <span>
              <i class="fa-solid fa-user text-gray-600"></i>
            </span>
          </template>
        </TextInput>

        <InputError class="mt-2" :message="form.errors.name" />
      </div>
      <div class="grid gap-6 mb-3 md:grid-cols-2">
        <div class="mb-3">
          <InputLabel for="email" value="Email *" />

          <TextInput
            id="email"
            type="email"
            class="mt-1 block w-full"
            required
            placeholder="Enter Your Email Address"
          >
            <template v-slot:icon>
              <span>
                <i class="fa-solid fa-envelope text-gray-600"></i>
              </span>
            </template>
          </TextInput>

          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mb-3">
          <InputLabel for="phone" value="Phone No *" />

          <TextInput
            id="phone"
            type="phone"
            class="mt-1 block w-full"
            required
            placeholder="Enter Your Phone Number"
          >
            <template v-slot:icon>
              <span>
                <i class="fa-solid fa-phone text-gray-600"></i>
              </span>
            </template>
          </TextInput>

          <InputError class="mt-2" :message="form.errors.phone" />
        </div>
      </div>
      <div class="grid gap-6 mb-3 md:grid-cols-3">
        <div class="mb-3">
          <InputLabel for="region" value="Region *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
          >
            <option value="" selected disabled>Select Region</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
          </select>

          <InputError class="mt-2" :message="form.errors.region" />
        </div>
        <div class="mb-3">
          <InputLabel for="city" value="City *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
          >
            <option value="" selected disabled>Select City</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
          </select>

          <InputError class="mt-2" :message="form.errors.city" />
        </div>
        <div class="mb-3">
          <InputLabel for="township" value="Township *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
          >
            <option value="" selected disabled>Select Township</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
            <option value="">Show</option>
          </select>

          <InputError class="mt-2" :message="form.errors.township" />
        </div>
      </div>

      <div class="mb-3">
        <InputLabel for="address" value="Address *" />

        <TextInput
          id="address"
          type="address"
          class="mt-1 block w-full"
          required
          placeholder="Enter Your Address"
        >
          <template v-slot:icon>
            <span>
              <i class="fa-solid fa-location-dot text-gray-600"></i>
            </span>
          </template>
        </TextInput>

        <InputError class="mt-2" :message="form.errors.address" />
      </div>

      <div class="mb-3">
        <InputLabel
          for="additional_information"
          value="Additional Information"
        />
        <textarea
          name=""
          id=""
          cols="10"
          rows="10"
          class="p-2 w-full outline-none border-slate-300 focus:outline-none focus:border-slate-300 rounded-md focus:ring-0 placeholder:text-gray-400 placeholder:text-sm"
        ></textarea>

        <InputError
          class="mt-2"
          :message="form.errors.additional_information"
        />
      </div>

      <button class="w-full bg-blue-600 py-3 font-bold text-white rounded-sm">
        Save Information
      </button>
    </form>
  </div>
</template>
