<script setup>
import { useForm, usePage, Link } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import BlogCommentCard from "@/Components/Cards/BlogCommentCard.vue";
import BlogReplyCard from "@/Components/Cards/BlogReplyCard.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";

const props = defineProps({
  blogPost: Object,
  blogComments: Object,
});

// const form = useForm({
//   user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
//   product_id: props.product.id,
//   shop_id: props.product.user_id,
//   question_text: "",
//   captcha_token: null,
// });

// const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
// const handleAskQuestion = async () => {
//   await recaptchaLoaded();
//   form.captcha_token = await executeRecaptcha("ask_question");
//   submit();
// };

// const submit = () => {
//   form.post(route("product.question.store"), {
//     replace: true,
//     preserveScroll: true,
//     onFinish: () => (form.question_text = ""),
//   });
// };
</script>

<template>
  <div class="border border-gray-200 shadow-sm rounded bg-white w-full">
    <div class="w-full">
      <p class="font-bold text-md text-slate-600 px-5 py-3">
        {{ __("TOTAL_COMMENTS") }} ({{ blogComments.total }})
      </p>

      <div v-if="blogComments.data.length" class="px-5 w-full">
        <div
          v-for="blogComment in blogComments.data"
          :key="blogComment.id"
          class="shadow relative border rounded-md p-5 flex flex-col items-start my-5 w-full"
        >
          <div class="flex flex-col items-start w-full">
            <BlogCommentCard
              :blogPost="blogPost"
              :blogComment="blogComment"
              @isVisible="handleVisible"
            />
            <BlogReplyCard :blogCommentReply="blogComment.blog_comment_reply" />
          </div>
        </div>

        <!-- Pagination -->
        <div class="my-5">
          <Pagination :links="blogComments.links" />
        </div>
      </div>
      <div v-else class="px-5 w-full">
        <p class="text-center font-bold text-slate-500 my-6">
          <i class="fa-solid fa-circle-question"></i>
          {{ __("COMMENTS_NOT_YET") }}
        </p>
      </div>

      <hr />

      <div
        v-if="
          $page.props.auth.user &&
          $page.props.auth.user?.id !== blogPost.author_id
        "
        class="p-5"
      >
        <form @submit.prevent="">
          <textarea
            cols="30"
            rows="10"
            class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
            :placeholder="__('WRITE_COMMENT')"
          ></textarea>
          <button
            class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 my-5"
          >
            {{ __("SUBMIT") }}
          </button>
        </form>
      </div>
      <div v-else-if="!$page.props.auth.user" class="px-5 my-5">
        <p class="font-bold text-sm text-slate-600 text-center">
          {{ __("IF_YOU_WANT_TO_WRITE_COMMENTS_YOU_NEED_TO_LOGIN_FIRST_HERE") }}
          <Link :href="route('login')" class="text-blue-600 underline">
            {{ __("SIGN_IN") }}
          </Link>
          {{ __("Or") }}
          <Link :href="route('register')" class="text-blue-600 underline">
            {{ __("SIGN_UP") }}
          </Link>
        </p>
      </div>
    </div>
  </div>
</template>
