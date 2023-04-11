<template>
<CardAction v-slot="attrs">
    <button type="button" v-bind="attrs">
        <slot />
    </button>
</CardAction>
</template>

<script lang="ts" setup>
import CardAction from "@/components/cards/CardAction.vue";
</script>
