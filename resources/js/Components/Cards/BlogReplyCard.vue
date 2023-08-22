<script setup>
import BlogCommentReplyEditForm from "@/Components/Forms/Blogs/BlogCommentReplyEditForm.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  blogComment: Object,
});

const isEditBlogCommentFormVisible = ref(false);

const handleDeleteBlogCommentReply = () => {
  router.delete(
    route("blogs.comments.reply.destroy", {
      blog_comment_reply: props.blogComment.blog_comment_reply?.id,
    }),
    {
      replace: true,
      preserveScroll: true,
    }
  );
};
</script>


<template>
  <div v-if="blogComment.blog_comment_reply" class="w-[95%] ml-auto">
    <div class="flex items-start justify-between my-3">
      <div class="flex items-center">
        <img
          :src="blogComment.blog_comment_reply?.author?.avatar"
          class="z-10 w-10 h-10 object-cover rounded-full mr-5 ring-2 ring-gray-200 shadow"
        />
        <div>
          <h4 class="text-lg font-bold text-slate-700">
            {{ blogComment.blog_comment_reply?.author?.name }}
          </h4>
          <p class="text-[.7rem] text-slate-500">Reply From Author</p>
        </div>
      </div>
      <div class="">
        <span class="text-slate-500 text-sm font-bold">
          {{ blogComment.blog_comment_reply?.updated_at }}
        </span>
      </div>
    </div>
    <p class="w-[93%] text-sm font-normal text-slate-900 ml-auto">
      {{ blogComment.blog_comment_reply?.reply_text }}
    </p>

    <!-- Edit Reply Button And Delete Reply Button For Author -->
    <div
      v-if="
        $page.props.auth.user &&
        $page.props.auth.user.id === blogComment.blog_comment_reply?.author?.id
      "
      class="flex flex-col items-end"
    >
      <div class="my-3">
        <!-- Edit Button -->
        <button
          @click="isEditBlogCommentFormVisible = !isEditBlogCommentFormVisible"
          class="font-bold border text-[.7rem] text-sky-700 px-3 py-2 rounded-sm border-sky-700 hover:bg-sky-700 hover:text-white transition-all"
        >
          <i class="fa-solid fa-edit mr-1"></i>
          {{ __("EDIT_REPLY") }}
        </button>

        <!-- Delete Button -->
        <button
          @click="handleDeleteBlogCommentReply"
          class="font-bold border text-[.7rem] text-danger-700 px-3 py-2 rounded-sm border-danger-700 hover:bg-danger-700 hover:text-white transition-all ml-3"
          type="button"
        >
          <i class="fa-solid fa-trash mr-1"></i>
          {{ __("DELETE_REPLY") }}
        </button>
      </div>

      <!-- Reply Edit Form -->
      <div v-if="isEditBlogCommentFormVisible" class="w-full">
        <BlogCommentReplyEditForm
          :blogComment="blogComment"
          @isVisible="isEditBlogCommentFormVisible = false"
        />
      </div>
    </div>
  </div>
</template>
