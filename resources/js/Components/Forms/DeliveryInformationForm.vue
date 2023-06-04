<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  countries: Object,
  regions: Object,
  cities: Object,
  townships: Object,
  deliveryInformation: Object,
});

const form = useForm({
  user_id: usePage().props.auth.user.id,
  name: props.deliveryInformation ? props.deliveryInformation.name : "",
  email: props.deliveryInformation ? props.deliveryInformation.email : "",
  phone: props.deliveryInformation ? props.deliveryInformation.phone : "",
  address: props.deliveryInformation ? props.deliveryInformation.address : "",
  country: props.deliveryInformation ? props.deliveryInformation.country : "",
  region: props.deliveryInformation ? props.deliveryInformation.region : "",
  city: props.deliveryInformation ? props.deliveryInformation.city : "",
  township: props.deliveryInformation ? props.deliveryInformation.township : "",
  postal_code: props.deliveryInformation
    ? props.deliveryInformation.postal_code
    : "",
  additional_information: props.deliveryInformation
    ? props.deliveryInformation.additional_information
    : "",
  captcha_token: null,
});

const filterRegions = computed(() => {
  if (!form.country) {
    return props.regions;
  }

  return props.regions.filter((region) => region.country.name === form.country);
});

const filterCities = computed(() => {
  if (!form.region) {
    return props.cities;
  }

  return props.cities.filter((city) => city.region.name === form.region);
});

const filterTownships = computed(() => {
  if (!form.city) {
    return props.townships;
  }

  return props.townships.filter((township) => township.city.name === form.city);
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleDeliveryInformation = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_delivery_information");
  submit();
};

const submit = () => {
  form.post(route("information.store"), {
    onFinish: () => form.reset(),
    onSuccess: () => {
      // Success flash message
      if (usePage().props.flash.successMessage) {
        toast.success(usePage().props.flash.successMessage, {
          autoClose: 2000,
        });
      }
    },
  });
};
</script>
<template>
  <div class="border shadow p-5 mb-5">
    <form @submit.prevent="handleDeliveryInformation">
      <div class="mb-3">
        <InputLabel for="name" value="Full Name *" />

        <TextInput
          id="name"
          type="name"
          class="mt-1 block w-full"
          v-model="form.name"
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
            v-model="form.email"
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
            v-model="form.phone"
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
      <div class="grid gap-6 mb-3 md:grid-cols-2">
        <div class="mb-3">
          <InputLabel for="country" value="Country *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="form.country"
          >
            <option value="" selected disabled>Select Country</option>
            <option
              v-for="country in countries"
              :key="country.id"
              :value="country.name"
            >
              {{ country.name }}
            </option>
          </select>

          <InputError class="mt-2" :message="form.errors.country" />
        </div>
        <div class="mb-3">
          <InputLabel for="region" value="Region *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="form.region"
            :disabled="!form.country"
          >
            <option value="" selected disabled>Select Region</option>
            <option
              v-for="region in filterRegions"
              :key="region.id"
              :value="region.name"
            >
              {{ region.name }}
            </option>
          </select>

          <InputError class="mt-2" :message="form.errors.region" />
        </div>
      </div>
      <div class="grid gap-6 mb-3 md:grid-cols-3">
        <div class="mb-3">
          <InputLabel for="city" value="City *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="form.city"
            :disabled="!form.region"
          >
            <option value="" selected disabled>Select City</option>
            <option
              v-for="city in filterCities"
              :key="city.id"
              :value="city.name"
            >
              {{ city.name }}
            </option>
          </select>

          <InputError class="mt-2" :message="form.errors.city" />
        </div>

        <div class="mb-3">
          <InputLabel for="township" value="Township *" />

          <select
            class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="form.township"
            :disabled="!form.city"
          >
            <option value="" selected disabled>Select Township</option>
            <option
              v-for="township in filterTownships"
              :key="township.id"
              :value="township.name"
            >
              {{ township.name }}
            </option>
          </select>

          <InputError class="mt-2" :message="form.errors.township" />
        </div>

        <div class="mb-3">
          <InputLabel for="postal_code" value="Postal Code *" />

          <TextInput
            id="postal_code"
            type="postal_code"
            class="mt-1 block w-full"
            v-model="form.postal_code"
            placeholder="Enter Postal Code"
          />

          <InputError class="mt-2" :message="form.errors.postal_code" />
        </div>
      </div>

      <div class="mb-3">
        <InputLabel for="address" value="Address *" />

        <TextInput
          id="address"
          type="address"
          class="mt-1 block w-full"
          required
          v-model="form.address"
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
          v-model="form.additional_information"
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
