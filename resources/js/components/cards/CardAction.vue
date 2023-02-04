<template>
<InertiaLink :href="href" class="block p-wide bg-white text-blue-500">
    <slot />
</InertiaLink>
</template>

<script lang="ts" setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

const props = defineProps<{
    href: string,
}>();
</script>
