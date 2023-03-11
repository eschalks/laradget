<template>
<span class="tabular-nums">
    &euro;
    {{ formattedAmount}}
</span>
</template>

<script lang="ts" setup>
import {computed} from "vue";

const props = defineProps<{
    amount?: string|null,
}>();

const formattedAmount = computed(() => {
    if (props.amount === null || typeof props.amount === 'undefined') {
        return '0.00';
    }

    return props.amount;
});

</script>
