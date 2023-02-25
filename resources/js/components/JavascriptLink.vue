<template>
<a href="javascript:void(0)" @click.stop.prevent="emit('click')">
    <slot />
</a>

</template>

<script lang="ts" setup>
const emit = defineEmits<{
    click: (event: MouseEvent) => void;
}>();
</script>
