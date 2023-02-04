<template>
<div class="p-wide bg-blue-500 flex items-center">
    <h2 class="flex-1 text-white">{{ title }}</h2>
    <div class="flex-shrink-0"><slot name="actions" /></div>
</div>
</template>

<script lang="ts" setup>
const props = defineProps<{
    title: string,
}>();
</script>
