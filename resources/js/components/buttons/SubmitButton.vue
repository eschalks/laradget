<template>
    <button type="submit" class="p-wide bg-blue-500 hover:bg-blue-600 text-white disabled:bg-gray-400 disabled:text-gray-200" :disabled="disabled">
        <slot />
    </button>
</template>

<script lang="ts" setup>
const props = withDefaults(defineProps<{
    disabled?: boolean,
}>(), {
    disabled: false,
});
</script>
