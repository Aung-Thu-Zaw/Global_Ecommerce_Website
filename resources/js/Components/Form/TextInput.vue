<script setup>
import InputContainer from "@/Components/Form/InputContainer.vue";
import { onMounted, ref } from "vue";

defineProps(["modelValue", "placeholder", "type"]);

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
  if (input.value.hasAttribute("autofocus")) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <InputContainer>
    <slot name="icon" />

    <input
      class="
        p-2
        w-full
        border-transparent
        outline-none
        focus:border-transparent focus:ring-0
        placeholder:text-gray-400 placeholder:text-sm
      "
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
    />
  </InputContainer>
</template>




