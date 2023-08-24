<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RoleInPermissionBreadcrumb.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import SaveButton from "@/Components/Buttons/SaveButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import { computed, ref } from "vue";

// Define the props
const props = defineProps({
  per_page: String,
  roles: Object,
  permissions: Object,
  permissionGroups: Object,
});

// Define Variables
const processing = ref(false);

const filterRoles = computed(() =>
  props.roles.filter((role) => !role.permissions.length)
);

const allPermissionsSelected = computed(() => {
  return form.permission_id.length === props.permissions.length;
});

// Handle Select All Button
const selectAllPermissions = () => {
  if (allPermissionsSelected.value) {
    form.permission_id = [];
  } else {
    form.permission_id = props.permissions.map((permission) => permission.id);
  }
};

// Role In Permissions Create Form Data
const form = useForm({
  role_id: "",
  permission_id: [],
  captcha_token: null,
});

// Destructing ReCaptcha
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

// Handle Create Role In Permissions
const handleCreateRoleInPermissions = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_role_in_permissions");

  processing.value = true;
  form.post(
    route("admin.role-in-permissions.store", {
      page: 1,
      per_page: props.per_page,
      sort: "id",
      direction: "desc",
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
    <Head :title="__('CREATE_ROLE_IN_PERMISSIONS')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
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
              >
                {{ __("CREATE") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <GoBackButton
            href="admin.role-in-permissions.index"
            :queryStringParams="{
              page: 1,
              per_page: props.per_page,
              sort: 'id',
              direction: 'desc',
            }"
          />
        </div>
      </div>

      <div class="border shadow-md p-10">
        <form @submit.prevent="handleCreateRoleInPermissions">
          <!-- Role Input -->
          <div class="mb-6">
            <InputLabel for="role" :value="__('ROLE') + ' *'" />

            <select
              class="p-[15px] w-full border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="form.role_id"
            >
              <option value="" selected disabled>
                {{ __("SELECT_ROLE") }}
              </option>
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

          <!-- Permissions Checkbox -->
          <div class="mb-6">
            <InputLabel for="permissions" :value="__('PERMISSIONS') + ' *'" />

            <div
              class="border w-full h-[600px] rounded-sm shadow px-10 py-5 overflow-auto scrollbar"
            >
              <div class="flex items-center mb-5 border-b pb-3">
                <div class="w-1/2">
                  <span class="font-bold text-xl text-slate-600">
                    {{ __("GROUPS") }}
                  </span>
                </div>
                <div class="w-1/2 flex items-center justify-between">
                  <span class="font-bold text-xl text-slate-600">
                    {{ __("SELECT_PERMISSIONS") }}
                  </span>

                  <span
                    @click="selectAllPermissions"
                    class="text-white rounded-sm text-sm font-bold shadow px-2 py-1 cursor-pointer"
                    :class="{
                      'bg-red-600 hover:bg-red-700': allPermissionsSelected,
                      'bg-blue-600 hover:bg-blue-700': !allPermissionsSelected,
                    }"
                  >
                    <span v-if="!allPermissionsSelected">
                      {{ __("SELECT_ALL") }}
                    </span>
                    <span v-else>{{ __("REMOVE_ALL") }}</span>
                  </span>
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

          <!-- Save Button -->
          <div class="mb-6">
            <SaveButton :processing="processing" />
          </div>
        </form>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

