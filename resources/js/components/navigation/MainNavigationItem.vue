<template>
<Link :href="href"
             class="p-wide block bg-blue-600 text-white mr-0.5"
             :class="{'text-blue-500 !bg-gray-100': $page.url.startsWith(href)}"
>
<slot />
</Link>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps<{
    href: string,
}>();
</script>
