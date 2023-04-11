<template>
    <label>
        <input type="checkbox" :checked="modelValue" @change="onToggle"> Show uncategorized only ({{
            uncategorized.length
        }})
    </label>
</template>

<script lang="ts" setup>

const props = defineProps<{
    uncategorized: unknown[],
    modelValue: boolean,
}>();

const emit = defineEmits<{
    (event: 'update:modelValue', value: boolean): void
}>();

function onToggle(e: InputEvent & { currentTarget: HTMLInputElement })
{
    emit('update:modelValue', e.currentTarget.checked);
}
</script>
