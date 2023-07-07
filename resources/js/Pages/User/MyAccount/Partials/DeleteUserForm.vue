<script setup>
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import InputError from "@/Components/Forms/InputError.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import Modal from "@/Components/Forms/Modal.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: "",
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
  form.delete(route("my-account.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <section class="space-y-6">
    <header>
      <h2 class="text-lg font-medium text-gray-900">
        {{ __("DELETE_ACCOUNT") }}
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        {{
          __(
            "ONCE_YOUR_ACCOUNT_IS_DELETED_ALL_OF_ITS_RESOURCES_AND_DATA_WILL_BE_PERMANENTLY_DELETED_BEFPORE_DELETING_YOUR_ACCOUNT_PLEASE_DOWNLOAD_ANY_DATA_OR_INFORMATION_THAT_YOU_WISH_TO_RETAIN"
          )
        }}
      </p>
    </header>

    <DangerButton @click="confirmUserDeletion">
      {{ __("DELETE_ACCOUNT") }}
    </DangerButton>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          {{ __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_YOUR_ACCOUNT") }}?
        </h2>

        <div
          v-if="
            !$page.props.auth.user.google_id &&
            !$page.props.auth.user.facebook_id
          "
          class="mt-6"
        >
          <InputLabel for="password" :value="__('PASSWORD')" class="sr-only" />

          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            class="mt-1 block w-3/4"
            :placeholder="__('PASSWORD')"
            @keyup.enter="deleteUser"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal">
            {{ __("CANCEL") }}
          </SecondaryButton>

          <DangerButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="deleteUser"
          >
            {{ __("DELETE_ACCOUNT") }}
          </DangerButton>
        </div>
      </div>
    </Modal>
  </section>
</template>
