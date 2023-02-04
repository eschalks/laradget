<template>
<div>
    <h1 class="text-3xl my-6 container mx-auto">
        {{title}}
    </h1>
    <div class="container mx-auto">
        <slot />
    </div>
</div>
</template>

<script lang="ts" setup>
import {toRef} from "vue";
import {useDocumentTitle} from "@/hooks/document";

const props = defineProps<{
    title: string,
}>();

useDocumentTitle(toRef(props, 'title'));
</script>
