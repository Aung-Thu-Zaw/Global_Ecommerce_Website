<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  blogPost: Object,
});

const form = useForm({
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  blog_post_id: props.blogPost?.id,
  comment: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

const handleCreateBlogComment = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("create_blog_comment");
  form.post(route("blogs.comments.store"), {
    replace: true,
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => (form.comment = ""),
  });
};
</script>

<template>
  <form @submit.prevent="handleCreateBlogComment">
    <div>
      <textarea
        cols="30"
        rows="10"
        class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
        :placeholder="__('WRITE_COMMENT')"
        v-model="form.comment"
      ></textarea>
    </div>

    <InputError class="mt-2" :message="form.errors.comment" />

    <button
      class="font-bold text-white w-full py-2 rounded-sm my-5"
      :class="{
        'bg-gray-400': !form.comment,
        'bg-blue-600 hover:bg-blue-700': form.comment,
      }"
      :disabled="!form.comment"
    >
      {{ __("SUBMIT") }}
    </button>
  </form>
</template>

