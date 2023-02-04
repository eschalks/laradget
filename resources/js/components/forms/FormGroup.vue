<template>

    <div class="my-5 flex items-center">
        <label class="w-32" :for="name">{{ label }}</label>
        <slot />
    </div>

</template>

<script lang="ts" setup>
const props = defineProps<{
    name: string,
    label: string,
}>();
</script>
