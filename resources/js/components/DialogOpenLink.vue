<template>
<JavascriptLink @click="dialog.open()">
    <slot />
</JavascriptLink>
</template>

<script lang="ts" setup>
import JavascriptLink from "@/components/JavascriptLink.vue";
import {useDialog} from "@/hooks/dialogs";

const dialog = useDialog();
</script>
