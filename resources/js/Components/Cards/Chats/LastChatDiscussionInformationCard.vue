<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import weekday from "dayjs/plugin/weekday";
import customParseFormat from "dayjs/plugin/customParseFormat";

dayjs.extend(weekday);
dayjs.extend(customParseFormat);
dayjs.extend(relativeTime);
defineProps({
  liveChat: Object,
});
</script>

<template>
  <div>
    <div class="flex items-center justify-between my-5">
      <div class="w-[40%] border"></div>
      <div class="text-sm font-semibold text-slate-600">
        <!-- {{ liveChat.created_at }} -->
        {{
          dayjs(liveChat.created_at, { format: "YYYY-MM-DD" }).format(
            "D-MMMM-YYYY ( dddd )"
          )
        }}
      </div>
      <div class="w-[40%] border"></div>
    </div>
    <div class="flex flex-col items-center">
      <div class="border-2 border-slate-300 p-4 rounded-md shadow">
        <div class="flex items-center justify-center mb-3">
          <img
            :src="liveChat.agent?.avatar"
            class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 shadow"
          />
          <span class="mx-3 text-xs text-slate-600">
            <i class="fa-solid fa-arrow-right-arrow-left"></i>
          </span>
          <img
            :src="liveChat.user?.avatar"
            class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 shadow"
          />
        </div>
        <div class="flex flex-col items-center">
          <p class="text-sm font-bold text-slate-600 mb-1">
            Discussed with {{ liveChat?.user?.name }}
          </p>
          <p class="text-xs text-slate-500">
            <i class="fa-solid fa-clock mr-1"></i>

            {{ dayjs(liveChat.created_at).format("h:mm A") }} To
            {{ dayjs(liveChat.ended_at).format("h:mm A") }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>



