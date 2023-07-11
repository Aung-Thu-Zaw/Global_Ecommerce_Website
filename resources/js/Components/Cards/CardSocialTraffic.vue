<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  socialTraffics: Object,
});

const visibleChangeInput = ref(false);

const formatPercentage = (percentage) => {
  if (Number.isInteger(percentage)) {
    return percentage.toFixed(0);
  } else {
    return percentage.toFixed(3);
  }
};

const facebookVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[0].actual_visitors /
      props.socialTraffics[0].target_visitors) *
      100
  )
);

const instagramVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[1].actual_visitors /
      props.socialTraffics[1].target_visitors) *
      100
  )
);

const twitterVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[2].actual_visitors /
      props.socialTraffics[2].target_visitors) *
      100
  )
);

const youtubeVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[3].actual_visitors /
      props.socialTraffics[3].target_visitors) *
      100
  )
);

const redditVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[4].actual_visitors /
      props.socialTraffics[4].target_visitors) *
      100
  )
);

const linkedInVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[5].actual_visitors /
      props.socialTraffics[5].target_visitors) *
      100
  )
);

const blogVisitorProgressbar = computed(() =>
  formatPercentage(
    (props.socialTraffics[6].actual_visitors /
      props.socialTraffics[6].target_visitors) *
      100
  )
);

//  Form Data
const form = useForm({
  facebook: props.socialTraffics[0].target_visitors,
  instagram: props.socialTraffics[1].target_visitors,
  twitter: props.socialTraffics[2].target_visitors,
  youtube: props.socialTraffics[3].target_visitors,
  reddit: props.socialTraffics[4].target_visitors,
  linked_in: props.socialTraffics[5].target_visitors,
  blog: props.socialTraffics[6].target_visitors,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Visitor Target
const handleVisitorTarget = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("update_target_visitors");

  form.post(route("admin.social-traffics.change.target"), {
    replace: true,
    preserveState: true,
    preserveScroll: true,
    onSuccess: () => {
      visibleChangeInput.value = false;
    },
  });
};
</script>

<template>
  <div
    class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded border"
  >
    <div class="rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex flex-wrap items-center">
        <div
          class="relative w-full px-4 max-w-full flex-grow flex-1 flex items-center justify-between"
        >
          <h3 class="font-semibold text-base text-blueGray-700 py-1">
            {{ __("SOCIAL_TRAFFIC") }}
          </h3>
          <button
            v-if="!visibleChangeInput"
            @click="visibleChangeInput = !visibleChangeInput"
            class="text-[.8rem] text-white font-bold rounded-md bg-blue-600 hover:bg-blue-700 px-3 py-2"
          >
            Change Target
          </button>
          <button
            type="submit"
            v-if="visibleChangeInput"
            @click="handleVisitorTarget"
            class="text-[.8rem] text-white font-bold rounded-md bg-blue-600 hover:bg-blue-700 px-3 py-2"
          >
            Save
          </button>
        </div>
      </div>
    </div>
    <div class="block w-full overflow-x-auto">
      <table class="items-center w-full bg-transparent border-collapse">
        <thead class="thead-light">
          <tr>
            <th
              class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center"
            >
              {{ __("REFERRAL") }}
            </th>
            <th
              class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center"
            >
              {{ __("TARGET_VISITORS") }}
            </th>
            <th
              class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center"
            >
              {{ __("VISITORS") }}
            </th>
            <th
              class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px"
            ></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-if="socialTraffics[0].social_name === 'Facebook'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Facebook
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.facebook"
                />
              </span>
              <span v-else>
                {{ socialTraffics[0].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[0].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]"
                  >{{ facebookVisitorProgressbar }}%</span
                >
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-blue-200"
                  >
                    <div
                      :style="{ width: `${facebookVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr
            v-if="socialTraffics[1].social_name === 'Instagram'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Instagram
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.instagram"
                />
              </span>
              <span v-else>
                {{ socialTraffics[1].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[1].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]"
                  >{{ instagramVisitorProgressbar }}%</span
                >
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-pink-200"
                  >
                    <div
                      :style="{ width: `${instagramVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-pink-500"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr
            v-if="socialTraffics[2].social_name === 'Twitter'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Twitter
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.twitter"
                />
              </span>
              <span v-else>
                {{ socialTraffics[2].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[2].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]">
                  {{ twitterVisitorProgressbar }}%
                </span>
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-sky-200"
                  >
                    <div
                      :style="{ width: `${twitterVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-sky-500"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr
            v-if="socialTraffics[3].social_name === 'Youtube'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Youtube
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.youtube"
                />
              </span>
              <span v-else>
                {{ socialTraffics[3].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[3].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]"
                  >{{ youtubeVisitorProgressbar }}%</span
                >
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-red-200"
                  >
                    <div
                      :style="{ width: `${youtubeVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-600"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr
            v-if="socialTraffics[4].social_name === 'Reddit'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Reddit
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.reddit"
                />
              </span>
              <span v-else>
                {{ socialTraffics[4].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[4].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 w-[250px]"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]"
                  >{{ redditVisitorProgressbar }}%
                </span>
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-orange-200"
                  >
                    <div
                      :style="{ width: `${redditVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-orange-500"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr
            v-if="socialTraffics[5].social_name === 'Linked In'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Linked In
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.linked_in"
                />
              </span>
              <span v-else>
                {{ socialTraffics[5].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[5].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]"
                  >{{ linkedInVisitorProgressbar }}%</span
                >
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-blue-200"
                  >
                    <div
                      :style="{ width: `${linkedInVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-700"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr
            v-if="socialTraffics[6].social_name === 'Blog'"
            class="text-center"
          >
            <th
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left"
            >
              Blog
            </th>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <span v-if="visibleChangeInput">
                <input
                  type="text"
                  class="w-16 text-center text-[.8rem] h-4 rounded-sm border border-slate-400 focus:border-slate-400 focus:outline-none focus:ring-0"
                  autofocus
                  v-model="form.blog"
                />
              </span>
              <span v-else>
                {{ socialTraffics[6].target_visitors }}
              </span>
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              {{ socialTraffics[6].actual_visitors }}
            </td>
            <td
              class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"
            >
              <div class="flex items-center justify-between">
                <span class="mr-2 text-right w-[50px]"
                  >{{ blogVisitorProgressbar }}%</span
                >
                <div class="relative w-[180px]">
                  <div
                    class="overflow-hidden h-2 text-xs flex rounded bg-slate-300"
                  >
                    <div
                      :style="{ width: `${blogVisitorProgressbar}%` }"
                      class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-slate-600"
                    ></div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
