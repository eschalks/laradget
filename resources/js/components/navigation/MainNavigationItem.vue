<template>
<Link :href="href"
             class="p-wide block mr-0.5"
             :class="{'text-blue-500 bg-gray-100': isActive, 'bg-blue-600 text-white': !isActive}"
>
<slot />
</Link>
</template>

<script lang="ts" setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";
import {useCurrentUrl} from "@/hooks/page";

const props = defineProps<{
    href: string,
}>();


// get a reactive reference to the current page's url
const url = useCurrentUrl();


const isActive = computed(() => !!url.value?.startsWith(props.href));
</script>
