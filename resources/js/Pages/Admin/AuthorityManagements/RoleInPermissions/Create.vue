<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RoleInPermissionBreadcrumb.vue";
import { computed, ref } from "vue";

const props = defineProps({
  per_page: String,
  roles: Object,
  permissions: Object,
  permissionGroups: Object,
});

const processing = ref(false);

const form = useForm({
  role_id: "",
  permission_id: [],
  captcha_token: null,
});

const filterRoles = computed(() =>
  props.roles.filter((role) => !role.permissions.length)
);

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleCreateRoleInPermissions = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_role_in_permissions");
  submit();
};

const submit = () => {
  processing.value = true;
  form.post(
    route("admin.role-in-permissions.store", {
      per_page: props.per_page,
    }),
    {
      replace: true,
      preserveState: true,
      onFinish: () => {
        processing.value = false;
      },
    }
  );
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Create Permission" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <Breadcrumb>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >Create</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            as="button"
            :href="route('admin.role-in-permissions.index')"
            :data="{
              per_page: props.per_page,
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleCreateRoleInPermissions">
          <div class="mb-6">
            <InputLabel for="role" value="Role *" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.role_id"
            >
              <option value="" selected disabled>Select Role</option>
              <option
                v-for="role in filterRoles"
                :key="role.id"
                :value="role.id"
              >
                {{ role.name }}
              </option>
            </select>

            <InputError class="mt-2" :message="form.errors.role_id" />
          </div>

          <hr class="mb-6" />

          <div class="mb-6">
            <InputLabel for="name" value="Permissions *" />

            <div
              class="border w-full h-[600px] rounded-sm shadow px-10 py-5 overflow-auto scrollbar"
            >
              <div class="flex items-center mb-5 border-b pb-3">
                <div class="w-1/2">
                  <span class="font-bold text-xl text-slate-600">Groups</span>
                </div>
                <div class="w-1/2 flex items-center justify-between">
                  <span class="font-bold text-xl text-slate-600"
                    >Select Permissions</span
                  >
                  <!-- <span
                    @click="isChecked = !isChecked"
                    class="text-white rounded-sm text-sm font-bold shadow px-2 py-1 cursor-pointer"
                    :class="{
                      'bg-red-600 hover:bg-red-700': isChecked === true,
                      'bg-blue-600 hover:bg-blue-700': isChecked === false,
                    }"
                  >
                    <span v-if="!isChecked"> Select All </span>
                    <span v-else> Remove All </span>
                  </span> -->
                </div>
              </div>

              <div
                v-for="permissionGroup in permissionGroups"
                :key="permissionGroup.id"
                class="flex items-start mb-5"
              >
                <div class="w-1/2">
                  <div class="flex items-center">
                    <h3 class="ml-2 text-md font-bold text-gray-600 capitalize">
                      {{ permissionGroup.group }}
                    </h3>
                  </div>
                </div>

                <div class="w-1/2">
                  <div v-for="permission in permissions" :key="permission.id">
                    <div
                      v-if="permission.group === permissionGroup.group"
                      class="flex items-center"
                    >
                      <input
                        :id="'permission-checkbox' + permission.id"
                        type="checkbox"
                        :value="permission.id"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded"
                        v-model="form.permission_id"
                      />

                      <label
                        :for="'permission-checkbox' + permission.id"
                        class="ml-2 text-sm font-medium text-gray-700 capitalize"
                      >
                        {{ permission.name }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <InputError class="mt-2" :message="form.errors.permission_id" />
          </div>

          <div class="mb-6">
            <button
              class="py-3 bg-blueGray-700 rounded-sm w-full font-bold text-white hover:bg-blueGray-800 transition-all"
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
              {{ processing ? "Processing..." : "Save" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


<style>
.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
