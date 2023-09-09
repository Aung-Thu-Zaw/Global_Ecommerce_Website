<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  selectedLiveChat: Object,
});
</script>

<template>
  <ul
    class="flex items-center justify-between text-sm font-medium text-center text-gray-500 w-full p-2"
  >
    <li class="">
      <Link
        as="button"
        :href="
          selectedLiveChat
            ? route('admin.live-chats.show', { uuid: selectedLiveChat.uuid })
            : route('admin.live-chats.index')
        "
        :data="{
          tab: 'all-chats',
        }"
        class="inline-block px-3 py-2.5 rounded-md border-2 text-xs transition-all shadow"
        :class="{
          'text-blue-600 bg-blue-200 border-blue-400':
            $page.props.ziggy.query.tab === 'all-chats',
          'text-slate-600 bg-slate-200 border-slate-400':
            $page.props.ziggy.query.tab !== 'all-chats',
        }"
        aria-current="page"
        >{{ __("ALL_CHATS") }}
      </Link>
    </li>
    <li class="">
      <Link
        as="button"
        :href="
          selectedLiveChat
            ? route('admin.live-chats.show', { uuid: selectedLiveChat.uuid })
            : route('admin.live-chats.index')
        "
        :data="{
          tab: 'ongoing-chats',
        }"
        class="inline-block px-3 py-2.5 hover:bg-slate-300 rounded-md border-2 text-xs transition-all shadow"
        :class="{
          'text-blue-600 bg-blue-200 border-blue-400':
            $page.props.ziggy.query.tab === 'ongoing-chats',
          'text-slate-600 bg-slate-200 border-slate-400':
            $page.props.ziggy.query.tab !== 'ongoing-chats',
        }"
        >{{ __("ONGOING_CHATS") }}
      </Link>
    </li>
    <li class="">
      <Link
        as="button"
        :href="
          selectedLiveChat
            ? route('admin.live-chats.show', { uuid: selectedLiveChat.uuid })
            : route('admin.live-chats.index')
        "
        :data="{
          tab: 'ended-chats',
        }"
        class="inline-block px-3 py-2.5 hover:bg-slate-300 rounded-md border-2 text-xs transition-all shadow"
        :class="{
          'text-blue-600 bg-blue-200 border-blue-400':
            $page.props.ziggy.query.tab === 'ended-chats',
          'text-slate-600 bg-slate-200 border-slate-400':
            $page.props.ziggy.query.tab !== 'ended-chats',
        }"
        >{{ __("ENDED_CHATS") }}
      </Link>
    </li>
  </ul>
</template>

