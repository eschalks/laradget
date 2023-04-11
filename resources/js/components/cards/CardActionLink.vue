<template>
<CardAction v-slot="attrs">
    <Link :href="href" v-bind="attrs">
        <slot />
    </Link>
</CardAction>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';
import CardAction from "@/components/cards/CardAction.vue";

const props = defineProps<{
    href?: string,
}>();
</script>
