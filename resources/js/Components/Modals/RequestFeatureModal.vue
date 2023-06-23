<script setup>
</script>

<template>
  <div class="flex items-start justify-between">
    <div class="px-6 py-6 lg:px-8" :class="{ 'w-1/2': true, 'w-full': false }">
      <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
        Request Features
      </h3>
      <form class="space-y-6" action="#">
        <div>
          <label
            for="email"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Your email *</label
          >
          <input
            type="email"
            name="email"
            id="email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 block w-full p-3"
            placeholder="Enter Your Email"
            required
          />
        </div>
        <div>
          <textarea
            cols="30"
            rows="10"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-gray-300 block w-full p-2.5"
            placeholder="What do you want to suggest a new feature, please write it down."
          ></textarea>
        </div>

        <div class="mb-6">
          <label
            for="email"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >Add Image</label
          >

          <input
            class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-white bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out file:-mx-3 file:-my-1.5 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-1.5 file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[margin-inline-end:0.75rem] file:[border-inline-end-width:1px] hover:file:bg-neutral-200 focus:border-primary focus:bg-white focus:text-neutral-700 focus:shadow-[0_0_0_1px] focus:shadow-primary focus:outline-none dark:bg-transparent dark:text-neutral-200 dark:focus:bg-transparent"
            type="file"
            id="image"
            @input="form.image = $event.target.files[0]"
            @change="getPreviewPhotoPath($event.target.files[0])"
          />

          <span class="text-xs text-gray-500">
            Support Format : PNG, JPG, JPEG (MAX FILE SIZE 2MB).
          </span>

          <!-- <InputError class="mt-2" :message="form.errors.image" /> -->
        </div>

        <button
          type="submit"
          class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center"
        >
          <i class="fa-solid fa-paper-plane"></i>
          Submit
        </button>
      </form>
    </div>

    <div class="h-[500px] px-6 pb-6 pt-14" :class="{ 'w-1/2': true }">
      <div
        class="w-full h-full overflow-auto scrollbar flex items-start flex-wrap"
      >
        <div class="relative mb-3 mr-3">
          <img
            src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8fDA%3D&w=1000&q=80"
            alt=""
            class="h-[100px] object-cover rounded-sm shadow-md my-3 ring-2 ring-slate-300 mr-6"
          />
          <span
            class="absolute top-0 right-4 bg-slate-300 text-slate-600 w-5 h-5 flex items-center justify-center rounded-full hover:bg-slate-500 hover:text-slate-300 transition-all"
          >
            <!-- @click="removeImage(index)" -->
            <i class="fas fa-xmark text-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
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
