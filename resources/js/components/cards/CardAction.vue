<template>
<Link :href="href" class="block p-wide bg-white text-blue-500">
    <slot />
</Link>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps<{
    href: string,
}>();
</script>
