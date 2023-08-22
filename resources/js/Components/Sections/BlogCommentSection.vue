<script setup>
import BlogCommentCard from "@/Components/Cards/BlogCommentCard.vue";
import BlogReplyCard from "@/Components/Cards/BlogReplyCard.vue";
import BlogCommentCreateForm from "@/Components/Forms/Blogs/BlogCommentCreateForm.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  blogPost: Object,
  blogComments: Object,
});
</script>

<template>
  <div class="border border-gray-200 shadow-sm rounded bg-white w-full">
    <div class="w-full">
      <p class="font-bold text-md text-slate-600 px-5 py-3 mt-3">
        {{ __("TOTAL_COMMENTS") }} ({{ blogComments.total }})
      </p>

      <!-- Blog Comments -->
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
            <BlogReplyCard :blogComment="blogComment" />
          </div>
        </div>

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

      <!-- Comment Form For Authenticated User -->
      <div
        v-if="
          $page.props.auth.user &&
          $page.props.auth.user.id !== blogPost.author_id
        "
        class="p-5"
      >
        <BlogCommentCreateForm :blogPost="blogPost" />
      </div>

      <!-- Links For Unauthenticated User -->
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
