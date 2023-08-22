<script setup>
import InputError from "@/Components/Forms/InputError.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  blogComment: Object,
  blogPost: Object,
});

const emit = defineEmits(["isVisible"]);

const form = useForm({
  user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
  blog_post_id: props.blogPost?.id,
  comment: props.blogComment?.comment,
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleEditBlogComment = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("edit_blog_comment");
  form.patch(route("blogs.comments.update", props.blogComment.id), {
    replace: true,
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      form.comment = "";
      emit("isVisible", false);
    },
  });
};
</script>


<template>
  <div class="w-full">
    <form @submit.prevent="handleEditBlogComment">
      <div>
        <textarea
          cols="30"
          rows="10"
          class="w-full h-[200px] border-2 border-slate-400 rounded-md focus:ring-0 focus:border-slate-400"
          v-model="form.comment"
        ></textarea>
      </div>

      <InputError class="mt-2" :message="form.errors.comment" />

      <div class="flex items-center justify-end">
        <button
          type="submit"
          class="bg-blue-600 font-medium text-sm text-white min-w-[100px] max-w-[300px] py-2 rounded-sm hover:bg-blue-700 mb-3"
        >
          {{ __("UPDATE") }}
        </button>
      </div>
    </form>
  </div>
</template>


