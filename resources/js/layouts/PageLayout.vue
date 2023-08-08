<template>
<div>
    <h1 class="text-3xl my-6 container mx-auto">
        {{title}}
    </h1>
    <div class="container mx-auto">
        <slot />
    </div>

    <ToastContainer />
</div>
</template>

<script lang="ts" setup>
import {toRef} from "vue";
import {useDocumentTitle} from "@/hooks/document";
import ToastContainer from "@/components/ToastContainer.vue";

const props = defineProps<{
    title: string,
}>();

useDocumentTitle(toRef(props, 'title'));
</script>
