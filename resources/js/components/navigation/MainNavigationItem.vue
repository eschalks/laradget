<template>
<InertiaLink :href="href"
             class="p-wide block bg-blue-600 text-white mr-0.5"
             :class="{'text-blue-500 !bg-gray-100': $page.url.startsWith(href)}"
>
<slot />
</InertiaLink>
</template>

<script lang="ts" setup>
import {InertiaLink} from "@inertiajs/inertia-vue3";

const props = defineProps<{
    href: string,
}>();
</script>
