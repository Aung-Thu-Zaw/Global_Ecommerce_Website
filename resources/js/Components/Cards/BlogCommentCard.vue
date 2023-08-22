<script setup>
import BlogCommentReplyCreateForm from "@/Components/Forms/Blogs/BlogCommentReplyCreateForm.vue";
import BlogCommentEditForm from "@/Components/Forms/Blogs/BlogCommentEditForm.vue";
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  blogPost: Object,
  blogComment: Object,
});

const isEditCommentFormVisible = ref(false);
const isReplyFormVisible = ref(false);
const authenticatedUser = ref(
  usePage().props.auth.user ? usePage().props.auth.user : null
);

const handleDeleteBlogComment = () => {
  router.delete(
    route("blogs.comments.destroy", {
      blog_comment: props.blogComment?.id,
    }),
    {
      replace: true,
      preserveScroll: true,
    }
  );
};
</script>

<template>
  <div class="relative w-full">
    <!-- Comment -->
    <div class="flex flex-col items-end w-full">
      <div class="flex items-start justify-between w-full mb-1">
        <div class="flex items-start">
          <img
            :src="blogComment.user?.avatar"
            class="z-10 w-10 h-10 object-cover rounded-full mr-5 ring-2 ring-gray-200 shadow"
          />
          <div>
            <h4 class="text-lg font-bold text-slate-700">
              {{ blogComment.user?.name }}
            </h4>
            <p class="text-[.7rem] text-slate-500">Comment From User</p>
          </div>
        </div>

        <span class="text-slate-500 text-sm font-bold">
          {{ blogComment.updated_at }}
        </span>
      </div>

      <p class="w-[93%] text-sm font-normal text-slate-900 ml-auto mb-3">
        {{ blogComment.comment }}
      </p>
    </div>

    <!-- Reply Comment Button For Author -->
    <div
      v-if="
        !blogComment.blog_comment_reply &&
        authenticatedUser &&
        blogPost.author_id === authenticatedUser.id
      "
      class="my-3 flex items-center justify-end w-full"
    >
      <button
        @click="isReplyFormVisible = !isReplyFormVisible"
        class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
      >
        <i class="fa-solid fa-flag"></i>
        {{ __("REPLY_THIS_COMMENT") }}
      </button>
    </div>

    <!-- Edit Comment Button And Delete Comment Button For Commenter -->
    <div
      v-if="authenticatedUser && authenticatedUser.id === blogComment.user_id"
      class="mb-3 flex items-center justify-end w-full"
    >
      <button
        v-if="!blogComment.blog_comment_reply"
        @click="isEditCommentFormVisible = !isEditCommentFormVisible"
        class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
      >
        <i class="fa-solid fa-edit mr-1"></i>
        {{ __("EDIT_COMMENT") }}
      </button>

      <button
        @click="handleDeleteBlogComment"
        class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
        type="button"
      >
        <i class="fa-solid fa-trash mr-1"></i>
        {{ __("DELETE_COMMENT") }}
      </button>
    </div>

    <!-- Edit Comment Form For Commenter -->
    <div v-if="isEditCommentFormVisible" class="w-full">
      <BlogCommentEditForm
        :blogComment="blogComment"
        :blogPost="blogPost"
        @isVisible="isEditCommentFormVisible = false"
      />
    </div>

    <!-- Reply Comment Form For Author -->
    <div v-if="isReplyFormVisible" class="w-full">
      <BlogCommentReplyCreateForm
        :blogComment="blogComment"
        @isVisible="isReplyFormVisible = false"
      />
    </div>

    <hr v-if="blogComment.blog_comment_reply" class="my-3" />
  </div>
</template>
