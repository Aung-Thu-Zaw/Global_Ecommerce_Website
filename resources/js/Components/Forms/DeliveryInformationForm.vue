<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
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

const processing = ref(false);

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
  processing.value = true;
  form.post(route("information.store"), {
    onFinish: () => {
      processing.value = false;
    },
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

      <button
        class="w-full bg-blue-600 py-3 font-bold text-white rounded-sm hover:bg-blue-700"
      >
        <svg
          v-if="processing"
          aria-hidden="true"
          role="status"
          class="inline w-4 h-4 mr-3 text-white animate-spin"
          viewBox="0 0 100 101"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
            fill="#E5E7EB"
          />
          <path
            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
            fill="currentColor"
          />
        </svg>
        {{ processing ? "Processing..." : "Save Information" }}
      </button>
    </form>
  </div>
</template>
